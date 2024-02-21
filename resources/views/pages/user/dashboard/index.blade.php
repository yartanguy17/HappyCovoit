@extends('layouts.base_user')
@section('title')
Tableau de Bord
@endsection
@section('tops')
<script type="text/javascript" src="{{ asset('Backoffice/bower_components/jquery/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('Backoffice/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<link href="{{ asset('assets/css/intlTelInput.css')}}" rel="stylesheet">
<script src="{{ asset('assets/js/intlTelInput.js')}}"></script>
@endsection
@section('content')
@if (Session::has('flash_message_success'))
<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">;
swal("{{ session('flash_message_success') }}", "Merci", "success");
</script>
@endif
@if (Session::has('flash_message_error'))
<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">;
swal("{{ session('flash_message_error') }}", "Merci", "error");
</script>
@endif
<section class="section-padding driver-dashboard-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="passanger-name">
                    <div class="media">
                        <img class="mr-3" style="width: 20%;" src="{{ getUserAuth()->avatar }}" alt="partner-img">
                        <div class="media-body">
                            <h2 class="mt-0">{{ getUserAuthName() }}</h2>
                            <p><b>ID</b> {{ getUserAuth()->token }} </p>
                            <!--<a href="#">Modifier son profil</a>-->
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
        <div class="tab-dashboard">
            @include('pages.user.dashboard.includes.menu')
            <div class="tab-content">
                <?php
                if(getUserAuth()->type_user == 1){
                    ?>
                    @include('pages.user.dashboard.includes.particulier.dashboard')
                    @include('pages.user.dashboard.includes.particulier.voyages_particulier')
                    @include('pages.user.dashboard.includes.particulier.settings')
                    @include('pages.user.dashboard.includes.particulier.notifications')
                    <?php
                }else if(getUserAuth()->type_user == 2){
                    ?>
                    @include('pages.user.dashboard.includes.chauffeur.dashboard')
                    @include('pages.user.dashboard.includes.chauffeur.vehicles')
                    @include('pages.user.dashboard.includes.chauffeur.voyages_chauffeur')
                    @include('pages.user.dashboard.includes.chauffeur.voyages_chauffeur_effectues')
                    @include('pages.user.dashboard.includes.chauffeur.settings')
                    @include('pages.user.dashboard.includes.chauffeur.notifications')
                    @include('pages.user.dashboard.includes.chauffeur.souscriptions')
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</div>
</div>
</section>
<div aria-hidden="true" aria-labelledby="createModalLabel" class="modal fade"
id="paymentCard"
role="dialog" tabindex="-1">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel3"><i
                class="ti-marker-alt m-r-10"></i>Status
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Informations mises à jour, En attente de Paiement. Cliquez sur le bouton "OK" pour effectuer le paiement.</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" onclick="redirect()" style="color: white;">OK</a>
        </div>
    </div>
</div>
</div>
<button id="pay-btn" hidden="true"></button>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#phone').keyup(function() {
            if($('#phone').val().length > 0){
                var phone = $('#phone').val();

                var first_character = phone.charAt(0);

                if (first_character == "+") {
                    $('#alert_phone').css("display","none");
                }else{
                    $('#alert_phone').css("display","inline-block");
                }
                
                //var indicatif = $('.selected-flag').attr('title');
                
                //var split_data = indicatif.split(": ");
                var indicatif = phone.substring(0, 4);
                //console.log(indicatif);
                $('#indicatif').val(indicatif)
            }
        });
        $('#phone2').keyup(function() {
            if($('#phone2').val().length > 0){
                var phone = $('#phone2').val();

                var first_character = phone.charAt(0);

                if (first_character == "+") {
                    $('#alert_phone2').css("display","none");
                }else{
                    $('#alert_phone2').css("display","inline-block");
                }
                
                //var indicatif = $('.selected-flag').eq(1).attr('title');
                
                //var split_data = indicatif.split(": ");
                var indicatif = phone.substring(0, 4);
                console.log(indicatif);
                $('#indicatif2').val(indicatif)
            }
        });
    });
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        utilsScript: "{{ asset('assets/js/utils.js')}}",
    });
    var input = document.querySelector("#phone2");
    window.intlTelInput(input, {
        utilsScript: "{{ asset('assets/js/utils.js')}}",
    });
</script>
<script src="https://cdn.fedapay.com/checkout.js?v=1.1.5"></script>
<script type="text/javascript">
 var link = "";

 $('#paymentCard').on('hide.bs.modal.prevent', closeModalEvent);

 function closeModalEvent(e) {
    e.preventDefault();
    $('#paymentCard').off('hide.bs.modal.prevent');
    $("#paymentCard").modal('hide');
    var win = window.open(link, '_blank');
    window.location.href = '/user/dashboard';
}

function redirect() {
    $('#paymentCard').off('hide.bs.modal.prevent');
    $("#paymentCard").modal('hide');
    var win = window.open(link, '_blank');
    window.location.href = '/user/dashboard';
}
function afterValidate(data) {
   link = data;
   $('#paymentCard').modal('show'); 
}
</script>
<script type="text/javascript">

    function payNow(idSouscription) {
        var idSouscription = parseInt(idSouscription);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            url: '/user/pay-subscribe/'+idSouscription,
            type: 'json',
            enctype: 'multipart/form-data',
            statusCode: {
                422: function(data) {
                    var errors = data.responseJSON.errors;
                    console.log(errors);
                },
                500: function(data) {
                    var errors = data.responseJSON.errors;
                    console.log(data);
                }
            },
        }).done(function(data) {
                console.log(data);
                if (data==-1) {
                    swal("Désolé, Il y a une souscription active en cours!", "Merci", "error");
                }else{
                    afterValidate(data);
                }
                
                
            }).fail(function(data) {
                console.log(data.responseJSON.errors);
            })

            return false;
    }

    </script>
    @endsection