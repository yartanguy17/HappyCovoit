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
              href="/user-compagnie/show-departs/{{$destination->id}}">
              <i class="feather icon-eye"></i>
            </a>
        </td>
      </tr>
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
