@extends("layouts.base_compagnie") 
@section('title') 
Ajouter un client 
@endsection 
@section('top_script')
<link href="{{ asset('assets/css/intlTelInput.css')}}" rel="stylesheet">
@endsection 
@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>AJOUTER D'UN CLIENT</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ajouter un client</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
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
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <h5>Ajouter un client</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <form action="/user-compagnie/add-client" method="post">
             {{ csrf_field() }}
             <input type="text" id="indicatif" class="form-control" name="indicatif" hidden>
             <div class="m-b-20">
                <h4 class="sub-title">Completez le formulaire suivant</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Nom</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                <input type="text" name="nom" placeholder="Nom" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Prénoms</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                <input type="text" name="prenoms"  placeholder="Prénoms" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Téléphone</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="form-group">
                                            <input type="phone" id="phone"  class="form-control" name="telephone" placeholder="Numéro de téléphone" required style="width:255px;">
                                        </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Sexe</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                <select class="form-control" name="sexe">
                                    <option value="Masculin">Masculin</option>
                                    <option value="Féminin">Féminin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                            <button type="submit" class="btn btn-primary m-b-0">AJOUTER</button>
                        </center>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
</div>
@endsection 
@section('script') 
<script src="{{ asset('assets/js/intlTelInput.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#phone').keyup(function() {
            if($('#phone').val().length > 0){
                var indicatif = $('.selected-flag').attr('title');
                
                var split_data = indicatif.split(": ");
                console.log(split_data[1]);
                $('#indicatif').val(split_data[1])
            }
        });
    });
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        utilsScript: "{{ asset('assets/js/utils.js')}}",
    });
</script>
@endsection