@extends("layouts.base_compagnie") @section('title') Tous les Clients @endsection
@section('top_script') 
<style type="text/css">
        .loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid blue;
  border-bottom: 16px solid blue;
  border-radius: 50%;
  width: 12px;
  height: 12px;
}
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Tous les Clients</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Tous les Clients</a>
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
      <h5>Liste des Clients</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="my-table" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Nom Complet</th>
              <th>Téléphone</th>
              <th>Sexe</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clients as $client)
            <tr>
             <td>{{$client->nom}} {{$client->prenoms}}</td>
             <td>{{$client->telephone}}</td>
             <td>{{$client->sexe}}</td>
             <td>
              <a class="btn btn-primary"
              href="/user-compagnie/edit-client/{{$client->id}}">
              <i class="feather icon-edit"></i>
            </a>
            <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#compagnieCard{{$client->id}}">
            <i class="feather icon-plus"></i> Ajouter une Réservation
          </button>
          <a class="btn btn-info"
          href="/user-compagnie/show-client-reservations/{{$client->id}}">
          <i class="feather icon-eye"></i>Réservations
        </a>
      </td>
    </tr>
    <div class="modal fade" id="compagnieCard{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter une Réservation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="/user-compagnie/add-client-reservation/{{ $client->id }}" method="post">
           {{ csrf_field() }}
           <div class="m-b-20">
            <div class="row">
              <div class="col-lg-12">
                <label class="col-sm-12 col-form-label">Nombre de places</label>
                <div class="col-sm-12 col-lg-12">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                    <input type="number" name="nbre_places" onkeyup="checkIfCanGo()" id="nbre_places{{ $client->id }}" placeholder="Nombre de places" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <label class="col-sm-12 col-form-label">Date départ</label>
                <div class="col-sm-12 col-lg-12">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icofont icofont-clock"></i></span>
                    <input type="date" name="date_depart" onchange="checkIfCanGo()" id="date_depart{{ $client->id }}" class="form-control" required >
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <label class="col-sm-12 col-form-label">Destination</label>
                <div class="col-sm-12 col-lg-12">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                    <select class="form-control" onchange="checkIfCanGo()" name="destination_id" id="destination_id{{ $client->id }}" required>
                      @foreach($destinations as $destination)
                      <option value="{{ $destination->id }}" style="font-weight: bold">{{ $destination->ville_destination }}, {{ $destination->pays_destination }} - {{ $destination->ville_demarrage }}, {{ $destination->pays_demarrage }} :: {{ $destination->jour }} {{ $destination->heure }}</option>
                      @if($destination->lignes->count() > 0)
                      <optgroup label="Lignes">
                        @foreach($destination->lignes as $ligne)
                      <option value="L-{{ $ligne->id }}">{{ $ligne->ville_destination }}, {{ $ligne->pays_destination }} - {{ $ligne->destination->ville_demarrage }}, {{ $ligne->destination->pays_demarrage }} :: {{ $ligne->destination->jour }} {{ $ligne->destination->heure }}
                      </option>
                      @endforeach
                      </optgroup>
                      @endif
                      <option disabled>---------------------------------------------------------------------</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" >
              <div class="col-lg-12" id="loading{{ $client->id }}" hidden="true">
                <div class="loader" style="margin-top: -10%;margin-left: 37%;"></div>
              </div>
              <br><br>
              <div class="col-lg-12" id="layoutShow{{ $client->id }}" hidden="true">
               <center> 
                Nombre de places disponibles : <b style="color: orange" id="textShow{{ $client->id }}"></b>
              </center>
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
<script>
  function checkIfCanGo() {
    $('#layoutShow{{$client->id}}').prop('hidden',true);
    nbrePlaces = $("#nbre_places{{$client->id}}").val()
    dateDepart = $("#date_depart{{$client->id}}").val()
    destination = $("#destination_id{{$client->id}}").val()
    //alert(destination);
    //alert(nbrePlaces + " - " + dateDepart + " - " + destination)
    if (nbrePlaces.length > 0 && dateDepart.length > 0 && destination.length > 0) {
      $('#loading{{$client->id}}').prop('hidden',false);
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        url: '/user-compagnie/check-destination-places',
        type: 'json',
        data: {
        'nbre_places': nbrePlaces,
        'date_depart': dateDepart,
        'destination': destination
      },
        enctype: 'multipart/form-data',
        statusCode: {
          422: function(data) {
            var errors = data.responseJSON.errors;
            console.log(errors);
          }
        },
      }).done(function(data) {
        $('#loading{{$client->id}}').prop('hidden',true);
        $('#layoutShow{{$client->id}}').prop('hidden',false);
        $('#textShow{{$client->id}}').text(data);
      }).fail(function(data) {
        console.log(data);
      })

      
    }
    return false;
}
</script>
@endforeach
</tbody>
<tfoot>
  <tr>
    <th>Nom Complet</th>
    <th>Téléphone</th>
    <th>Sexe</th>
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
<script type="text/javascript">
  //$('#basic-btn').dataTable({ "bSort" : false,"bDestroy": true } );
  $('#my-table').dataTable({
    "destroy": true,
    "bSort" : false,
    "bDestroy": true,
    dom: 'Bfrtip',
    buttons: [
    {
      extend: 'copyHtml5',
      text :'Copier',
      exportOptions: {
        columns: [ 0, 1, 2]
      }
    },
    {
      extend: 'excelHtml5',
      text :'Excel',
      exportOptions: {
        columns: [ 0, 1, 2 ]
      }
    },
    {
      extend: 'pdfHtml5',
      text :'PDF',
      exportOptions: {
        columns: [ 0, 1, 2 ]
      }
    }
    ]

  });
</script>
@endsection
