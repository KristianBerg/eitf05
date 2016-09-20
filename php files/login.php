<?php
	require_once('database.inc.php');
	require_once("mysql_connect_data.inc.php");

	$db = new Database($host, $userName, $password, $database);
	$db->openConnection();
	if (!$db->isConnected()) {
	//	header("Location: cannotConnect.html");
    if(!isset($_SESSION['counter'])) {
      $_SESSION['counter'] = 1;
    }
    header("Location: signin.php");
		exit();
	}

	$userId = $_REQUEST['userId'];
	if (!$db->userExists($userId)) {
		$db->closeConnection();
		header("Location: noSuchUser.html"); //Ändra
		exit();
	}
	$db->closeConnection();

	$_SESSION['db'] = $db;
	$_SESSION['userId'] = $userId;
	header("Location: booking1.php"); //Ändra
?>
