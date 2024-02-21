@extends("layouts.base_admin") @section('title') Détails @endsection @section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Recette du depart {{ $destination->ville_destination }}, {{ $destination->pays_destination }} - {{ $destination->ville_demarrage }}, {{ $destination->pays_demarrage }} Le {{ $dateDepart }}</h4>
        </div>
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
<?php
$totalCompagnie = 0;
$totalHtw = 0;
?>
<div class="page-body">
  <div class="card">
    <div class="card-header">
      <h5>Recettes journalières</h5>
      <div class="card-header-right">
        <i class="icofont icofont-spinner-alt-5"></i>
      </div>
    </div>
    <div class="card-block">
     <div class="dt-responsive table-responsive">
      <table id="my-table" class="table table-striped table-hover table-bordered nowrap">
        <thead>
          <tr>
            <th>Date de réservation</th>
            <th>Nombre de places reservées</th>
            <th>Montant Compagnie</th>
            <th>Montant HTW</th>
            <th>Type de reservation</th>
          </tr>
        </thead>
        <tbody>
          @foreach($elements as $recette)
          <!--@if($recette['type_reservation'] == 1)-->
          <?php
         
          if($recette['ligne_id'] == 0){
            $totalHtw += $destination->prix_unitaire * $recette['nbre_places_total'] * 0.065;
             $totalCompagnie += $destination->prix_unitaire * $recette['nbre_places_total'];
          }else{
            $totalHtw += getLigneById($recette['ligne_id'])->prix_unitaire * $recette['nbre_places_total'] * 0.065;
             $totalCompagnie += getLigneById($recette['ligne_id'])->prix_unitaire * $recette['nbre_places_total'];
          }
          
          ?>
          <tr>
            <td>{{ formatDateSimple($recette['date']) }}</td>
            <td>{{ $recette['nbre_places_total'] }}</td>
            @if($recette['ligne_id'] == 0)
            <td>{{ formatToPrice($destination->prix_unitaire * $recette['nbre_places_total']) }} FCFA</td>
            <td>{{ formatToPrice($destination->prix_unitaire * $recette['nbre_places_total'] * 0.065) }} FCFA</td>
            @else
            <td>{{ formatToPrice(getLigneById($recette['ligne_id'])->prix_unitaire * $recette['nbre_places_total']) }} FCFA</td>
            <td>{{ formatToPrice(getLigneById($recette['ligne_id'])->prix_unitaire * $recette['nbre_places_total'] * 0.065) }} FCFA</td>
            @endif



            <td><?= "En Ligne" ?></td>
          </td>
        </tr>
       <!--@else
        <tr>
            <td>{{ formatDateSimple($recette['date']) }}</td>
            <td>{{ $recette['nbre_places_total'] }}</td>
           <td>{{ $destination->prix_unitaire * $recette['nbre_places_total'] }} FCFA</td>
           <td>{{ $destination->prix_unitaire * $recette['nbre_places_total'] * 0.065 }} FCFA</td>
            <td><?= "En présentiel" ?></td>
         </td>
       </tr>
       @endif-->
       @endforeach
     </tbody>
     <tfoot>
      <tr>
        <th>Jour</th>
        <th>Nombre de places reservées</th>
        <th>Montant Compagnie</th>
        <th>Montant HTW</th>
        <th>Type de reservation</th>
      </tr>
    </tfoot>
  </table>
  <span style="font-size: 20px;">
    Prix total Compagnie : <b style="color: red"><?= formatToPrice($totalCompagnie) ?> FCFA</b><br>
    Prix total HTW: <b style="color: red"><?= formatToPrice($totalHtw) ?> FCFA</b>
  </span>
</div>
</div>
</div>
<a class="btn btn-secondary"
href="/admin/all-compagnies">
<i class="feather icon-arrow-left"></i>
</a>
</div>
@endsection @section('script')
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
        columns: [ 0, 1]
      }
    },
    {
      extend: 'excelHtml5',
      text :'Excel',
      exportOptions: {
        columns: [ 0, 1]
      }
    },
    {
      extend: 'pdfHtml5',
      text :'PDF',
      exportOptions: {
        columns: [ 0, 1 ]
      }
    }
    ]

  });
</script>
@endsection