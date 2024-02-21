<!DOCTYPE html>
<html>
<head>
	<title>Paiement effectué avec succès</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<style type="text/css">

		body
		{
			background:#f2f2f2;
		}

		.payment
		{
			border:1px solid #f2f2f2;
			height:320px;
			border-radius:20px;
			background:#fff;
		}
		.payment_header
		{
			background:rgba(255,102,0,1);
			padding:20px;
			border-radius:20px 20px 0px 0px;

		}

		.check
		{
			margin:0px auto;
			width:50px;
			height:50px;
			border-radius:100%;
			background:#fff;
			text-align:center;
		}

		.check i
		{
			vertical-align:middle;
			line-height:50px;
			font-size:30px;
		}

		.content 
		{
			text-align:center;
		}

		.content  h1
		{
			font-size:25px;
			padding-top:25px;
		}

		.content a
		{
			width:200px;
			height:35px;
			color:#fff;
			border-radius:30px;
			padding:5px 10px;
			background:rgba(255,102,0,1);
			transition:all ease-in-out 0.3s;
		}

		.content a:hover
		{
			text-decoration:none;
			background:#000;
		}

	</style>
</head>
<body>
	<div class="container" style="margin-top: 30%">
		<div class="row">
			<div class="col-md-12 mx-auto mt-5">
				<div class="payment">
					<div class="payment_header">
						<div class="check"><?= ($status==1)?'<i class="fa fa-check" aria-hidden="true"></i>':'<i>&times;</i>' ?></div>
					</div>
					<div class="content">
						<h1 style="font-size: 30px;"><?= ($status==1)?'Paiement effectué!':'Paiement non effectué!' ?></h1>
						<p style="font-size: 25px;">Veuillez cliquez sur le bouton <b>Retour de votre smartphone</b> pour quitter cette page</p>
						<a style="color: white;font-size: 20px;padding: 10px">MERCI</a>
					</div>

				</div>
			</div>
		</div>
	</div>
</body>
</html>