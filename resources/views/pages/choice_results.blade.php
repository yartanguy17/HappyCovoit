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
                    <h2>Résultats</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding our-pakages-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="section-title text-center">Résultats</h2>
            </div>
            @if($result == 0)
            <div class="col-lg-12" style="text-align: center;">
                <h4 style="color: red;">Aucune correspondance</h4>
            </div>
            @else
            <div class="col-lg-12">
                <div class="total-earning-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Départ</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Date et Heure Départ</th>
                                <th scope="col">Nombre de places disponibles</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">
                                    Chauffeur Personnel
                                </th>
                                <th>Choix</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($destinations as $destination)
                           <tr>
                            <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
                            <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
                            <td style="color: orange;font-weight: bold;">
                                <?php
                                $dateDemarrage = $destination->date_demarrage;
                                $explodeDats = explode("-", $dateDemarrage);
                                echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0] . " " .$destination->heure;
                                ?>
                            </td>
                            <td style="color: orange;font-weight: bold;">{{ getPlacesDispo($destination->id) }} <?= ($destination->surcharge==1)?"(Surcharge supporté)":"(Surcharge non supporté)"  ?></td>
                            <td>{{$destination->prix_unitaire}} FCFA</td>
                            <td>{{ getUserNameById($destination->user->id)}}</td>
                            <td>
                                <a href="/choice-suggestion/{{$destination->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            @endif
        </div>
        @if($result == 0)
        <hr>
        <div class="row">
             <div class="col-lg-12" style="">
                <h2 style="color: orange;">Résultats similaires</h2>
            </div>        
         <div class="col-lg-12">
                <div class="total-earning-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Départ</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Date et Heure Départ</th>
                                <th scope="col">Nombre de places disponibles</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">
                                    Chauffeur Personnel
                                </th>
                                <th>Choix</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($destinations as $destination)
                           <tr>
                            <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
                            <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
                            <td style="color: orange;font-weight: bold;">
                                <?php
                                $dateDemarrage = $destination->date_demarrage;
                                $explodeDats = explode("-", $dateDemarrage);
                                echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0] . " " .$destination->heure;
                                ?>
                            </td>
                            <td style="color: orange;font-weight: bold;">{{ getPlacesDispo($destination->id) }} <?= ($destination->surcharge==1)?"(Surcharge supporté)":"(Surcharge non supporté)"  ?></td>
                            <td>{{$destination->prix_unitaire}} FCFA</td>
                            <td>{{ getUserNameById($destination->user->id)}}</td>
                            <td>
                                <a href="/choice-suggestion/{{$destination->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
</section>
@endsection
@section('scripts')
@endsection
