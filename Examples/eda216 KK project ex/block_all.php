<?php
require_once ('database.inc.php');
require_once ("mysql_connect_data.inc.php");

$db = new Database ( $host, $userName, $password, $database );
$db->openConnection ();

$cookie = $_POST ['result'];


if (! $db->userExists ( $userId )) {
	$db->closeConnection ();
	header ( "Location: noSuchUser.html" );
	exit ();
}
$db->closeConnection ();

session_start ();
$_SESSION ['db'] = $db;
$_SESSION ['userId'] = $userId;
header ( "Location: main.html" );
?>
