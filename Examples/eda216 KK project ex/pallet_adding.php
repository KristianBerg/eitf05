
<html>

<head>



<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="css/bootstrap.css" rel="stylesheet">

</head>
<body>



	<div class="container">
		<div class="col-lg-6">
			<img src="cookie_copy.jpg" height="10%">
		</div>

		<h3>Pallet adding</h3>
		<!-- Search field -->
		<div class="row">

			<div class="col-lg-4">

				<h4>Search options</h4>

				<form role="form" method=get action="pallet_added.php">

					<div class="form-group">

						<label for="cookie">Cookie</label> <input type="text"
							name="cookie" id="cookie"></input> <label for="amount">Amount</label>
						<input type="number" name="amount" id="amount"></input>
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Create pallet"></input>
					</div>

				</form>

				<form role="form" action="main.html">
					<input type="submit" class="btn btn-sm btn-success" value="Back">
				</form>
			</div>

		</div>
		<!-- ROW (Search field END)-->

	</div>
	<!-- ROW (Results field END)-->


</body>


</html>