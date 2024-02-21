<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Happy-Travel World User | @yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Quickdev">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Frontoffice/logo.png')}}">

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/css/style.css')}}">
    <style type="text/css">
        @media (min-width: 1000px) and (max-width: 8000px) {
           
        }

        @media (min-width: 500px) and (max-width: 1000px) {
            .custom-responsive {
                display: none;
            }
        }

        @media (max-width: 500px) {
            .custom-responsive {
                display: none;
            }
        }
    </style>
     @yield('tops')
    <style>
.checked {
  color: orange;
}
</style>
</head>

<body class="theme-2">

    @include('partials.header_user')
    @yield('content') 
    @include('partials.footer_user')
    <!--
    <script src="{{ asset('Frontoffice/assets/js/nile-slider.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/jquery.themepunch.revolution.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.actions.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.carousel.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.migration.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.navigation.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.parallax.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/rslider/js/extensions/revolution.extension.video.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/YouTubePopUp.jquery.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/imagesloaded.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/custom.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('Frontoffice/assets/js/bootstrap.min.js')}}"></script>-->
    <script src="{{ asset('assets/plugins/common/common.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/counterup/waypoints.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB16sGmIekuGIvYOfNoW9T44377IU2d2Es&amp;sensor=true"></script>
    <script src="{{ asset('assets/plugins/gmap3/gmap3.min.js')}}"></script>
    <!-- custom scripts -->
    <script src="{{ asset('Frontoffice/js/scripts.js')}}"></script>
    <!-- <script type="text/javascript">
    $(document).ready(function() {
        function fetchdata() {
            $.ajax({
                method: 'get',
                url: '/analyse-reservation',
                type: 'json',
                enctype: 'multipart/form-data',
                processData: false,
                contentData: false,
                statusCode: {
                    422: function(data) {
                        var errors = data.responseJSON.errors;
                        console.log(errors);
                    }
                },
            }).done(function(data) {
                console.log(data);
            }).fail(function(data) {
                console.log(data.responseJSON.errors);
            })
        }
        setInterval(fetchdata, 60000);
    });
    </script>-->
    @yield('scripts')

</body>

</html>