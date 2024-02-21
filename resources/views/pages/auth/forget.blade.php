<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Happy-Travel World | Mot de passe oublié ?</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Quickdev">
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ asset('Frontoffice/logo.png')}}">
	<style type="text/css">
		.find-depart:active { 
			transform: scale(0.98); 
			/* Scaling button to 0.98 to its original size */ 
			box-shadow: 10px 20px 22px 1px rgba(0, 0, 0, 0.24); 
			/* Lowering the shadow */ 
		} 

	</style>
   <!--
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800%7CPoppins:300i,300,400,500,600,700,400i,500%7CDancing+Script:700%7CDancing+Script:700%7CGreat+Vibes:400%7CPoppins:400%7CDosis:800%7CRaleway:400,700,800&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/css/animate.css')}}" />
    <link href="{{ asset('Frontoffice/assets/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{ asset('Frontoffice/assets/css/owl.theme.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/css/hover-min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/css/elegant_icon.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontoffice/assets/rslider/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontoffice/assets/rslider/fonts/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontoffice/assets/rslider/css/settings.css')}}">-->
    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="{{ asset('Frontoffice/icon.html')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/css/style.css')}}">
    <link href="{{ asset('assets/css/intlTelInput.css')}}" rel="stylesheet">

</head>

<body class="striped-bg theme-3">
	@if (Session::has('flash_message_error'))
	<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
	<script type="text/javascript">;
	swal("{{ session('flash_message_error') }}", "Merci", "error");
</script>
@endif
<header class="theme-3">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="logo">
					<a href="/"><img src="/assets/images/logo-main.png" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</header>

<section class="section-padding p-t-0 signup-section user-access-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 text-center">
				<h2>Mot de passe oublié</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<div class="account-access sign-in">
                        <!--<ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#rider" class="active" aria-controls="rider" role="tab" data-toggle="tab">Accès Particulier</a>
                            </li>
                            <li role="presentation">
                                <a href="#driver" aria-controls="driver" role="tab" data-toggle="tab">Accès Chauffeur</a>
                            </li>
                        </ul>-->
                        
                        <div class="tab-content">
                        	<div role="tabpanel" class="tab-pane active" id="rider">
                        		<form class="user-access-form" method="post" action="/forget-password">
                        			{{ csrf_field() }}
                        			<br>
                        			<center>
                        			<div class="form-group">
											<input type="tel" id="phone" class="form-control" name="telephone" placeholder="Numéro de téléphone" required style="width:400px;">
											<small class="mr-2" style="color:red;display:none;" id="alert_phone">Entrez le numéro de téléphone avec indicatif (Ex : +228)
											</small>
										</div></center><br>

                        			<button type="submit" class="button button-dark btn-block find-depart">RÉINITIALISER</button>
                        		</form>
                        		<p class="acclink">Avez-vous déjà un compte ? 
                        			<a href="/login" style="color: orange">Connexion
                        				<i class="icofont">double_right</i>
                        			</a>
                        		</p>

                        	</div>
                        	<div role="tabpanel" class="tab-pane" id="driver">
                        		<form class="user-access-form" method="post" action="/login">
                        			{{ csrf_field() }}
                        			<div class="form-group">
                        				<input type="text" class="form-control" name="pseudo" placeholder="Pseudo" required>
                        			</div>
                        			<div class="form-group">
                        				<input type="password" class="form-control" name="password"  placeholder="Mot de passe" required>
                        			</div>
                        			<button type="submit" class="button button-dark btn-block find-depart">Se Connecter</button>
                        		</form>
                        		<p class="acclink">Vous n'avez pas de compte ? 
                        			<a href="/register">Inscrivez-vous
                        				<i class="icofont">double_right</i>
                        			</a>
                        		</p>
                        	</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <footer class="theme-2">

    	<section class="footer-nav-section section-padding theme-2">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-3">
    					<div class="footer-brand">
    						<a href="/"><img src="/assets/images/logo.png" alt="logo"></a>
    					</div>
    				</div>
    				<div class="col-lg-6">
    					<ul class="social-nav">
    						<li><a href="https://www.facebook.com/Happy-Travel-World-HTW-103153728098782/" target="_blank"  class="facebook"><i class="fab fa-facebook-f"></i></a></li>
                           <li><a target="_blank" href="https://www.instagram.com/happy.travel.world_htw/" class="instagram"><i class="fab fa-instagram"></i></a></li>
    					</ul>
    				</div>
    				<div class="col-lg-3">
    					<div class="app-download-box">
    						<a href="https://play.google.com/store/apps/details?id=com.htworld.www" target="_blank"><img src="/assets/images/icon/google-play.jpg" alt="Google play"></a>
    						<a href="#"><img src="/assets/images/icon/apple-store.jpg" alt="Apple store"></a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</section>

    	<section class="copyright-section">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-6">
    					<p>&copy; Copyright 2020 Happy Travel-World. Tous droits reservés</p>
    				</div>
    				<div class="col-lg-6">
    					<ul class="social-nav">
    						<li><a href="#">CGU</a></li>
    						<li><a href="#">Politique de Confidentialité</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</section>

    </footer>
    <script src="{{ asset('assets/plugins/common/common.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/counterup/waypoints.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB16sGmIekuGIvYOfNoW9T44377IU2d2Es&amp;sensor=true"></script>
    <script src="{{ asset('assets/plugins/gmap3/gmap3.min.js')}}"></script>
    <!-- custom scripts -->
    <script src="{{ asset('Frontoffice/js/scripts.js')}}"></script>
    <script src="{{ asset('assets/js/intlTelInput.js')}}"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('#phone').keyup(function() {
    			if($('#phone').val().length > 0){
    				var phone = $('#phone').val();

    				var first_character = phone.charAt(0);

    				if (first_character == "+") {
    					$('#alert_phone').css("display","none");
    				}else{
    					$('#alert_phone').css("display","inline-block");
    				}

				//var indicatif = $('.selected-flag').attr('title');
				
				//var split_data = indicatif.split(": ");
				var indicatif = phone.substring(0, 4);
				//console.log(indicatif);
				$('#indicatif').val(indicatif)
			}
		});
    	});
    	var input = document.querySelector("#phone");
    	window.intlTelInput(input, {
    		utilsScript: "{{ asset('assets/js/utils.js')}}",
    	});
    </script>


</body>
</html>