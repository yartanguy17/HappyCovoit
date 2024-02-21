
@extends('layouts.base_user')
@section('title')
Publier un départ
@endsection
@section('content')
<section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ol class="breadcrumb">
                    <li><a href="/user/dashboard">Tableau de Bord</a></li>
                </ol>
            </div>
            <div class="col-lg-6">
                <div class="text-right">
                    <ol class="breadcrumb" style="float: right;">
                        <li><a>Chercher un départ</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding our-vehicles-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="booking-form">
                    <form action="/user/search-departure" method="post">
                         {{ csrf_field() }}
                        <div class="from-group destination">
                            <label for="">Lieu de Destination</label>
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="lieu_destination" placeholder="Lieu de Destination" id="" class="form-control" required>
                        </div>
                        <div class="from-group destination">
                            <label for="">Nombre de places</label>
                            <i class="fas fa-user"></i>
                            <input type="number" name="nbre_places" placeholder="Nombre de places" id="" class="form-control" required>
                        </div>
                        <center><button type="submit" class="button button-dark tiny find-depart">Publier</button></center>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="/assets/image.jpg" style="" alt="">
            </div>
        </div>
    </div>
</section>
@endsection