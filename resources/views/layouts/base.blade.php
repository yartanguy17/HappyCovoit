<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Happy-Travel World | @yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Quickdev">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Frontoffice/logo.png')}}">

    <link rel="apple-touch-icon" href="{{ asset('Frontoffice/icon.html')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Frontoffice/css/style.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('top_includes')

    <style type="text/css">
    .find-depart:active { 
            transform: scale(0.98); 
            /* Scaling button to 0.98 to its original size */ 
            box-shadow: 10px 20px 22px 1px rgba(0, 0, 0, 0.24); 
            /* Lowering the shadow */ 
        } 

    </style>
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
</head>

<body class="theme-1">

    @include('partials.header')
    @yield('content') 
    @include('partials.footer')


    <script src="{{ asset('assets/plugins/common/common.min.js')}}"></script>
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