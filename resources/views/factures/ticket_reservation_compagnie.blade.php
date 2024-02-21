<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	 <script src="{{ asset('assets/js/jquery-qrcode.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-qrcode.min.js')}}"></script>
	<style type="text/css">
		#invoice{
			padding: 30px;
		}

		.invoice {
			position: relative;
			background-color: #FFF;
			min-height: 680px;
			padding: 15px
		}

		.invoice header {
			padding: 10px 0;
			margin-bottom: 20px;
			border-bottom: 1px solid #3989c6
		}

		.invoice .company-details {
			text-align: right
		}

		.invoice .company-details .name {
			margin-top: 0;
			margin-bottom: 0
		}

		.invoice .contacts {
			margin-bottom: 20px
		}

		.invoice .invoice-to {
			text-align: left
		}

		.invoice .invoice-to .to {
			margin-top: 0;
			margin-bottom: 0
		}

		.invoice .invoice-details {
			text-align: right
		}

		.invoice .invoice-details .invoice-id {
			margin-top: 0;
			color: #3989c6
		}

		.invoice main {
			padding-bottom: 50px
		}

		.invoice main .thanks {
			margin-top: -100px;
			font-size: 2em;
			margin-bottom: 50px
		}

		.invoice main .notices {
			padding-left: 6px;
			border-left: 6px solid #3989c6
		}

		.invoice main .notices .notice {
			font-size: 1.2em
		}

		.invoice table {
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 20px
		}

		.invoice table td,.invoice table th {
			padding: 15px;
			background: #eee;
			border-bottom: 1px solid #fff
		}

		.invoice table th {
			white-space: nowrap;
			font-weight: 400;
			font-size: 16px
		}

		.invoice table td h3 {
			margin: 0;
			font-weight: 400;
			color: #3989c6;
			font-size: 1.2em
		}

		.invoice table .qty,.invoice table .total,.invoice table .unit {
			text-align: right;
			font-size: 1.2em
		}

		.invoice table .no {
			color: #fff;
			font-size: 1.6em;
			background: #3989c6
		}

		.invoice table .unit {
			background: #ddd
		}

		.invoice table .total {
			background: #3989c6;
			color: #fff
		}

		.invoice table tbody tr:last-child td {
			border: none
		}

		.invoice table tfoot td {
			background: 0 0;
			border-bottom: none;
			white-space: nowrap;
			text-align: right;
			padding: 10px 20px;
			font-size: 1.2em;
			border-top: 1px solid #aaa
		}

		.invoice table tfoot tr:first-child td {
			border-top: none
		}

		.invoice table tfoot tr:last-child td {
			color: #3989c6;
			font-size: 1.4em;
			border-top: 1px solid #3989c6
		}

		.invoice table tfoot tr td:first-child {
			border: none
		}

		.invoice footer {
			width: 100%;
			text-align: center;
			color: #777;
			border-top: 1px solid #aaa;
			padding: 8px 0
		}

		@media print {
			.invoice {
				font-size: 11px!important;
				overflow: hidden!important
			}

			.invoice footer {
				position: absolute;
				bottom: 10px;
				page-break-after: always
			}

			.invoice>div:last-child {
				page-break-before: always
			}
		}
	</style>
</head>
<?php
        $path = public_path('/assets/images/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
<body>
	<div id="invoice">
		<div class="invoice overflow-auto">
			<div style="min-width: 600px">
				<header>
					<div class="row">
						<div class="col">
								<img src="{{ $base64 }}" style="width: 40%;" data-holder-rendered="true" />
						</div>
						<div class="col company-details">
							
							<div>Lomé, TOGO</div>
							<div>(228) 97397869</div>
							<div>happytravel.htworld@gmail.com</div>
						</div>
					</div>
				</header>
				<main>
					<div class="row contacts">
						<div class="col invoice-to">
							<div class="text-gray-light">FACTURE À:</div>
							<h2 class="to">{{ $reservation->client->nom }} {{ $reservation->client->prenoms }}</h2>
							<div class="address">{{ $reservation->client->telephone }}</div>
						</div>
						<div class="col invoice-details">
							<h1 class="invoice-id">FACTURE {{ $reservation->facture }}</h1>
							<div class="date">
								Compagnie: 
								 <b>
								 	<?= getUserNameById($reservation->destination->user_id)?>
                                </b>
							</div>
							<div class="date">
							Date de réservation: 
							 <b><?php
                                $dateReservation = $reservation->date_reservation;
                                $explodeDats = explode("-", $dateReservation);
                                echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0];
                                ?></b>
						</div>
							<div class="date">
								Date et Heure Départ: 
								 <b>
								 	<?php
                                echo getFullDate($reservation->date_depart) . " à " .$reservation->destination->heure;
                               
                                ?>
                                	
                                </b>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-8">
							<p>
						Somme Totale payée  : <b>{{ $reservation->prix_total }} FCFA</b>
					</p>
                     <p>
						Lieu de Départ  : <b>{{ $reservation->destination->ville_demarrage }}, {{ $reservation->destination->pays_demarrage }} </b><br>
						Lieu d'Arrivée :  <b>
										@if($reservation->ligne_destination_id == 0)
										{{ $reservation->destination->ville_destination }}, {{ $reservation->destination->pays_destination }}
										@else
										{{ getLigneById($reservation->ligne_destination_id)->ville_destination }}, {{ getLigneById($reservation->ligne_destination_id)->pays_destination }} (Escale)
    									@endif
						</b>
					</p>
					<?php
					if ($sieges->count() > 0) {
						?>
						<h4>Numéro de Sièges attribués : </h4>
						@foreach($sieges as $siege)
						<b>{{ $siege->numero }}</b><br>
						@endforeach
						<?php
					}
					?>
					<br>
					
						</div>
						<div class="col-lg-4">
							<img style="height: 200px;width:200px;float: right;"  src="data:image/png;base64, {!! $qrcode !!}">
						</div>
					</div>
					
					<br><br><br><br><br>

				<div class="thanks">Merci!</div>
				<div class="notices">
					<div>NOTICE:</div>
					<div class="notice" style="color:red;">Ce ticket atteste de la réservation effective de votre voyage.</div>
				</div>
				
				<br><br><br><br>
			</main>
		</div>
		<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
		<div></div>
	</div>
</div>
<script type="text/javascript">
	/*$("#qrcodediv").qrcode({
        text: ''
     });*/
	$('#printInvoice').click(function(){
		Popup($('.invoice')[0].outerHTML);
		function Popup(data) 
		{
			window.print();
			return true;
		}
	});
</script>
</body>
</html>