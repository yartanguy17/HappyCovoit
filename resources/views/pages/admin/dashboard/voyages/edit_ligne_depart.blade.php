@extends("layouts.base_admin") @section('title') Modifier une ligne @endsection @section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>MODIFIER UNE LIGNE</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Modifier une ligne</a>
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
            <h5>Modifier une ligne</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <form action="/admin/edit-ligne-depart/{{ $ligneDepart->id }}" method="post">
               {{ csrf_field() }}
                <div class="m-b-20">
                    <h4 class="sub-title">Completez le formulaire suivant</h4>
                    <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Pays de Destination</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" value="{{ $ligneDepart->pays_destination }}" name="pays_destination" placeholder="Pays de Destination" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Ville de Destination</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" value="{{ $ligneDepart->ville_destination }}" name="ville_destination"  placeholder="Ville de ligneDepart" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <label class="col-sm-8 col-form-label">Prix Unitaire</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                                    <input type="text" value="{{ $ligneDepart->prix_unitaire }}" name="prix_unitaire"  placeholder="Prix Unitaire" class="form-control" required>
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
    href="/admin/lignes-depart/{{ $ligneDepart->destination->id }}">
    <i class="feather icon-arrow-left"></i>
</a>
</div>
@endsection @section('script') @endsection