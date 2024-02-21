@extends("layouts.base_admin") @section('title') Toutes les Souscriptions HT-Assurance @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Toutes les Souscriptions HT-Assurance</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Toutes les Souscriptions HT-Assurance</a>
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
      <h5>Liste des Souscriptions HT-Assurance</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="my-table" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Référence</th>
              <th>Date Souscription</th>
              <th>Date Expiration</th>
              <th>Client</th>
            </tr>
          </thead>
          <tbody>
           @foreach($souscriptions as $souscription)
            <?php
            if($souscription->paiements->count()>0){
               if($souscription->paiements[0]->type == 1){
           if (checkPayment($souscription->paiements[0]->identifier) == 0) {
             ?>
              <tr>
            <td>{{$souscription->reference}}</td>
            <td>{{$souscription->date_souscription}}</td>
             <td>{{$souscription->expiration}}</td>
             <td>{{ getUserNameById($souscription->user_id)}}</td>
           </tr>
              <?php
           }
        }else{
          if ($souscription->paiements[0]->status == 1) {
           ?>
            <tr>
            <td>{{$souscription->reference}}</td>
            <td>{{$souscription->date_souscription}}</td>
             <td>{{$souscription->expiration}}</td>
             <td>{{ getUserNameById($souscription->user_id)}}</td>
           </tr>
            <?php
         }elseif (checkPaymentFedapay($souscription->paiements[0]->identifier) == 0) {
            ?>
             <tr>
            <td>{{$souscription->reference}}</td>
            <td>{{$souscription->date_souscription}}</td>
             <td>{{$souscription->expiration}}</td>
             <td>{{ getUserNameById($souscription->user_id)}}</td>
           </tr>
            <?php
         }
      }
            }
         

      ?>
           @endforeach
         </tbody>
         <tfoot>
           <tr>
            <th>Référence</th>
            <th>Date Souscription</th>
            <th>Date Expiration</th>
            <th>Client</th>
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
