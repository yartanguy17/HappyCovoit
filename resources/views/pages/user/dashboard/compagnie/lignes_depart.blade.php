@extends("layouts.base_compagnie") @section('title') Toutes les lignes du départ {{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }} @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Toutes les lignes du départ {{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }}</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Toutes les lignes du départ</a>
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
      <h5>Liste des Départs</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="simpletable" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Pays</th>
              <th>Ville</th>
              <th>Prix unitaire</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
           @foreach($lignes as $ligne)
           <tr>
             <td>{{$ligne->pays_destination}}</td>
             <td>{{$ligne->ville_destination}}</td>
             <td>{{$ligne->prix_unitaire}} FCFA</td>
             <td>
              <a class="btn btn-primary"
              href="/user-compagnie/edit-ligne-depart/{{$ligne->id}}">
              <i class="feather icon-edit"></i>
            </a>
            <button type="button" class="btn btn-danger" data-toggle="modal"
            data-target="#deleteCard{{$ligne->id}}">
            <i class="feather icon-trash"></i>
          </button>
        </td>
      </tr>

      <div class="modal fade" id="deleteCard{{$ligne->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Etes-vous sûr de supprimer la ligne {{$ligne->ville_destination}}, {{$ligne->pays_destination}} ?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <a href="/user-compagnie/delete-ligne-depart/{{$ligne->id}}"
                class="btn btn-primary"> Oui</a>
                <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Pays</th>
          <th>Ville</th>
          <th>Prix unitaire</th>
          <th>Actions</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
</div>
<a class="btn btn-secondary"
    href="/user-compagnie/all-departs">
    <i class="feather icon-arrow-left"></i>
</a>
</div>
@endsection 
@section('script') 
@endsection
