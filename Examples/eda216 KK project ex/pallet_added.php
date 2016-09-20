<?php
require_once ('database.inc.php');

session_start ();
$db = $_SESSION ['db'];
$db->openConnection ();

$cookie = $_GET ['cookie'];
$amount = $_GET ['amount'];

$count = $db->createPallets ( $cookie, $amount );

if ($count == 0) {
	echo "<div class=\"col-lg-4\"><h3>No pallets were created...  <h3></div>";
} else {
	echo "<div class=\"col-lg-4\"><h3> $count / $amount pallets where created </h3></div>";
}

$db->closeConnection ();

?>




<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>


	<div class="col-lg-4">

		<form role="form" action="pallet_adding.php">
			<input type="submit" class="btn btn-success" value="Back">
		</form>


	</div>
</body>



</html>

