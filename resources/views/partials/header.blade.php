  <header class="theme-1">
    <section class="header__upper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header__upper--left">
                        <div class="logo">
                            <a href="/"><img src="/assets/images/logo-main.png" style="width: 400px;" alt=""></a>
                        </div>
                        <div class="search-bar">
                            <form action="#" class="form">
                                <span class="icon icon-left"><i class="fas fa-map-marker-alt"></i></span>
                                <input class="form-control" type="search" name="" placeholder="Où allez-vous?" id="">
                                <button class="button button-dark" type="submit"><img src="/assets/images/arrow-shape.png" alt=""></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header__upper--right">
                        <nav class="navigation">
                            <ul>
                                <!--<li class="custom-responsive" style="margin-top:10px;">
                                  <a href="locale/fr"><img style="vertical-align: initial;" src="/fr.png"></a>
                              </li>
                              <li class="custom-responsive" style="margin-top:10px;">
                                  <a href="locale/en"><img style="vertical-align: initial;" src="/eng.png"></a>
                              </li>
                              <li class="custom-responsive" style="margin-top:10px;">
                                  <a href="locale/es"><img style="vertical-align: initial;width:20px;height: 20px;" src="/es.png"></a>
                              </li>-->
                              <?php if(getUserIsLogged()==0){?>
                                <li><a href="/login">@lang('menu._connexion')</a></li>
                                <li><a href="/register">@lang('menu._inscription')</a></li>
                            <?php }else{?>
                                <li><a href="/user/dashboard">Tableau de Bord</a></li>
                            <?php } ?>

                        </ul>
                    </nav>
                    <a href="/choice" class="button button-dark big find-depart" >@lang('menu._depart_btn')</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="header__lower">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" style="margin-top: 40px;color: white;background-color: orange;" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon" style="color: white;"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item {!! (Request::is('/') ? 'active' : '') !!}">
                                <a class="nav-link find-depart" href="/"><i class="fas fa-home"></i>@lang('menu.menu1')</a>
                            </li>
                            <li class="nav-item {!! (Request::is('about') ? 'active' : '') !!}">
                                <a class="nav-link find-depart" href="/about"><i class="fas fa-exclamation-circle"></i>@lang('menu.menu2')</a>
                            </li>
                            <li class="nav-item {!! (Request::is('packages') ? 'active' : '') !!}">
                                <a class="nav-link find-depart" href="/packages"><i class="fas fa-cube"></i>@lang('menu.menu3')</a>
                            </li>
                            <li class="nav-item {!! (Request::is('contact') ? 'active' : '') !!}">
                                <a class="nav-link find-depart" href="/contact"><i class="fas fa-map-marker-alt"></i>@lang('menu.menu4')</a>
                            </li>
                        </ul>
                        <div class="my-2 my-lg-0">
                            <?php if(getUserIsLogged()==0){?>
                                <a href="/login" class="button button-light big find-depart">@lang('menu._conduire_btn')</a>
                            <?php }else{?>
                                <a href="/add-departure" class="button button-light big find-depart">@lang('menu._conduire_btn')</a>
                            <?php } ?>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>
</header>