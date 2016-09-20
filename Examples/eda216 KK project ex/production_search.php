<?php
require_once ('database.inc.php');

session_start ();
$db = $_SESSION ['db'];
$db->openConnection ();

$cookie = $_GET ['cookie'];
$start_date = $_GET ['start_date'];
$end_date = $_GET ['end_date'];
$pallet_id = $_GET ['pallet_id'];
$block = $_GET ['block'];

$block_button = $_POST ['block_button'];

$result = $db->getProductionSearchResult ( $cookie, $start_date, $end_date, $pallet_id, $block );

if ($block_button == "unblock_all") {
	
	$db->unBlock ( $result );
	
	$result = $db->getProductionSearchResult ( $cookie, $start_date, $end_date, $pallet_id, $block );
}
if ($block_button == "block_all") {
	
	$db->block ( $result );
	
	$result = $db->getProductionSearchResult ( $cookie, $start_date, $end_date, $pallet_id, $block );
}

$colNames = array ();

if ($result == null) {
	
	echo "<div class=\"col-lg-4\"><h3>No search results found... </h3></div>";
} else {
	
	$colNames = array_keys ( reset ( $result ) );
	
	$count = 0;
	foreach ( $result as $row ) {
		$count += 1;
	}
	echo "<div class=\"col-lg-4\"><h3>Search result:</div></h3 >";
	echo "<div class=\"col-lg-4\"><h5>$count Pallets found</div></h5>";
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

	<table class="table">
	
			<?php
			
			echo "<tr>";
			
			echo "<th>$colNames[0]</th>";
			echo "<th>$colNames[2]</th>";
			echo "<th>$colNames[4]</th>";
			echo "<th>$colNames[6]</th>";
			echo "<th>$colNames[8]</th>";
			
			echo "</tr>";
			
			foreach ( $result as $row ) {
				
				echo "<tr>";
				echo "<td> $row[0] </td>";
				echo "<td> $row[1] </td>";
				echo "<td> $row[2] </td>";
				echo "<td> $row[3] </td>";
				echo "<td> $row[4] </td>";
				
				echo "</tr>";
			}
			
			?>

	</table>

	<form method="post" role="form">
		<input type="hidden" value="block_all" name="block_button"> <input
			type="submit" class="btn btn-sm btn-danger" value="Block all!">
	</form>
	<form method="post" role="form">
		<input type="hidden" value="unblock_all" name="block_button"> <input
			type="submit" class="btn btn-sm btn-warning" value="Unblock all!">

	</form>

	<form role="form" action="search.php">
		<input type="submit" class="btn btn-sm btn-success" value="Back">
	</form>


	</div>
</body>



</html>

