@extends('layouts.base_user')
@section('title')
Compagnies Partenaires
@endsection
@section('content')
@if (Session::has('flash_message_success'))
<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">;
swal("{{ session('flash_message_success') }}", "Merci", "success");
</script>
@endif
<section class="section-padding driver-dashboard-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="passanger-name">
                    <div class="media">
                         <img class="mr-3" style="width: 20%;" src="{{ getUserAuth()->avatar }}" alt="{{ getUserAuth()->avatar }}">
                        <div class="media-body">
                            <h2 class="mt-0">{{ getUserAuthName() }}</h2>
                            <p><b>ID</b> {{ getUserAuth()->token }} </p>
                            <a href="/user/dashboard">Tableau de Bord</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 right-text">
                <h2>
                    <?= (getUserAuth()->type_user==1)?"Particulier":"Chauffeur"?>
                </h2>
                <?php
                if(getUserAuth()->type_user == 2){
                    ?>
                    <a href="/user/add-departure" class="button button-light find-depart" style="border-radius: 10px;padding: 15px;">Publier un départ</a>
                    <a href="/choice" class="button button-dark find-depart" style="border-radius: 10px;padding: 15px;">Chercher un départ</a>
                    <a href="/user/subscribe" class="button button-light find-depart" style="border-radius: 10px;padding: 15px;background-color: green;border-color: green">Souscrire</a>
                    <a href="/user/subscribe-assurance" class="button button-light find-depart" style="border-radius: 10px;padding: 15px;background-color: blue;border-color: blue">Souscrire HT-ASSURANCE</a>
                    <?php
                }else{
                   ?>
                   <a href="/choice" class="button button-light find-depart" style="border-radius: 10px;">Chercher un départ</a>
                   <?php
               }
               ?>

           </div>
     </div>
     <div class="row">
        <div class="col-lg-12">
            <?php
            if(getUserAuth()->type_user == 2){
                ?>
                <p style="color: #F7BC00;font-size: 20px;">Pour votre sécurité n’allez pas chercher un client que vous ne connaissez pas chez lui, évitez les voyages de nuit.</p>
                <?php
            }else{
             ?>
             <p style="color: #F7BC00;font-size: 20px;">Pour votre sécurité ne voyagez pas de nuit ; ne prenez pas rendez-vous avec un chauffeur si ce n’est à l’autogare.</p>
             <?php
         }
         ?>

     </div>
     <div class="col-lg-12">
        <h2>Liste des Compagnies</h2>
        <div class="total-earning-table table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($compagnies as $compagnie)
                                        @if($compagnie->user->status==1)
                  <tr>
                    <td>{{$compagnie->denomination}}</td>
                    <td>
                        <?php
                        if (checkIfSubscribes($compagnie->user->id)>0) {
                              ?>
                            <a href="/desubscribe-compagnie/{{$compagnie->user->id}}" class="btn btn-danger" style="color: white;" >Se désabonner</a>
                            <?php
                        }else{
                            ?>
                            <a href="/subscribe-compagnie/{{$compagnie->user->id}}" class="btn btn-success">S'abonner</a>
                            <?php
                        }
                        ?>
                        
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</section>
@endsection