<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	
	$db->openConnection();
	$movieName = $_REQUEST['movieName'];
	$pDate = $_REQUEST['movieDate'];
	$seats = $_REQUEST['seats'];
	$bookingNum = $db->reserveTicket($movieName, $pDate, $userId);
	
	$db->closeConnection();
?>

<html>
<head><title>Booking 4</title><head>
<body><h1>Booking 4</h1>
	<?php
	if($bookingNum > 0){
		print "One ticket booked: booking number is: ";
		print $bookingNum;
	
	} else {
		print "Cant book a ticket, the salong is full!";
	}
	?>
	
	<form method=post action="booking1.php">
		<input type=submit value="Next booking">
	</form>
</body>
</html>
