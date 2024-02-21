<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>H.T.W | Erreur 404</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('error_files/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('error_files/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('error_files/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('error_files/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('error_files/css/_all-skins.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('error_files/css/blue.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/icone.png')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- danger: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="hold-transition" style="background-color: orange;">


<div class="row">
    <div class="login-box">

        <div class="text-center">

            <div class="lockscreen-wrapper">
                <div class="lockscreen-logo">
                    <a style="color: white;font-size: 60px" href="/" class="text-uppercase"><b>H.T.W <br> Erreur 404</b></a>
                </div>
                <!-- User name -->
                <div class="lockscreen-name h2"><strong style="color: white"> Happy Travel World</strong> </div><br><br>

                <!-- START LOCK SCREEN ITEM -->
                <div class="lockscreen-item">
                    <!-- lockscreen image -->
                    <div class="lockscreen-image">
                        <img class="fa fa-spin" src="{{asset('logo.png')}}" alt=" Image" style="width: 100px;">
                    </div>
                    <!-- /.lockscreen-image -->

                    <!-- lockscreen credentials (contains the form) -->
                    <form class="lockscreen-credentials" >
                        <div class="input-group" style="margin-left:30px;">
                            <input class="form-control" type="text" placeholder="Erreur 400">

                            <div class="input-group-btn">
                                <button type="button" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- /.lockscreen credentials -->

                </div>
                <!-- /.lockscreen-item -->
               <!-- <div class="help-block text-center" style="color: white">
                    <h4 class="text-uppercase">Desolé, La page à laquelle vous éssayez d'accéder n'existe pas, revérifier l'adresse.</h4>
                </div>-->
                <hr class="divider">
                <a href="/" class="btn btn-default btn-sm text-uppercase"> <i class="fa fa-arrow-circle-left"> </i>
                    Retour à la page d'Accueil</a>
                <div class="lockscreen-footer text-center" style="color: white">
                    Copyright © 2020 <b><a style="color: white" class="text-uppercase text-white"> Happy Travel World</a></b><br>
                    Tous droits Reservés
                </div>
            </div>

        </div>

    </div>

</div>

<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('error_files/js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
    $(document).ajaxStart(function() { Pace.restart(); });
</script>
<script src="{{ asset('error_files/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('error_files/js/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('error_files/js/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('error_files/js/adminlte.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('error_files/js/demo.js') }}"></script>
<script src="{{ asset('error_files/js/icheck.min.js') }}"></script>

</body>
</html>
