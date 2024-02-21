
@extends('layouts.base_user')
@section('title')
Modifier son mot de passe
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
                        <li><a>Modifier son mot de passe</a></li>
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
            <div class="col-lg-2">

            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Modifier son mot de passe</h5>
                    </div>
                    <div class="card-block">
                        <form action="/user/change-password" method="post">
                            {{ csrf_field() }}
                            <div class="m-b-20">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="col-sm-8 col-form-label">Mot de passe actuel</label>
                                        <div class="col-sm-8 col-lg-10">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-shield"></i></span>
                                                <input type="password" name="c_password" placeholder="Mot de passe actuel" class="form-control" required>
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
                                                <input type="password" name="n_password" placeholder="Nouveau Mot de passe" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-sm-8 col-form-label">Confirmation</label>
                                        <div class="col-sm-8 col-lg-10">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-shield"></i></span>
                                                <input type="password" name="cn_password" placeholder="Confirmation" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
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
            <div class="col-lg-2">

            </div>
        </div>
    </div>
</section>
@endsection