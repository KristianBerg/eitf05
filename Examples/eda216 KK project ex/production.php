
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

		<h3>Production</h3>
		<!-- Search field -->
		<div class="row">



			<div class="col-lg-4">

				<h4>Search options</h4>



				<form role="form" method=get action="production_search.php">

					<div class="form-group">


						<label for="cookie">Cookie</label> <input type="text"
							name="cookie" id="cookie"></input>

					</div>
					<div class="form-group">


						<label for="start_date">Start date</label> <input type="date"
							name="start_date" id="start_date"></input> <label for="end_date">End
							date</label> <input type="date" name="end_date" id="end_date"></input>

					</div>
					<div class="form-group">

						<div class="row">

							<div class="col-lg-4">
								<label for="blocked">Blocked:</label> <input type="radio"
									name="block" value="blocked" id="blocked"></input>
							</div>

							<div class="col-lg-4">
								<label for="not_blocked">Not blocked:</label> <input
									type="radio" name="block" value="not_blocked" id="not_blocked"></input>
							</div>

							<div class="col-lg-4">
								<label for="both">Both</label> <input type="radio" name="block"
									value="both" id="both" checked></input>

							</div>
						</div>

					</div>
					<div class="form-group">


						<label for="pallet">Pallet id</label> <input type="text"
							name="pallet_id" id="pallet"></input>
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Search"></input>
					</div>

				</form>

				<form role="form" action="http://127.0.0.1:8080">
					<input type="submit" class="btn btn-success" value="Back">
				</form>

			</div>

		</div>
		<!-- ROW (Search field END)-->







	</div>
	<!-- ROW (Results field END)-->


</body>


</html>