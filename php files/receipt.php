<html>
  <?php
    session_start();
    $username = $_SESSION['username'];
    $db = $_SESSION['db'];
    $db->openConnection();
    $db->emptyCart($username);
    $db->closeConnection();
  ?>
  <head></head>
  <body>
    <h2> Receipt </h2>
  </body>
</html>
