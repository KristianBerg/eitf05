<!DOCTYPE html>
<html>
<head></head>
<body>
	<h3> Login </h3>
	<form action="login.php" method="post">
	  Username: <input type="text" size="20" name="username"><br>
	  Password: <input type="password" size="20" name="password"><br>
	  <input type="submit" value="login">
	  <input type="submit" name="register" value="Register">
	</form>
	<?php
		session_start();
		if(isset($_GET['noSuchUser']) && $_GET['noSuchUser'] == true){
			echo "No such user was found.";
		} else if(isset($_GET['timeout']) and $_GET['timeout'] == true) {
			echo "Session timed out...";
		} else if(isset($_GET['registered']) and $_GET['registered'] == true) {
			echo "New user registered.";
		} else if(isset($_GET['userLocked']) and $_GET['userLocked'] == true) {
			echo "This user has been locked.";
			echo "<br> We'll send a letter to your registered address with a reset code in 3-5 workdays.";

		}
	?>
</body>
</html>
