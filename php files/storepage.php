<?php
	require_once('database.inc.php');

	session_start();
	
	if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > 3)) {
		// last request was more than X seconds ago
		session_unset();     // unset $_SESSION variable for the run-time 
		session_destroy();   // destroy session data in storage
	}
	$_SESSION['lastActivity'] = time(); //Update last activity time stamp
	
	if( !isset($_SESSION["username"]) ){	//kollar om man verkligen varit i en session innan
		header("location: signin.php?timeout=" . true);
		exit(); //så att php koden inte går att bypassa
	}
	$db = $_SESSION['db'];
	$username = $_SESSION['username'];
	$db->openConnection();
	
	$db->closeConnection();
?>

<html>
<head><?php echo "<h3>" . $username . "</h3>" ?></head>
<body>
	<h2> Welcome to the store! (TM) </h2>
	<h4> Available items: </h4>

	<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fd/Maple_Leaf.svg/2000px-Maple_Leaf.svg.png" alt="dank leaf" style="width:200; height:200;"> <br>
	<form action = "shoppingcart.php" method = "post">
	Number of cannadis: <input type="text" name="noItem1">
	<input type = "submit"><br>
	<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Linear_subspaces_with_shading.svg/2000px-Linear_subspaces_with_shading.svg.png" alt="trippin" style="width:200; height: 200"> <br>
	<form action = "shoppingcart.php" method = "post">
	Number of lines: <input type="text" name="noItem2">
	<input type = "submit"> <br> <br>
	<iframe src="//giphy.com/embed/xTiTnHXbRoaZ1B1Mo8" width="480" height="270" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
</body>
</html>
