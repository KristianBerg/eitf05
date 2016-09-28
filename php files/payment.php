<html>
  <head></head>

  <body>
    <h2> Enter your card details </h2>

    <form action="receipt.php">
    <fieldset>
      <legend>Payment information</legend>
        First name on card:<br>
        <input type="text" name="firstname" ><br>
        Last name on card:<br>
        <input type="text" name="lastname" ><br>
        Card type: <br>
        <select name="cardtype">
        <option value="volvo">VISA</option>
        <option value="saab">MasterCard</option>
        </select><br>
        Card number:<br>
        <input type="text" name="cardnmbr" ><br>
        Expiration date (dd/mm): <br>
        <input type="number" name="day" style="width: 75px;"> <input type="number" name="month" style="width: 75px"> <br>
        CVV: <br>
        <input type="number" name="cvv"> <br><br>
        <input type="submit" value="checkout">
    </fieldset>
    </form>

  </body>
</html>
