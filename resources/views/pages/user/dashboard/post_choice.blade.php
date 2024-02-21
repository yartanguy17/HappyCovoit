
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
                <form action="/user/post-choice" method="post">
                    <input type="text" class="form-control" value="1" name="total_price" id="total_price" hidden>
                    <input type="text" class="form-control" value="{{ $destination->id }}" name="destination_id" hidden>
                    {{ csrf_field() }}
                    <div class="from-group destination">
                        <label for="">Nombre de places à reserver</label>
                        <input type="number" name="nbre_places" id="nbre_places" placeholder="Nombre de places à reserver" id="" class="form-control" required>
                        <span class="mr-2" style="color:red;display:none;" id="alert-failed">Désolé, nombre de places demandé n'est pas disponible.
                        </span>
                        <span class="mr-2" style="color:green;display:none;" id="alert-success">Nombre de places demandé disponible.
                        </span>
                        <span class="mr-2" style="color:red;display:none;" id="alert-zero">Veuillez saisir une valeur supérieure à 0
                        </span>
                    </div>
                    <hr>
                    <center>
                        <div style="background-color: orange;border-color: orange;border-radius: 10px;width: 60%;padding: 10px;color: white;">
                            <h6 style="text-align: center;color: white;">Total A Payer + Commission</h6>
                            <center><span>{{ $destination->prix_unitaire }} FCFA</span> x <span id="nbre_places_">1</span> = <b id="total"><?= $destination->prix_unitaire ?></b> FCFA</center>
                        </div>
                        <br>
                        <button type="submit" id="submit" class="button button-dark tiny find-depart" style="border-radius: 10px;">Valider</button>
                    </center>
                </form>
            </div>
        </div>

    </div>
</div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#submit').prop("disabled",true);
        var valide=0;
        
        function actualize() {
            if(valide==1){
                $('#submit').prop("disabled",false);
            }else {
                $('#submit').prop("disabled",true);
            }
        }
        $('#nbre_places').keyup(function() {
            if($('#nbre_places').val().length > 0){
                checkPlaces();
            }else{
                $('#alert-failed').css("display","none");
                $('#alert-success').css("display","none");
            }
        });


        function checkPlaces() {
            var nbre_places_dispo = parseInt('{{ getPlacesDispo($destination->id) }}');
            var prix_unitaire = parseInt({{ $destination->prix_unitaire }});
            var nbre_places = $('#nbre_places').val();
           // var comission = prix_unitaire*nbre_places*0.065;
            if(nbre_places.length > 0){
                if (nbre_places > 0) {
                    if (nbre_places <= nbre_places_dispo) {
                        console.log("Oui")
                        $('#alert-failed').css("display","none");
                        $('#alert-success').css("display","inline-block");
                        $('#alert-zero').css("display","none");
                        $('#total').text(prix_unitaire*nbre_places);
                        $('#total_price').val(prix_unitaire*nbre_places);
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
            
            
            /*$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'post',
                url: '/check-place-destination/' + id,
                type: 'json',
                data: {
                    nbre_places: nbre_places
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
                console.log(data);
            }).fail(function(data) {
                console.log(data.responseJSON.errors);
            })*/
        }
    });
</script>
@endsection