<html>
  <head></head>

  <body>
    <h2> Checkout </h2>
    <style>
      table, th, td {
        border: 1px solid black;
      }
    </style>
    <?php
    	require_once('database.inc.php');
      session_start();
      if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > 9000)) {
    		// last request was more than X seconds ago
    		session_unset();     // unset $_SESSION variable for the run-time
    		session_destroy();   // destroy session data in storage
    	}
    	$_SESSION['lastActivity'] = time(); //Update last activity time stamp
      $username = $_SESSION['username'];
      $products = $_SESSION['products'];
      $db = $_SESSION['db'];
      $db->openConnection();
      $cart = $db->getCart($username);
      if(isset($_REQUEST['clear'])) {
        $db->emptyCart($username);
        $index = 0;
        while($index < count($products)) {
          $_SESSION['noItem' . $index] = 0;
          $index++;
        }
        echo "Your cart is empty.";
        unset($_REQUEST['clear']);
      } else if(empty($cart)){
        echo "Your cart is empty.";
      } else {
        $index = 0;
        echo "  <table style='width:30%'>
          <tr>
            <th>Product</th>
            <th>Amount</th>
            <th>Á price</th>
            <th>Total price</th>
            </tr>";
          foreach($cart as $row) {
            echo "<tr>";
            echo "<th>" . $products[$row['Prod_id']]['Prod_name'] . "</th>";
            echo "<th>" . $row['Quantity'] . "</th>";
            echo "<th>" . $products[$row['Prod_id']]['Price'] . "</th>";
            echo "<th>" . $products[$row['Prod_id']]['Price']*$row['Quantity'] . "</th>";
            echo "</tr>";
          }
      echo "</table>";
    }
    $db->closeConnection();
    ?>
    <form action='storepage.php' method='post'>
    <input type='submit' name='back' value='Back'>
    </form>

    <form action = 'checkout.php' method='post'>
    <input type='submit' name='clear' value='Empty cart'>
    </form>

    <form action='payment.php' method='post'>
    <input type='submit' value='Pay'>
    </form>
  </body>
</html>
