<?php
  require_once("database.inc.php");
  session_start();
  $db = $_SESSION['db'];
  $db->openConnection();
  $username = $_SESSION['username'];
  $nrOfProducts = $_SESSION['nrOfProducts'];
  $index = 0;
  $itemsAdded = 0;
  while($index < $nrOfProducts) {
    if(!isset($_SESSION['noItem' . $index])) {
      $_SESSION['noItem' . $index] = 0;
    } else if($_REQUEST['noItem' . $index] > 0) {
      $_SESSION['noItem' . $index] = $_SESSION['noItem' . $index] + $_REQUEST['noItem' . $index];
      $itemsAdded = $_REQUEST['noItem'  . $index];
      $_REQUEST['noItem'  . $index] = 0;
      $db->addToCart($username, $index, $_SESSION['noItem'  . $index]);
    }
    $index++;
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
