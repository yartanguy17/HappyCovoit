@extends('layouts.base')
@section('title')
Packages
@endsection
@section('content')
 <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li><a href="/">Happy-Travel World</a></li>
                    </ol>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h2>Nos packages</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding our-pakages-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2 class="section-title text-center">Nos Packages</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="single-package-item text-center">
                        <div class="package-icon">
                            <span class="icon-wrapper">
                                <img src="/assets/images/icon/package-icon.png" alt="icon">
                            </span>
                        </div>
                        <div class="package-details">
                            <h4 class="section-title text-center">Chauffeur personnel</h4>
                            <h2 class="package-price">
                                5000Fcfa
                                <span>/an</span>
                            </h2>
                            <ul>
                                <li>Historique voyage</li>
                                <li>Note de Voyage</li>
                                <li>Voyage illimité</li>
                            </ul>
                            <a href="/register" class="button button-dark tiny find-depart">Souscrire</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
  
                </div>
                <div class="col-lg-5 offset-lg-0 col-md-6 offset-md-3">
                    <div class="single-package-item text-center">
                        <div class="package-icon">
                            <span class="icon-wrapper">
                                <img src="/assets/images/icon/package-icon.png" alt="icon">
                            </span>
                        </div>
                        <div class="package-details">
                            <h4 class="section-title text-center">Compagnie de Transport</h4>
                            <h2 class="package-price">
                                1000Fcfa
                                <span>/an</span>
                            </h2>
                            <ul>
                                 <li>Historique voyage</li>
                                <li>Note de Voyage</li>
                                <li>Voyage illimité</li>
                            </ul>
                            <a href="https://wa.me/22870357778" class="button button-dark tiny find-depart" style="font-size: 12px;">Contactez-nous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
