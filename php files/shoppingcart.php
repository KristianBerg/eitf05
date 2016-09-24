<?php
  if(!isset($_SESSION['noItem1'])){
    $_SESSION['noItem1'] = 0;
    $_SESSION['noItem2'] = 0;
  }

  $itemsAdded = 0;
  if(isset($_POST["noItem1"]) && $_POST["noItem1"] > 0){
    $_SESSION['noItem1'] += $_POST['noItem1'];
    $itemsAdded = $_POST['noItem1'];
    $_POST['noItem1'] = 0;
  } else if(isset($_POST["noItem2"]) && $_POST["noItem2"] > 0){
    $_SESSION['noItem2'] += $_POST['noItem2'];
    $itemsAdded = $_POST['noItem2'];
    $_POST['noItem2'] = 0;
  }
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
