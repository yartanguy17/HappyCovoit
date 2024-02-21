@extends("layouts.base_compagnie") @section('title') {{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }} du {{ $dateDepart }} @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>{{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }} du {{ $dateDepart }}</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">{{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }} du {{ $dateDepart }}</a>
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
              <th>Départ</th>
              <th>Destination</th>
              <th>Nom du Client</th>
              <th>Date reservation</th>
              <th>Nombre de places</th>
              <th>Somme payée</th>
              <th>Type de reservation</th>
              <th hidden="true">Date et Heure Départ</th>
              <th hidden="true">Numéro de Siège</th>
              <th hidden="true">Numéro de Facture</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
           @foreach($elements as $reservation)
           @if($reservation['type_reservation'] == 1)
           <?php
           if($reservation['type'] == 1){
             if (checkPayment($reservation['identifier']) == 0) {
               ?>
               <tr>
                @if($reservation['ligne_destination_id'] == 0)
    <td>{{ $destination->ville_demarrage }} - {{ $destination->pays_demarrage }}</td>
    <td>{{ $destination->ville_destination }} - {{ $destination->pays_destination }}</td>
    @else
    <td>{{ $destination->ville_demarrage }} - {{ $destination->pays_demarrage }}</td>
    <td>{{ getLigneById($reservation['ligne_destination_id'])->ville_destination }} - {{ getLigneById($reservation['ligne_destination_id'])->pays_destination }} (Escale)</td>
    @endif
                <td>{{ getUserNameById($reservation['user_id'])}}</td>
                <td>
                 <?php
                 $dateReservation = $reservation['date_reservation'];
                 $explodeDats = explode("-", $dateReservation);
                 echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0];
                 ?>
               </td>
               <td>{{$reservation['nbre_places']}}</td>
               @if($reservation['ligne_destination_id'] == 0)
 <td>{{$reservation['nbre_places']*$destination->prix_unitaire}} FCFA</td>
 @else
 <td>{{$reservation['nbre_places']*getLigneById($reservation['ligne_destination_id'])->prix_unitaire}} FCFA</td>
 @endif
               <td><?= "En ligne" ?></td>
               <td hidden="true">{{ formatDateSimple($reservation['date_depart']) }} {{$destination->heure}}</td>
               <td hidden="true">
                @foreach(getSieges($reservation['id']) as $siege)
                @if ($loop->last)
                {{ $siege->numero }}
                @else
                {{ $siege->numero }} |
                @endif

                @endforeach
              </td>
              <td hidden="true">{{$reservation['facture']}}</td>
              <td>
                <a href="/user-compagnie/print-ticket-pdf2/{{$reservation['id']}}" class="btn btn-info"><i class="feather icon-file"></i></a>
                @if($reservation['status_siege']==0)
                <button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#attributeCard{{$reservation['id']}}">
                <i class="feather icon-edit"></i> Attribuer un numéro de siège
              </button>
              @endif
            </td>
            <div class="modal fade" id="attributeCard{{$reservation['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                  <form action="/user-compagnie/attribute-siege/{{$reservation['id']}}" method="post">
                   {{ csrf_field() }}
                   <div class="m-b-20">
                    <div class="row">
                      <?php
                      for ($i=1; $i <= $reservation['nbre_places'] ; $i++) { 
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
    <?php
  }
}else{
  if ($reservation['status'] == 1) {
   ?>
   <tr>
    @if($reservation['ligne_destination_id'] == 0)
    <td>{{ $destination->ville_demarrage }} - {{ $destination->pays_demarrage }}</td>
    <td>{{ $destination->ville_destination }} - {{ $destination->pays_destination }}</td>
    @else
    <td>{{ $destination->ville_demarrage }} - {{ $destination->pays_demarrage }}</td>
    <td>{{ getLigneById($reservation['ligne_destination_id'])->ville_destination }} - {{ getLigneById($reservation['ligne_destination_id'])->pays_destination }} (Escale)</td>
    @endif
    <td>{{ getUserNameById($reservation['user_id'])}}</td>
    <td>
     <?php
     $dateReservation = $reservation['date_reservation'];
     $explodeDats = explode("-", $dateReservation);
     echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0];
     ?>
   </td>
   <td>{{$reservation['nbre_places']}}</td>
   @if($reservation['ligne_destination_id'] == 0)
 <td>{{$reservation['nbre_places']*$destination->prix_unitaire}} FCFA</td>
 @else
 <td>{{$reservation['nbre_places']*getLigneById($reservation['ligne_destination_id'])->prix_unitaire}} FCFA</td>
 @endif
   <td><?= "En ligne" ?></td>
   <td hidden="true">{{ formatDateSimple($reservation['date_depart']) }} {{$destination->heure}}</td>
   <td hidden="true">
    @foreach(getSieges($reservation['id']) as $siege)
    @if ($loop->last)
    {{ $siege->numero }}
    @else
    {{ $siege->numero }} |
    @endif

    @endforeach
  </td>
  <td hidden="true">{{$reservation['facture']}}</td>
  <td>
    <a href="/user-compagnie/print-ticket-pdf2/{{$reservation['id']}}" class="btn btn-info"><i class="feather icon-file"></i></a>
    @if($reservation['status_siege']==0)
    <button type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#attributeCard{{$reservation['id']}}">
    <i class="feather icon-edit"></i> Attribuer un numéro de siège
  </button>
  @endif
</td>
<div class="modal fade" id="attributeCard{{$reservation['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
      <form action="/user-compagnie/attribute-siege/{{$reservation['id']}}" method="post">
       {{ csrf_field() }}
       <div class="m-b-20">
        <div class="row">
          <?php
          for ($i=1; $i <= $reservation['nbre_places'] ; $i++) { 
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
<?php
}
}

?>
@else
<tr>
  @if($reservation['ligne_destination_id'] == 0)
    <td>{{ $destination->ville_demarrage }} - {{ $destination->pays_demarrage }}</td>
    <td>{{ $destination->ville_destination }} - {{ $destination->pays_destination }}</td>
    @else
    <td>{{ $destination->ville_demarrage }} - {{ $destination->pays_demarrage }}</td>
    <td>{{ getLigneById($reservation['ligne_destination_id'])->ville_destination }} - {{ getLigneById($reservation['ligne_destination_id'])->pays_destination }} (Escale)</td>
    @endif

  <td>{{ getClientNameById($reservation['user_id'])}}</td>
  <td>
   <?php
   $dateReservation = $reservation['date_reservation'];
   $explodeDats = explode("-", $dateReservation);
   echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0];
   ?>
 </td>
 <td>{{$reservation['nbre_places']}}</td>
 @if($reservation['ligne_destination_id'] == 0)
 <td>{{$reservation['nbre_places']*$destination->prix_unitaire}} FCFA</td>
 @else
 <td>{{$reservation['nbre_places']*getLigneById($reservation['ligne_destination_id'])->prix_unitaire}} FCFA</td>
 @endif
 <td><?= "En présentiel" ?></td>
 <td hidden="true">{{ formatDateSimple($reservation['date_depart']) }} {{$destination->heure}}</td>
 <td hidden="true">
  @foreach(getSieges($reservation['id']) as $siege)
  @if ($loop->last)
  {{ $siege->numero }}
  @else
  {{ $siege->numero }} |
  @endif

  @endforeach
</td>
<td hidden="true">{{$reservation['facture']}}</td>
<td>
  <a href="/user-compagnie/print-ticket-pdf/{{$reservation['id']}}" class="btn btn-info"><i class="feather icon-file"></i></a>
  @if($reservation['status_siege']==0)
  <button type="button" class="btn btn-primary" data-toggle="modal"
  data-target="#attributeCard{{$reservation['id']}}">
  <i class="feather icon-edit"></i> Attribuer un numéro de siège
</button>
@endif
</td>
<div class="modal fade" id="attributeCard{{$reservation['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
      <form action="/user-compagnie/attribute-siege-client/{{$reservation['id']}}" method="post">
       {{ csrf_field() }}
       <div class="m-b-20">
        <div class="row">
          <?php
          for ($i=1; $i <= $reservation['nbre_places'] ; $i++) { 
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
@endif
@endforeach
</tbody>
<tfoot>
  <tr>
    <th>Départ</th>
    <th>Destination</th>
    <th>Nom du Client</th>
    <th>Date reservation</th>
    <th>Nombre de places</th>
    <th>Somme payée</th>
    <th>Type de reservation</th>
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
