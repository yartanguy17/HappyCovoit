
@extends('layouts.base_user')
@section('title')
Souscrire HT-ASSURANCE
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
                        <li><a>Souscrire HT-ASSURANCE</a></li>
                    </ol>
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
@if (Session::has('flash_message_success'))
<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">;
swal("{{ session('flash_message_success') }}", "Merci", "success");
</script>
@endif
<section class="section-padding our-vehicles-section">
    <div class="container">
        <div class="row">
           <div class="col-lg-6">
            <img src="/assets/image2.jpeg" style="" alt="">
        </div>
        <div class="col-lg-6">
            <div class="booking-form">
                <form  id="validate-payment" method="post">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" value="" name="validite" id="validite" hidden>
                    <hr>
                    <center>
                        <div style="background-color: orange;border-color: orange;border-radius: 10px;width: 60%;padding: 10px;color: white;">
                            <h6 style="text-align: center;color: white;">Validité de la souscription</h6>
                            <center>Du <span id="debut">XX-XX-XXXX</span> au <b id="fin">XX-XX-XXXX</b></center>
                        </div>
                        <br>
                        <div class="form-group">
                                        <input type="checkbox" id="checkbox_" name="checkbox" checked="true">
                                        <a href="/contrat-assurance" target="_blank">
                                            J'ACCEPTE LES TERMES DU CONTRAT
                                        </a>
                                    </div>
                                    <br>
                        <button type="submit" id="submit" class="button button-dark tiny find-depart" style="border-radius: 10px;">Valider</button>
                    </center>
                </form>
            </div>
        </div>

    </div>
</div>

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
            <p>Nouvelle souscription effectuée, En attente de Paiement. Cliquez sur le bouton "OK" pour effectuer le paiement.</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" onclick="redirect()" style="color: white;">OK</a>
        </div>
    </div>
</div>
</div>
<div aria-hidden="true" aria-labelledby="createModalLabel" class="modal fade"
id="paymentCard2"
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
            <p>Nouvelle souscription effectuée, En attente de Paiement.</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" data-dismiss="modal" onclick="redirect2()"  style="color: white;">Fermer</a>
        </div>
    </div>
</div>
</div>
<button id="pay-btn" hidden="true"></button>
</section>
@endsection
@section('scripts')
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

function redirect2() {
    $('#paymentCard').off('hide.bs.modal.prevent');
    $("#paymentCard").modal('hide');
    window.location.href = '/user/dashboard';
}

function afterValidate(data) {
 link = data;
 $('#paymentCard').modal('show'); 
}
function payWithFedapay() {
    $('#pay-btn').click();
}
</script>
<script type="text/javascript">
    $(document).ready(function() {
        FedaPay.init('#pay-btn', {
        public_key: 'pk_live_Qu8Pj2lm2RmRwOBH_9f4GRiI',
        transaction: {
          amount: 15000,
          description: 'Souscription sur HappyTravelWorld'
      },
      customer: {
          email: 'Komarf28@gmail.com',
          lastname: 'KOUGBADA',
          firstname: 'Omar Farouk',
      }
  });

        var today = new Date();
        var currentDay = today.getDate();
        var currentMonth = today.getMonth() + 1;
        var currentYear = today.getFullYear();
        if (currentDay < 10) {
            var currentDay = "0" + currentDay;
        }
        if (currentMonth < 10) {
            var currentMonth = "0" + currentMonth;
        }

        var currentDate =  currentDay + "-" + currentMonth + "-" + currentYear;
        $('#debut').text(currentDate);

        var finDay = today.getDate();
        var finMonth = today.getMonth() + 1;
        var finYear = today.getFullYear() + 1;

         if (finDay < 10) {
            var finDay = "0" + finDay;
        }
        if (finMonth < 10) {
            var finMonth = "0" + finMonth;
        }

        //var finDate = today.getTime() + (1000*60*60*24*365);
        var finDate =  finDay + "-" + finMonth + "-" + finYear;
        $('#fin').text(finDate + " 23:59:59");

        $('#validite').val("Du " + currentDate + " au " + finDate + " 23:59:59");
    });

    $("#validate-payment").submit(function() {
    var validite = $('#validite').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        url: '/user/subscribe-assurance',
        type: 'json',
        data: {
            validite: validite
        },
        enctype: 'multipart/form-data',
        statusCode: {
            422: function(data) {
                var errors = data.responseJSON.errors;
                console.log(errors);
            }
        },
    }).done(function(data) {
                //console.log(data)
                //me.find('input').val("")
                console.log(data);
                //updateChat(data)
                //alert(data);
                //alert(data);
                if (data==-1) {
                    swal("Désolé, Il y a une souscription active en cours!", "Merci", "error");
                }else if (data==-3) {
                    //$('#paymentCard2').modal('show'); 
                    payWithFedapay();
                }else{
                    afterValidate(data);
                }
                
                
            }).fail(function(data) {
                console.log(data.responseJSON.errors);
            })

            return false;
        });

</script>
@endsection