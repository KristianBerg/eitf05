<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$db->openConnection();
	
	$movieName = $_REQUEST['movieName'];
	$movieDates = $db->getMovieDates($movieName);
	$db->closeConnection();
?>

<html>
<head><title>Booking 2</title><head>
<body><h1>Booking 2</h1>
	Current user: <?php print $userId ?>
	<p>
	Selected movie: <?php print $movieName ?>
	<p>
	Performance dates:
	<p>
	<form method=post action="booking3.php">
		<select name="movieDate" size=10>
		<?php
			$first = true;
			foreach ($movieDates as $date) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $date;
			}
		?>
		</select>		
		<input name="movieName" type="hidden" value="<?php print $_REQUEST['movieName'] ?>">
		<input type=submit value="Select date">
	</form>
</body>
</html>
