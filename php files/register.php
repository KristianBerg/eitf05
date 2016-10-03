<html>
<head></head>
<body>
	<h3> Sign up </h3>
	<form action="register.php" method="post">
		Username: <input type="text" name="username"><br>
		Password: <input type="password" name="password"><br>
		Repeat password: <input type="password" size="20" name="password2"><br>
		Home address: <input type="text" name="home_address"><br>
		<input type="submit" value="Register">
	</form>
	<?php
		require_once('database.inc.php');

		session_start();

		if(isset($_POST['username'])){
			$db = $_SESSION['db'];
			$db->openConnection();

			$username = $_POST['username'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			$home_address = $_POST['home_address'];

			if(!$db->usernameExists($username)) {
				if(empty($password)) {
					echo "All necessary fields not filled in.";
				} else if($password === $password2) {
					$db->registerUser($username, $password, $home_address);
					$db->closeConnection();
					header("Location: index.php?registered=" . true);
					exit();
				} else {
					echo "Passwords not matching.";
				}
<<<<<<< HEAD
=======
				echo "Passwords not matching.";
>>>>>>> 91332001eeb3fc39a1331f6afcba84e6c8cf38e4
			} else {
				echo "Username already taken.";
			}
			$db->closeConnection();
		}
	?>
</body>
</html>
