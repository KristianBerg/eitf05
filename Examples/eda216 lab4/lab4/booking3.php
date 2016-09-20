<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	
	$db->openConnection();
	
	$movieName = $_REQUEST['movieName'];
	$pDate = $_REQUEST['movieDate'];
	$theaterName = $db->getTheater($movieName, $pDate);
	$availabelSeats = $db->getAvailabelSeats($movieName, $pDate);
	$db->closeConnection();
?>

<html>
<head><title>Booking 3</title><head>
<body><h1>Booking 3</h1>
	Current user: <?php print $userId ?>
	<p>
	Data for selected performance:
	<p>
	<form method=post action="booking4.php">
		Movie: <?php print $movieName ?>
		<p>
		Date: <?php print $pDate ?>
		<p>
		Theater: <?php print $theaterName ?>
		<p>
		Free seats: <?php print $availabelSeats ?>
		<p>
		<input name="movieName" type="hidden" value="<?php print $movieName ?>">
		<input name="movieDate" type="hidden" value="<?php print $pDate ?>">
		<input name="seats" type="hidden" value="<?php print $availabelSeats ?>">
		<input type=submit value="Book ticket">
	</form>
</body>
</html>
