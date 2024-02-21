<!DOCTYPE html>
<html lang="en">
<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Happy-Travel World | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('Frontoffice/logo.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/bower_components/bootstrap/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/icon/themify-icons/themify-icons.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/icon/icofont/css/icofont.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/icon/feather/css/feather.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/pages/data-table/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Backoffice/assets/css/jquery.mCustomScrollbar.css')}}">
    @yield('top_script')
</head>

<body>
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            @include('partials.top_admin')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('partials.header_admin')
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/jquery/js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/popper.js/js/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>

        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>

        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/modernizr/js/modernizr.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/modernizr/js/css-scrollbars.js')}}"></script>

        <script src="{{ asset('Backoffice/bower_components/datatables.net/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/assets/pages/data-table/js/jszip.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/assets/pages/data-table/js/pdfmake.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/assets/pages/data-table/js/vfs_fonts.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/bower_components/datatables.net-buttons/js/buttons.print.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/bower_components/datatables.net-buttons/js/buttons.html5.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}" type="text/javascript"></script>

        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/i18next/js/i18next.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/bower_components/jquery-i18next/js/jquery-i18next.min.js')}}"></script>

        <script src="{{ asset('Backoffice/assets/pages/data-table/js/data-table-custom.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/assets/js/pcoded.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/assets/js/vartical-layout.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('Backoffice/assets/js/jquery.mCustomScrollbar.concat.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('Backoffice/assets/js/script.js')}}"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="a4740a9acf1fb3f131b4af44-text/javascript"></script>
        <script type="a4740a9acf1fb3f131b4af44-text/javascript">
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-23581568-13');
      </script>
      <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="a4740a9acf1fb3f131b4af44-|49" defer=""></script>
      <!--<script type="text/javascript">
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
      @yield('script')
  </body>
  <!-- index.html  21 Nov 2019 03:47:04 GMT -->

  </html>