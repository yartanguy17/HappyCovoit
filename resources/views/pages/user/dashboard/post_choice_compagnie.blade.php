
@extends('layouts.base_user')
@section('title')
Finaliser
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
                        <li><a>Finaliser</a></li>
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
            <img src="/assets/image.jpg" style="" alt="">
        </div>
        <div class="col-lg-6">
            <div class="booking-form">
                <form id="validate-payment" method="post">
                    <input type="text" class="form-control" value="" name="total_price" id="total_price" hidden>
                    <input type="text" class="form-control" value="{{ $destination->id }}"  id="destination_id" name="destination_id" hidden>
                    {{ csrf_field() }}
                    <div class="from-group destination">
                        <label for="">Nombre de places à reserver</label>
                        <input type="number" name="nbre_places" id="nbre_places" placeholder="Nombre de places à reserver" class="form-control" required>
                        <span class="mr-2" style="color:red;display:none;" id="alert-failed">Désolé, nombre de places demandé n'est pas disponible.
                        </span>
                        <span class="mr-2" style="color:green;display:none;" id="alert-success">Nombre de places demandé disponible.
                        </span>
                        <span class="mr-2" style="color:red;display:none;" id="alert-zero">Veuillez saisir une valeur supérieure à 0
                        </span>
                    </div>
                    <input type="number" name="ligne_id" id="ligne_id" hidden="true" placeholder="Ligne" value="<?= ($ligne==null)?0:$ligne->id ?>" class="form-control" required>


                    
                    <p style="text-align: center">
                        <h5 style="text-align: center;">Date de départ</h5>
                        <h4 style="color: orange;text-align: center;">{{ getFullDate($date_demarrage) }}</h4>
                    </p>
                    <hr>
                    <center>
                        <div style="background-color: orange;border-color: orange;border-radius: 10px;width: 60%;padding: 10px;color: white;">
                            <h6 style="text-align: center;color: white;">Total A Payer + Commission</h6>
                            <center><span>{{ ($ligne==null)?$destination->prix_unitaire:$ligne->prix_unitaire }} FCFA</span> x <span id="nbre_places_">1</span> = <b id="total"><?= ($ligne==null)?intval($destination->prix_unitaire*1.065) + 1:intval($ligne->prix_unitaire*1.065) + 1 ?></b> FCFA</center>
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
            <p>Nouvelle reservation effectuée, En attente de Paiement. Cliquez sur le bouton "OK" pour effectuer le paiement.</p>
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
            <p>Nouvelle reservation effectuée, En attente de Paiement.</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" data-dismiss="modal" onclick="redirect2()"  style="color: white;">Fermer</a>
        </div>
    </div>
</div>
</div>
</section>
<button id="pay-btn" hidden="true"></button>
@endsection
@section('scripts')
<script src="https://cdn.fedapay.com/checkout.js?v=1.1.5"></script>
<script language="javascript">
    var dayDestination = '{{ $destination->jour }}';
    var valide=0;
    function actualize() {
        if(valide==1){
            $('#submit').prop("disabled",false);
            FedaPay.init('#pay-btn', {
                public_key: 'pk_live_Qu8Pj2lm2RmRwOBH_9f4GRiI',
                transaction: {
                  amount: parseInt($('#total_price').val()),
                  description: 'Réservation de Ticket de Bus'
              },
              customer: {
                  email: 'Komarf28@gmail.com',
                  lastname: 'KOUGBADA',
                  firstname: 'Omar Farouk',
              }
          });
        }else {
            $('#submit').prop("disabled",true);
        }
    }
    //function get day
    function getDay(dateEnter) {
        var weekday = new Array(7);
        weekday[0] = "Dimanche";
        weekday[1] = "Lundi";
        weekday[2] = "Mardi";
        weekday[3] = "Mercredi";
        weekday[4] = "Jeudi";
        weekday[5] = "Vendredi";
        weekday[6] = "Samedi";

        return weekday[dateEnter.getDay()];
    }
    //function to convert enterd date to any format
    function checkDate(xObj){
        valide=0;
        $('#alert-incompatible').css("display","none");
        $('#alert-failed2').css("display","none");
        var today = new Date();
        var date = new Date(xObj.value);
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var year = date.getFullYear();
        var monthd = today.getMonth() + 1;
        var dayd = today.getDate();
        var yeard = today.getFullYear();
        console.log(day+' '+ month +' '+year+'\n');
        console.log(dayd+' '+ monthd +' '+yeard);
        if(year<yeard){
            $('#alert-failed2').css("display","inline-block");
            /*console.log("modif1");
            if (dayd<10) {
                document.getElementById('date').value=yeard+"-"+monthd+"-0"+dayd;
            }else {
                document.getElementById('date').value=yeard+"-"+monthd+"-"+dayd;
            }*/

        }else if(year=yeard) {
            if(month<monthd){
             $('#alert-failed2').css("display","inline-block");
                /*console.log("modif2");
                if (dayd<10) {
                    document.getElementById('date').value=yeard+"-"+monthd+"-0"+dayd;
                }else {
                    document.getElementById('date').value=yeard+"-"+monthd+"-"+dayd;
                }*/
            }else if(month==monthd) {
                if(day<dayd){
                 $('#alert-failed2').css("display","inline-block");
                    /*console.log("modif3");
                    if (dayd<10) {
                        document.getElementById('date').value=yeard+"-"+monthd+"-0"+dayd;
                    }else {
                        document.getElementById('date').value=yeard+"-"+monthd+"-"+dayd;
                    }*/
                }else{
                    var dayChoose = getDay(date);
                    if (dayChoose != dayDestination) {
                        $('#alert-incompatible').css("display","inline-block");
                    }else{
                        valide=1;
                    }
                }
            }else{
                var dayChoose = getDay(date);
                if (dayChoose != dayDestination) {
                    $('#alert-incompatible').css("display","inline-block");
                }else{
                    valide=1;
                }
                
            }
        }else{
         var dayChoose = getDay(date);
         if (dayChoose != dayDestination) {
            $('#alert-incompatible').css("display","inline-block");
        }else{
            valide=1;
        }
    }
    actualize();
}
</script>
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

$(document).ready(function() {

    $('#submit').prop("disabled",true);
    $('#nbre_places').keyup(function() {
        if($('#nbre_places').val().length > 0){
            checkPlaces();
        }else{
            $('#alert-failed').css("display","none");
            $('#alert-success').css("display","none");
        }
    });


    function checkPlaces() {
        var nbre_places_dispo = parseInt('{{ getPlacesDispoCompagnieNew($destination->id,$date_demarrage) }}');
        var prix_unitaire = parseInt({{ ($ligne==null)?$destination->prix_unitaire:$ligne->prix_unitaire }});
        var nbre_places = $('#nbre_places').val();
        var comission = prix_unitaire*nbre_places*0.065;
        if(nbre_places.length > 0){
            if (nbre_places > 0) {
                if (nbre_places <= nbre_places_dispo) {
                    console.log("Oui")
                    $('#alert-failed').css("display","none");
                    $('#alert-success').css("display","inline-block");
                    $('#alert-zero').css("display","none");
                    var price = parseInt((prix_unitaire*nbre_places) + comission);
                    $('#total').text(price + 1);
                    $('#total_price').val(price + 1);
                    $('#nbre_places_').text(nbre_places);
                    valide=1;
                    actualize();
                }else{
                    console.log("Non")
                    $('#alert-failed').css("display","inline-block");
                    $('#alert-success').css("display","none");
                    $('#alert-zero').css("display","none");
                    valide=0;
                    actualize();
                }
            }else{
                $('#alert-zero').css("display","inline-block");
                $('#alert-failed').css("display","none");
                $('#alert-success').css("display","none");
                valide=0;
                actualize();
            }
        }else{
            $('#alert-zero').css("display","none");
            $('#alert-failed').css("display","none");
            $('#alert-success').css("display","none");
        }

    }
});




$("#validate-payment").submit(function() {
    var destination_id = $('#destination_id').val();
    var total_price = $('#total_price').val();
    var nbre_places = $('#nbre_places').val();
    var ligne_id = $('#ligne_id').val();
    var date_depart = '{{ $date_demarrage }}';
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        url: '/user/validate-post-choice-compagnie',
        type: 'json',
        data: {
            destination_id: destination_id,
            total_price: total_price,
            nbre_places: nbre_places,
            date_depart: date_depart,
            ligne_id: ligne_id
        },
        enctype: 'multipart/form-data',
        statusCode: {
            422: function(data) {
                var errors = data.responseJSON.errors;
                console.log(errors);
            },
            500: function(data) {
                console.log(data);
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
                    swal("Vous ne pouvez pas choisir cette destination!", "Merci", "error");
                }else if (data==99) {
                    swal("Nombre de places indisponible!", "Merci", "error");
                }else if (data==-2) {
                    swal("Vous avez atteint le nombre de réservations pour cette destination!", "Merci", "error");
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