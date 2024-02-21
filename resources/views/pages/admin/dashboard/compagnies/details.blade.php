@extends("layouts.base_admin") @section('title') Détails @endsection @section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Compagnie {{ $compagnie->denomination }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Compagnie {{ $compagnie->denomination }}</a>
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
            <h5>Liste des Départs</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
             <div class="dt-responsive table-responsive">
        <table id="simple-table" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Destination</th>
              <th>Départ</th>
              <th>Compagnie</th>
              <th>Jour et Heure Départ</th>
              <th>Prix unitaire</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($destinations as $destination)
            <tr>
             <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
             <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
             <td>{{ getUserNameById($destination->user->id) }}</td>
             <td>
               <?= $destination->jour. " " .$destination->heure;
               ?>
             </td>
             <td>{{$destination->prix_unitaire}} FCFA</td>
             <td>
              <a class="btn btn-primary"
              href="/admin/compagnie/stats-departs/{{$destination->id}}">
              <i class="feather icon-eye"></i> Détails
            </a>
          </td>
        </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
              <th>Destination</th>
              <th>Départ</th>
              <th>Compagnie</th>
              <th>Jour et Heure Départ</th>
              <th>Prix unitaire</th>
              <th>Actions</th>
            </tr>
        </tfoot>
      </table>
    </div>
        </div>
    </div>
    <a class="btn btn-secondary"
    href="/admin/all-compagnies">
    <i class="feather icon-arrow-left"></i>
</a>
</div>
@endsection @section('script') @endsection