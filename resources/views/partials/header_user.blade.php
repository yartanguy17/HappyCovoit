<header class="theme-2">
        <section class="header__upper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="header__upper--left">
                            <div class="logo">
                                <a href="/user/dashboard"><img  src="/assets/images/logo-main.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="header__upper--right">
                            <nav class="navigation">
                                <ul>
                                    <li><a href="/">Accueil</a></li>
                                    <li><a href="/compagnies-transport">Compagnies Partenaires</a></li>
                                    <li><a href="/contact">Contact</a></li>
                                </ul>
                            </nav>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media">
                                        <img height="30" width="30" class="mr-3" src="{{ getUserAuth()->avatar }}" alt="">
                                        <div class="media-body">
                                            <h6 class="m-0">{{ getUserAuthName() }} <i class="fas fa-angle-down"></i></h6>
                                            <p class="m-0">{{ getUserAuth()->pseudo }}</p>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/user/change-password">Modifier mot de passe</a>
                                     <a class="dropdown-item" href="/user/logout">Deconnexion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </header>