@extends("layouts.base_compagnie") @section('title') Tous les Départs @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Tous les Départs</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Tous les Départs</a>
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
              <th>Destination</th>
              <th>Départ</th>
              <th>Jour et Heure Départ</th>
              <th>Nombre de places</th>
              <th>Prix unitaire</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($destinations as $destination)
            <tr>
             <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
             <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
             <td>
               <?= $destination->jour. " " .$destination->heure;
               ?>
             </td>
             <td>{{$destination->nbre_places}}</td>
             <td>{{$destination->prix_unitaire}} FCFA</td>
             <td>
              <a class="btn btn-primary"
              href="/user-compagnie/edit-depart/{{$destination->id}}">
              <i class="feather icon-edit"></i>
            </a>
            <button type="button" class="btn btn-warning" data-toggle="modal"
            data-target="#suppressCard{{$destination->id}}">
            &times;
          </button>
          <button type="button" class="btn btn-danger" data-toggle="modal"
          data-target="#deleteCard{{$destination->id}}">
          <i class="feather icon-trash"></i>
        </button>
        <button type="button" class="btn btn-success" data-toggle="modal"
        data-target="#addCard{{$destination->id}}">
        <i class="feather icon-plus"></i> Ajouter une ligne
      </button>
      <a class="btn btn-info"
      href="/user-compagnie/lignes-depart/{{$destination->id}}">
      <i class="feather icon-eye"></i>Lignes
    </a>
  </td>
</tr>
<div class="modal fade" id="addCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter une ligne</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/user-compagnie/add-ligne-depart/{{ $destination->id }}" method="post">
       {{ csrf_field() }}
       <div class="m-b-20">
        <div class="row">
          <div class="col-lg-6">
            <label class="col-sm-12 col-form-label">Pays de Destination</label>
            <div class="col-sm-12 col-lg-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                <input type="text" name="pays_destination" placeholder="Pays de Destination" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <label class="col-sm-12 col-form-label">Ville de destination</label>
            <div class="col-sm-12 col-lg-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                <input type="text" name="ville_destination"  placeholder="Ville de destination" class="form-control" required>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label class="col-sm-12 col-form-label">Prix Unitaire</label>
            <div class="col-sm-12 col-lg-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                <input type="text" name="prix_unitaire"  placeholder="Prix Unitaire" class="form-control" required>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <center>
              <button type="submit" class="btn btn-primary m-b-0">VALIDER</button>
            </center>
          </div>
        </div>
      </div>
    </form>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
    </div>
  </form>
</div>
</div>
</div>
<div class="modal fade" id="suppressCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Annulation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/user-compagnie/annuler-depart/{{ $destination->id }}" method="post">
       {{ csrf_field() }}
       <div class="m-b-20">
        <div class="row">
          <div class="col-lg-6">
            <label class="col-sm-12 col-form-label">Date de l'Annulation</label>
            <div class="col-sm-12 col-lg-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                <input type="date" name="date_annulation" class="form-control" required>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <center>
              <button type="submit" class="btn btn-primary m-b-0">VALIDER</button>
            </center>
          </div>
        </div>
      </div>
    </form>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="deleteCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        <p>Etes-vous sûr de supprimer le voyage {{$destination->ville_destination}}, {{$destination->pays_destination}} - {{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <a href="/user-compagnie/delete-depart/{{$destination->id}}"
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
    <th>Destination</th>
    <th>Départ</th>
    <th>Jour et Heure Départ</th>
    <th>Nombre de places</th>
    <th>Prix unitaire</th>
    <th>Actions</th>
  </tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
@endsection 
@section('script') 
@endsection
