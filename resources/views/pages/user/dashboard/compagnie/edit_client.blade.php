@extends("layouts.base_compagnie") @section('title') Modifier un client @endsection 
@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>MODIFIER D'UN CLIENT</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Modifier un client</a>
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
            <h5>Modifier un client</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <form action="/user-compagnie/edit-client/{{ $client->id }}" method="post">
             {{ csrf_field() }}
             <div class="m-b-20">
                <h4 class="sub-title">Completez le formulaire suivant</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Nom</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                <input type="text" name="nom" value="{{ $client->nom }}" placeholder="Nom" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Prénoms</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                <input type="text" name="prenoms" value="{{ $client->prenoms }}" placeholder="Prénoms" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Téléphone</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-phone"></i></span>
                                <input type="text" name="telephone" value="{{ $client->indicatif }}{{ $client->telephone }}" placeholder="Téléphone" class="form-control" required>
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
                            <button type="submit" class="btn btn-primary m-b-0">MODIFIER</button>
                        </center>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
</div>
@endsection