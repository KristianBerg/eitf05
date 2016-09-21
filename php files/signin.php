<!DOCTYPE html>
<html>
<head></head>
<body>
	<h3> Login </h3>
	<form action="login.php" method="post">
	  Username: <input type="text" size="20" name="username"><br>
	  Password: <input type="text" size="20" name="password"><br>
	  <input type="submit" value="login">
    <input type="submit" value="Register">
	</form>
	<?php
		session_start();
		if(isset($_GET['noSuchUser']) && $_GET['noSuchUser'] == true){
			echo "No such user was found.";
		} else if(isset($_GET['timeout']) and $_GET['timeout'] == true) {
			echo "Session timed out...";
		}
	//echo $_SESSION["noSuchUser"];
	?>
</body>
</html>
