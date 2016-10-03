<?php
  session_start();
  $db = $_SESSION['db'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $home_address = $_POST['home_address'];
  $db->registerUser($username, $password, $home_address);
  header("signin.php?userCreated=" . true);
?>
