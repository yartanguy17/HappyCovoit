<!DOCTYPE html>
<html lang="en">
<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Happy-Travel World | Connexion</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('Backoffice/images/favicon.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/bower_components/bootstrap/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/icon/feather/css/feather.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/css/jquery.mCustomScrollbar.css')}}">
</head>
<body class="fix-menu">

    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
    </div>
     @if (Session::has('flash_message_error'))
                <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
                <script type="text/javascript">;
                swal("{{ session('flash_message_error') }}", "Merci", "error");
                </script>
                @endif

    <section class="login-block" style="background-image: url('/Backoffice/assets/images/auth/bg.jpg');">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <form class="md-float-material form-material" method="post" action="{{ url('/login-compagnie') }}">
                        {{ csrf_field() }}
                        <div class="text-center">
                             <img src="/assets/images/logo-main.png" alt="">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Connexion</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="pseudo" class="form-control" required placeholder="Pseudo">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control" required placeholder="Mot de passe">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                         <div class="">
                                            <label>
                                                <input type="checkbox" name="">
                                                <span class="text-inverse">Se Rappeler de moi</span>
                                            </label>
                                        </div>
                                        <!--<div class="forgot-phone text-right f-right">
                                            <a href="auth-reset-password.html" class="text-right f-w-600"> Mot de passe oublié?</a>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Se Connecter</button>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-inverse text-center" style="font-weight: bold;">Happy-Travel World - Accès Compagnie.</p>
                                    </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </section>
    <script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/jquery/js/jquery.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/popper.js/js/popper.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>

<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>

<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/modernizr/js/modernizr.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/modernizr/js/css-scrollbars.js')}}"></script>

<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/i18next/js/i18next.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/bower_components/jquery-i18next/js/jquery-i18next.min.js')}}"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript" src="{{ asset('Backoffice/assets/js/common-pages.js')}}"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="1395453f8f1526639cb2ca85-text/javascript"></script>
<script type="1395453f8f1526639cb2ca85-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="1395453f8f1526639cb2ca85-|49" defer=""></script></body>
</html>
