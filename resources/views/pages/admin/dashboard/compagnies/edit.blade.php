@extends("layouts.base_admin") @section('title') Modifier une compagnie @endsection @section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>MODIFICATION D'UNE COMPAGNIE</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Modifier une compagnie</a>
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
            <h5>Modifier une compagnie</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <form action="/admin/edit-compagnie/{{ $compagnie->id }}" method="post" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="m-b-20">
                <h4 class="sub-title">Modifiez le formulaire suivant</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Dénomination</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-layers"></i></span>
                                <input type="text" value="{{ $compagnie->denomination }}" name="denomination" placeholder="Dénomination" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Téléphone</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-phone"></i></span>
                                <input type="text" value="{{ $compagnie->user->telephone }}" name="telephone" placeholder="Téléphone" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Pseudo</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-user"></i></span>
                                <input type="text" value="{{ $compagnie->user->pseudo }}" name="pseudo" placeholder="Pseudo" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Photo de Profil</label>
                        <div class="col-sm-8 col-lg-10">
                            <div class="input-group">
                                    <input type="file" name="avatar">
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
<a class="btn btn-secondary"
href="/admin/all-compagnies">
<i class="feather icon-arrow-left"></i>
</a>
</div>
@endsection @section('script') @endsection