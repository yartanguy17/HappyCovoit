@extends("layouts.base_admin") @section('title') Ajouter un depart @endsection @section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>AJOUTER D'UN DÉPART</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ajouter un depart</a>
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
            <h5>Ajouter un depart</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <form action="/admin/add-depart" method="post">
               {{ csrf_field() }}
                <div class="m-b-20">
                    <h4 class="sub-title">Completez le formulaire suivant</h4>
                    <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Compagnie</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <select class="form-control" name="compagnie_id" required>
                                        <option value="">Choisir</option>
                                        @foreach($compagnies as $compagnie)
                                        @if($compagnie->user->status==1)
                                            <option value="{{ $compagnie->user->id }}">{{ $compagnie->denomination }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Pays de Destination</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" name="pays_destination" placeholder="Pays de Destination" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Ville de destination</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" name="ville_destination"  placeholder="Ville de destination" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Nombre de places</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="number" name="nbre_places" placeholder="Nombre de places" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Prix Unitaire</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" name="prix_unitaire"  placeholder="Prix Unitaire" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Pays de démarrage</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" name="pays_demarrage" placeholder="Pays de démarrage" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Ville de démarrage(Précision quartier)</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" name="ville_demarrage"  placeholder="Ville de démarrage(Précision quartier)" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Jour</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <select class="form-control" name="jour">
                                        <option value="Lundi">Lundi</option>
                                        <option value="Mardi">Mardi</option>
                                        <option value="Mercredi">Mercredi</option>
                                        <option value="Jeudi">Jeudi</option>
                                        <option value="Vendredi">Vendredi</option>
                                        <option value="Samedi">Samedi</option>
                                        <option value="Dimanche">Dimanche</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Heure de Départ</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="time" name="heure_demarrage"  placeholder="Heure de Départ" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <button type="submit" class="btn btn-primary m-b-0">PUBLIER</button>
                            </center>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection @section('script') @endsection