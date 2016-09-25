<html>
  <head></head>

  <body>
    <h2> Checkout </h2>
    <?php
      session_start();
      echo "<p>No item 1: " . $_SESSION['noItem1'] . "</p>";
      echo "<p>No item 2: " . $_SESSION['noItem2'] . "</p>";
    ?>
    <form action = 'storepage.php' method = 'post'>
    <input type = 'submit' name = 'back' value = 'Back'> <br>
    <form action = 'pay.php' method = 'post'>
      Credit card number <input type = 'text' name = 'cardNbr'><br>
    <input type = 'submit' value = 'Pay'>
  </body>
</html>
