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
    if(isset($_SESSION['counter'])) {
      echo $_SESSION['counter'];
      $_SESSION['counter']++;
      if($_SESSION >= 3) {
        echo "BANNED!";
      } else {
        echo "Invalid username or password number " . $_SESSION['counter'];
      }
    }
  ?>

</body>
</html>
