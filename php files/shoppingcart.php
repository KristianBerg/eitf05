<?php
  require_once("database.inc.php");

  session_start();
  $db = $_SESSION['db'];
  $db->openConnection();
  $username = $_SESSION['username'];

  //Bör fixas så den ej är begränsad till 2 produkter.
  if(!isset($_SESSION['noItem0'])){
    $_SESSION['noItem0'] = 0;
  }
  if(!isset($_SESSION['noItem1'])){
    $_SESSION['noItem1'] = 0;
  }

  $itemsAdded = 0;
  if($_POST["noItem0"] > 0){
    $_SESSION['noItem0'] = $_SESSION['noItem0'] + $_POST['noItem0'];
    $itemsAdded = $_POST['noItem0'];
    $_POST['noItem0'] = 0;
    $db->addToCart($username, 0, $_SESSION['noItem0']);
  } else if($_POST["noItem1"] > 0){
    $_SESSION['noItem1'] = $_SESSION['noItem1'] + $_POST['noItem1'];
    $itemsAdded = $_POST['noItem1'];
    $_POST['noItem1'] = 0;
    $db->addToCart($username, 1, $_SESSION['noItem1']);
  }
  $db->closeConnection();
  header('location: storepage.php?itemsAdded=' . $itemsAdded);
?>

<!--
<html>
<head></head>
<body>

<h2> This is your shopping cart! </h2>
<h3> Items in shopping cart </h3>


</body>
</html>
-->
