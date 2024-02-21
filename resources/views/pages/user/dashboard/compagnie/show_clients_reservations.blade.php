@extends("layouts.base_compagnie") @section('title') Toutes les Réservations de {{ $client->nom }} @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Toutes les Réservations de {{ $client->nom }}</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Toutes les Réservations de {{ $client->nom }}</a>
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
      <h5>Liste des Réservations</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="my-table" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Demarrage</th>
              <th>Destination</th>
              <th>Date reservation</th>
              <th>Nombre de places</th>
              <th>Prix Total</th>
               <th hidden="true">Date et Heure Départ</th>
              <th hidden="true">Numéro de Siège</th>
              <th hidden="true">Numéro de Facture</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
           @foreach($reservations as $reservation)
           <tr>
            <td>{{ $reservation->destination->ville_demarrage }} - {{ $reservation->destination->pays_demarrage }}</td>
            @if($reservation->ligne_destination_id == 0)
              <td>{{$reservation->destination->ville_destination}} - {{$reservation->destination->pays_destination}}</td>
              @else
              <td>{{ getLigneById($reservation->ligne_destination_id)->ville_destination}} - 
                {{ getLigneById($reservation->ligne_destination_id)->pays_destination}}</td>
              @endif

            
            
            <td>
             <?php
             $dateReservation = $reservation->date_reservation;
             $explodeDats = explode("-", $dateReservation);
             echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0];
             ?>
           </td>
           <td>{{$reservation->nbre_places}}</td>
           <td>{{$reservation->prix_total}} FCFA</td>
           <td hidden="true">{{ formatDateSimple($reservation->date_depart) }} {{$reservation->destination->heure}}</td>
           <td hidden="true">
            @foreach(getSieges($reservation->id) as $siege)
                @if ($loop->last)
                  {{ $siege->numero }}
                @else
                  {{ $siege->numero }} |
                @endif
              
            @endforeach
          </td>
           <td hidden="true">{{$reservation->facture}}</td>
           <td>
            <a href="/user-compagnie/print-ticket-pdf/{{$reservation->id}}" class="btn btn-info"><i class="feather icon-file"></i></a>
            @if($reservation->status_siege==0)
            <button type="button" class="btn btn-primary" data-toggle="modal"
            data-target="#attributeCard{{$reservation->id}}">
            <i class="feather icon-edit"></i> Attribuer un numéro de siège
          </button>
          @endif
        </td>
        <div class="modal fade" id="attributeCard{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Attribution des Numéros de sièges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="/user-compagnie/attribute-siege-client/{{$reservation->id}}" method="post">
                 {{ csrf_field() }}
                 <div class="m-b-20">
                  <div class="row">
                    <?php
                    for ($i=1; $i <= $reservation->nbre_places ; $i++) { 
                     ?>
                     <div class="col-lg-12">
                      <label class="col-sm-12 col-form-label">Numéro de Siège <?= $i ?></label>
                      <div class="col-sm-12 col-lg-12">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icofont icofont-shield"></i></span>
                          <input type="text" name="numero_siege<?= $i ?>" placeholder="Tapez le Numéro de Siège <?= $i ?>" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>

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
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  </tr>
  @endforeach
</tbody>
<tfoot>
 <tr>
  <th>Demarrage</th>
  <th>Destination</th>
  <th>Date reservation</th>
  <th>Nombre de places</th>
  <th>Prix Total</th>
   <th hidden="true">Date et Heure Départ</th>
              <th hidden="true">Numéro de Siège</th>
              <th hidden="true">Numéro de Facture</th>
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
        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
      }
    },
    {
      extend: 'excelHtml5',
      text :'Excel',
      exportOptions: {
        columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
      }
    },
    {
      extend: 'pdfHtml5',
      text :'PDF',
      exportOptions: {
        columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
      }
    }
    ]

  });
</script>
@endsection
