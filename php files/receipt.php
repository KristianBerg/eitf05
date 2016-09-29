<html>
  <?php
    require_once('database.inc.php');
    session_start();
    $username = $_SESSION['username'];
    $products = $_SESSION['products'];
    $db = $_SESSION['db'];
    $db->openConnection();
    $cart = $db->getCart($username);
    $db->emptyCart($username);
    $db->closeConnection();
  ?>
  <head></head>
  <body>
    <h2> Receipt </h2>
    <h3> Customer information </h3>
    <b>User:</b> <?php echo $username?><br>
    <b>Full name:</b> <?php echo $_POST['firstname'] . ' ' . $_POST['lastname'] ?><br>
    <b>Card number:</b> <?php
      $cardNr = $_POST['cardnmbr'];
      $nrOfCensoredDigits = strlen($cardNr)-4;
      $lastFourDigits = substr($cardNr, $nrOfCensoredDigits, 4);
      while($nrOfCensoredDigits > 0) {
        echo '*';
        $nrOfCensoredDigits--;
      }
      echo $lastFourDigits;
    ?><br>
    <b>Card type:</b> <?php echo $_POST['cardtype'] ?><br>
    <b>Date: </b> <?php echo date("l jS \of F Y"); ?><br><br>
    <h3>Purchased products</h3>
    <?php
      $index = 0;
      $totalAmount = 0;
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
        $totalAmount = $totalAmount + $products[$row['Prod_id']]['Price']*$row['Quantity'];
      }
      echo "</table>";
      echo "<br><b>Total amount: </b>" . $totalAmount;
    ?>
  </body>
</html>
