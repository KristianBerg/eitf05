<?php
	require_once('database.inc.php');

	session_start();
	if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > 9000)) {
		// last request was more than X seconds ago
		session_unset();     // unset $_SESSION variable for the run-time
		session_destroy();   // destroy session data in storage
	}
	$_SESSION['lastActivity'] = time(); //Update last activity time stamp

	if(!isset($_SESSION["username"]) ){	//kollar om man verkligen varit i en session innan
		header("location: index.php?timeout=" . true);
		exit(); //så att php koden inte går att bypassa
	}
	$db = $_SESSION['db'];
	$username = $_SESSION['username'];
?>

<html>
<head><?php echo "<h3>" . $username . "</h3>" ?></head>
<body>
	<h2> Welcome to the store! (TM) </h2>
	<?php if(isset($_GET['itemsAdded'])){ echo "<p>" . $_GET['itemsAdded'] . " items added to cart </p>"; } ?>
	<h4> Available items: </h4>
	<?php
		$db->openConnection();
		$products = $db->getProducts();
		$_SESSION['products'] = $products;
		$db->closeConnection();
		$index = 0;
		while($index < count($products)) {
			echo "<img src='" . $products[$index]['Image_src'] . "' style='width:200;height:200;'> <br>";
			echo "<form action='shoppingcart.php' method='post'> <br>";
			echo "Number of " . $products[$index]['Prod_name'] . ": <input type='text' name='noItem" . $index . "'><input type='submit'><br>";
			$index++;
		}
	?>
	<br>
	<a href = "checkout.php"> Go to checkout </a> <br>
</body>
</html>
