@extends('layouts.base')
@section('title')
Contact
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
                        <h2>Contactez-nous</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding contact-info-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-contact-info text-center">
                        <img src="/assets/images/icon/contact_info.png" alt="icon">
                        <h4>Adresse</h4>
                        <p>Adresse : Tokoin-Centre, Lomé, TOGO</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-contact-info text-center">
                        <img src="/assets/images/icon/contact_info-2.png" alt="icon">
                        <h4>Numéro de téléphone</h4>
                        <p>Numéros : +22870357778, +22897397869</p>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-0 col-sm-6 offset-sm-3">
                    <div class="single-contact-info text-center">
                        <img src="/assets/images/icon/contact_info-3.png" alt="icon">
                        <h4>E-mail</h4>
                        <p>Email : happytravel.htworld@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (Session::has('flash_message_error'))
                <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
                <script type="text/javascript">;
                swal("{{ session('flash_message_error') }}", "Merci", "error");
                </script>
                @endif

    <section class="section-padding contact-form-section p-t-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <form action="/contact" method="POST">
                        {{ csrf_field() }}
                        <h2>Laissez-nous un mail</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="Nom complet" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="email" placeholder="E-mail" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="telephone" placeholder="Numéro de téléphone" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="subject" placeholder="Objet" class="form-control" required>
                            </div>
                            <div class="col-lg-12">
                                <textarea class="form-control" name="message" placeholder="Votre message" required></textarea>
                            </div>
                        </div>
                        <button class="button button-dark tiny find-depart" type="submit">Envoyer</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="contact-us-map">
                        <div id="contact-map"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
