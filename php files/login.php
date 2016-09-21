<?php
	require_once('database.inc.php');
	require_once("mysql_connect_data.inc.php");

	$db = new Database($host, $userName, $password, $database);
	$db->openConnection();
	if (!$db->isConnected()) {
		header("Location: signin.php");
		exit();
	}

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	if (!$db->userExists($username, $password)) {
		$db->closeConnection();
		header("Location: noSuchUser.html"); //Ändra
		exit();
	}
	$db->closeConnection();

	$_SESSION['db'] = $db;
	$_SESSION['username'] = $username;
	header("Location: storepage.php"); //Ändra
?>
