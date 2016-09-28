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
      $username = $_SESSION['username'];
      $products = $_SESSION['products'];
      $db = $_SESSION['db'];
      $db->openConnection();
      $cart = $db->getCart($username);
      $db->closeConnection();
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
    ?>
    <form action = 'storepage.php' method = 'post'>
    <input type = 'submit' name = 'back' value = 'Back'> <br>
    <form action = 'pay.php' method = 'post'>
      Credit card number <input type = 'text' name = 'cardNbr'>
    <input type = 'submit' value = 'Pay'>
  </body>
</html>
