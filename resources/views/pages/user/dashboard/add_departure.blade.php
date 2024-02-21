
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
                        <li><a>Publier un départ</a></li>
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
                <div class="booking-form">
                    <form action="/user/add-departure" method="post">
                       {{ csrf_field() }}
                       <div class="row">
                        <div class="col-lg-6">
                            <div class="from-group destination">
                                <label for="">Pays de Destination</label>
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="pays_destination" placeholder="Pays de Destination" id="" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="from-group destination">
                                <label for="">Ville de destination</label>
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="ville_destination" id="" placeholder="Ville de Destination(précision)" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="from-group destination">
                        <label for="">Nombre de places</label>
                        <i class="fas fa-user"></i>
                        <input type="number" name="nbre_places" placeholder="Nombre de places" id="" class="form-control" required>
                    </div>
                    <div class="from-group destination">
                        <label for="">Prix Unitaire</label>
                        <i class="fas fa-money-bill-alt"></i>&nbsp;
                        <input type="text" name="prix_unitaire" placeholder="Prix Unitaire" id="" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="from-group destination">
                                <label for="">Pays de démarrage</label>
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="pays_demarrage" placeholder="Pays de démarrage" id="" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="from-group destination">
                                <label for="">Ville de démarrage(Précision quartier)</label>
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="ville_demarrage" id="" placeholder="Ville de démarrage avec plus de précision" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="from-group destination">
                                <label for="">Date de départ</label>
                                <i class="fas fa-calendar"></i>
                                <input type="date" onchange="checkDate(this)" name="date_demarrage" id="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="from-group destination">
                                <label for="">Heure de Départ</label>
                                <i class="fas fa-clock"></i>
                                <input type="time" name="heure_demarrage" id="" class="form-control" required>
                            </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <input type="checkbox" id="checkbox_" name="surcharge">
                        <span style="color: black;">
                            JE SUPPORTE LA SURCHARGE DANS MON VÉHICULE
                        </span>
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
@section('scripts')
<script language="javascript">
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
        //console.log(day+' '+ month +' '+year+'\n');
        //console.log(dayd+' '+ monthd +' '+yeard);
        if(year<yeard){
            
            //console.log("modif1");
            var dayd = today.getDate() + 1;
            if (dayd<10) {
                document.getElementById('date').value=yeard+"-"+monthd+"-0"+dayd;
            }else {
                document.getElementById('date').value=yeard+"-"+monthd+"-"+dayd;
            }

        }else if(year=yeard) {
            if(month<monthd){
               
                //console.log("modif2");
                var dayd = today.getDate() + 1;
                if (dayd<10) {
                    document.getElementById('date').value=yeard+"-"+monthd+"-0"+dayd;
                }else {
                    document.getElementById('date').value=yeard+"-"+monthd+"-"+dayd;
                }
            }else if(month==monthd) {
                if(day<dayd || day==dayd){
                   
                    //console.log("modif3");
                    var dayd = today.getDate() + 1;
                    if (dayd<10) {
                        document.getElementById('date').value=yeard+"-"+monthd+"-0"+dayd;
                    }else {
                        document.getElementById('date').value=yeard+"-"+monthd+"-"+dayd;
                    }
                }
            }
        }
}
</script>
@endsection
