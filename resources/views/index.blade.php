@extends('layouts.base') @section('title') Accueil @endsection @section('content')
 <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="hero-area-slider" class="hero-area-slider owl-carousel">
                        <div class="single-slider-item">
                            <div class="hero-area-left">
                                <h1>Happy-Travel World</h1>
                                <p>Trouvez des chauffeurs personnels ou compagnie et<br> voyager sûrement.</p>
                                <a href="/register" class="button button-dark big find-depart">Inscription</a>
                            </div>
                            <div class="hero-area-right">
                                <img src="/assets/images/home/1.png" alt="">
                            </div>
                        </div>
                        <div class="single-slider-item">
                            <div class="hero-area-left">
                                <h1>Happy-Travel World</h1>
                                <p>Créer un compte <b>Chauffeur personnel</b> et<br> proposer vos services</p>
                                <a href="/register" class="button button-dark big find-depart">Inscription</a>
                            </div>
                            <div class="hero-area-right">
                                <img src="/assets/images/home/2.png" alt="">
                            </div>
                        </div>
                        <div class="single-slider-item">
                            <div class="hero-area-left">
                                <h1>Happy-Travel World</h1>
                                <p>Vous êtes une <b>compagnie de Transport</b> ? Créer un<br> compte puis proposer vos services.</p>
                                <a href="/register" class="button button-dark big find-depart">Inscription</a>
                            </div>
                            <div class="hero-area-right">
                                <img src="/assets/images/home/3.png" alt="">
                            </div>
                        </div>
                        <div class="single-slider-item">
                            <div class="hero-area-left">
                                <h1>Happy-Travel World</h1>
                                <p>Vous êtes une compagnie de transport devenir <br>un partenaire</p>
                                <a href="/register" class="button button-dark big find-depart">Inscription</a>
                            </div>
                            <div class="hero-area-right">
                                <img src="/assets/images/home/4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding how-work-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2 class="section-title text-center">Comment ça marche ?</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 d-none d-lg-block">
                    <div class="icons-section">
                        <div class="single-icon">
                            <img src="/assets/images/icon/1.png" alt="">
                        </div>
                        <div class="single-icon">
                            <img src="/assets/images/icon/2.png" alt="">
                        </div>
                        <div class="single-icon">
                            <img src="/assets/images/icon/3.png" alt="">
                        </div>
                        <div class="single-icon">
                            <img src="/assets/images/icon/4.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-icon text-center m-b-10 d-block d-lg-none">
                        <img src="/assets/images/icon/1.png" alt="">
                    </div>
                    <div class="how-work-text">
                        <h4>Choisir une destination</h4>
                        <!--<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>-->
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-icon text-center m-b-10 d-block d-lg-none">
                        <img src="/assets/images/icon/2.png" alt="">
                    </div>
                    <div class="how-work-text">
                        <h4>Choisir un chauffeur</h4>
                        <!--<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>-->
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-icon text-center m-b-10 d-block d-lg-none">
                        <img src="/assets/images/icon/3.png" alt="">
                    </div>
                    <div class="how-work-text">
                        <h4>Mise en relation</h4>
                        <!--<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>-->
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-icon text-center m-b-10 d-block d-lg-none">
                        <img src="/assets/images/icon/4.png" alt="">
                    </div>
                    <div class="how-work-text">
                        <h4>Arrivée en sécurité</h4>
                        <!--<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-us-area bg-2 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="section-title">Qui sommes-nous ?</h2>
                    <div class="about-us-text">
                        <h4>Happy-Travel World</h4>
                        <p><b>HAPPY-TRAVEL WORLD</b> est une plateforme africaine de réservation de voyage en ligne, mettant en contact des clients désireux d’effectuer des voyages avec des chauffeurs personnels ou des compagnies de transport. Notre but, optimiser la rapidité et le confort des voyages, digitaliser le transport en commun en Afrique et le rendre plus performant.<br>
<b>Notre mission rendre le transport plus attractif et plus rapide.</b><br>
Présent dans plus de 30 pays d’Afrique notre objectif, couvrir l’entièreté du continent africain offrant à tous nos clients un accès sans limite au réseau des chauffeurs et des compagnies de transports en Afrique et dans le monde.<br>
Nous offrons aux compagnies partenaires et aux chauffeurs qui le désirent une plus grande visibilité, un service-client hors du commun et l’assurance d’obtenir une activité optimisée à son maximum de rendement et de rapidité de service.<br>
Nous faire confiance c’est s’assurer une croissance sans limite.</p>
                        <a href="/about" class="button button-dark tiny find-depart">Lire Plus</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="download-section section-padding p-b-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2 class="section-title text-center">Télécharger Happy-Travel World</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <div class="download-qrcode">
                        <img src="/assets/images/qr.png" alt="">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="download-text">
                        <h2>Télécharger l'application mobile Happy-Travel World</h2>
                        <p>Installer l'application mobile et soyez connectés partout où vous êtes.</p>
                    </div>
                    <div class="download-buttons">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.htworld.www"><img src="/assets/images/download-2.png" alt=""></a>
                        <a href="#"><img src="/assets/images/download-1.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-padding testimonial-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2 class="section-title text-center">Que pensent les internautes ?</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div id="testimonial-carousel-2" class="testimonial-carousel owl-carousel">
                        <div class="single-testimonial-item text-center">
                            <img src="/avatars/default.png" alt="" class="client-img">
                            <p class="testimonial-text">J'ai trouvé un Chauffeur personnel sur la plateforme avec un prix abordable. J'ai pu faire moins de dépenses. Merci à Happy-TravelWorld</p>
                            <h4 class="client-name">Cédric KOSSI</h4>
                            <p class="theme-color">Voyageur</p>
                        </div>
                        <div class="single-testimonial-item text-center">
                            <img src="/avatars/default.png" alt="" class="client-img">
                            <p class="testimonial-text">J'ai trouvé un Chauffeur personnel sur la plateforme avec un prix abordable. J'ai pu faire moins de dépenses. Merci à Happy-TravelWorld</p>
                            <h4 class="client-name">Roméo ABALO</h4>
                            <p class="theme-color">Voyageur</p>
                        </div>
                        <div class="single-testimonial-item text-center">
                            <img src="/avatars/default.png" alt="" class="client-img">
                            <p class="testimonial-text">J'ai trouvé un Chauffeur personnel sur la plateforme avec un prix abordable. J'ai pu faire moins de dépenses. Merci à Happy-TravelWorld</p>
                            <h4 class="client-name">Guy KOFFI</h4>
                            <p class="theme-color">Voyageur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
@endsection