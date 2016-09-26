<html>
  <head></head>

  <body>
    <h2> Enter your card details </h2>

    <form action="receipt.php">
    <fieldset>
      <legend>Payment information</legend>
        First name:<br>
        <input type="text" name="firstname" ><br>
        Last name:<br>
        <input type="text" name="lastname" ><br>
        Card number:<br>
        <input type="text" name="cardnmbr" ><br>
        Expiration date (dd/mm): <br>
        <input type="number" name="day"> <input type="number" name="month"> <br>
        CVV: <br>
        <input type="number" name="cvv"> <br><br>
        <input type="submit" value="checkout">
    </fieldset>
    </form>

  </body>
</html>
