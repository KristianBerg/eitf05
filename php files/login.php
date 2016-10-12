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
	if($db->numberLogins($username) == -1) {
		$db->closeConnection();
		header("Location: index.php?userLocked=" . true);
		exit();
	}
	if (!$db->userExists($username, $password)) {
		if($db->usernameExists($username)){
			if($db->numberLogins($username) > 5){
				$db->blockUser($username);
			} else {
				$db->userFailedLogin($username);
			}
		}
		$db->closeConnection();
		header("Location: index.php?noSuchUser=" . true);
		exit();
	}
	$db->resetUser($username); //Resets Login Counter "LoginAtempts"
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
	$_SESSION['csrftoken'] = rand();
	header("Location: storepage.php");
	exit();
?>
