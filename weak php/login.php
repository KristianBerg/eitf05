<?php
	session_start();
	require_once('database.inc.php');
	require_once("mysql_connect_data.inc.php");

	$db = new Database($host, $userName, $password, $database);
	$db->openConnection();
	if (!$db->isConnected()) {
		header("Location: index.php");
		exit();
	}

	if(isset($_REQUEST['register'])) {
		$db->closeConnection();
		$_SESSION['db'] = $db;
		header("Location: register.php");
		exit();
	}

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	if (!$db->userExists($username, $password)) {
		$db->closeConnection();
		header("Location: index.php?noSuchUser=" . true);
		exit();
	}
	$cart = $db->getCart($username);
	$db->closeConnection();
	$index = 0;
	while($index < count($cart)) {
		if(!empty($cart[$index])) {
			$_SESSION['noItem' . $index] = $cart[$index]['Quantity'];
		} else {
			$_SESSION['noItem' . $index] = 0;
		}
		$index++;
	}
	$_SESSION['db'] = $db;
	$_SESSION['username'] = $username;
	header("Location: storepage.php");
	exit();
?>