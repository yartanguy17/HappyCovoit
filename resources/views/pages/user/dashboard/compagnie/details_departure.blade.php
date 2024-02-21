@extends("layouts.base_compagnie") @section('title') Départ :: {{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }} @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Départ :: {{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }}</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Départ :: {{ $destination->pays_demarrage }}, {{ $destination->ville_demarrage }} - {{ $destination->pays_destination }}, {{ $destination->ville_destination }}</a>
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
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5>Liste des dates de départs</h5>
        </div>
        <div class="card-block">
          <div class="dt-responsive table-responsive">
            <table id="my-table" class="table table-striped table-hover table-bordered nowrap">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Nombre de réservations</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
               @foreach($elements as $reservation)
               <tr>
               <td>{{$reservation['date_depart']}}</td>
               <td>{{ getNbreReservations($destination->id, $reservation['date_depart']) }}</td>
               <td>
                <form action="/user-compagnie/all-reservations" method="post">
                  {{ csrf_field() }}
                  <input type="text" name="date_depart" value="{{$reservation['date_depart']}}" hidden>
                  <input type="text" name="destination_id" value="{{$destination->id}}" hidden>
                   <button class="btn btn-primary" type="submit">
              <i class="feather icon-eye"></i>
            </button>
                </form>
               
               </td>
             </tr>
               @endforeach
             </tbody>
             <tfoot>
               <tr>
                <th>Date</th>
                <th>Nombre de réservations</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
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
