@extends("layouts.base_admin") @section('title') Ajouter un administrateur @endsection @section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>AJOUTER D'UN ADMINISTRATEUR</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ajouter un administrateur</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
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
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <h5>Ajouter un administrateur</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <form action="/admin/add-admin" method="post">
             {{ csrf_field() }}
             <div class="m-b-20">
                <h4 class="sub-title">Completez le formulaire suivant</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Email</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                <input type="text" name="email" placeholder="Email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Rôle</label>
                        <div class="col-sm-8 col-lg-10">
                          <div class="input-group">
                            <select name="niveau" class="form-control" required>
                               <option value="1">Gestion des Voyageurs</option>
                               <option value="2">Gestion des Chauffeurs</option>
                               <option value="3">Gestion des Compagnies</option>
                           </select>
                       </div>
                   </div>
               </div>
           </div>
           <div class="row">
            <div class="col-lg-6">
                <label class="col-sm-8 col-form-label">Nouveau Mot de passe</label>
                <div class="col-sm-8 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-shield"></i></span>
                        <input type="password" name="password" placeholder="Nouveau Mot de passe" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-sm-8 col-form-label">Confirmation</label>
                <div class="col-sm-8 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-shield"></i></span>
                        <input type="password" name="c_password" placeholder="Confirmation" class="form-control" required>
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
@endsection @section('script') @endsection