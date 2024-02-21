<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Happy-Travel World | Confirmation</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Quickdev">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Frontoffice/logo.png')}}">
    <link rel="apple-touch-icon" href="{{ asset('Frontoffice/icon.html')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/css/style.css')}}">

</head>

<body class="striped-bg theme-3">
@if (Session::has('flash_message_error'))
                <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
                <script type="text/javascript">;
                swal("{{ session('flash_message_error') }}", "Merci", "error");
                </script>
                @endif
                  @if (Session::has('flash_message_success'))
                <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
                <script type="text/javascript">;
                swal("{{ session('flash_message_success') }}", "Merci", "success");
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

    <section class="section-padding p-t-0 signin-section user-access-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h2>Confirmation</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="account-access sign-in">
                        <form class="user-access-form" method="post" action="/user/confirm">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="code" placeholder="Code confirmation" required>
                                    </div>
                                    <button type="submit" class="button button-dark btn-block">Valider</button>
                                </form>
                                <p class="acclink">Vous n'avez pas reçu de code? 
                                    <a href="/user/send-code" style="color: orange">Renvoyer
                                    </a>
                                </p>
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
</body>
</html>