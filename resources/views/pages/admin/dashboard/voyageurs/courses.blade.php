@extends("layouts.base") @section('title') Toutes les Courses @endsection
@section('top_script') 

@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Toutes les Courses</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Toutes les Courses</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@if (Session::has('flash_message_success'))
<script type="text/javascript" src="{{ asset('Backoffice/assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">;
swal("{{ session('flash_message_success') }}", "Merci", "success");
</script>
@endif
@if (Session::has('flash_message_error'))
<script type="text/javascript" src="{{ asset('Backoffice/assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">;
swal("{{ session('flash_message_error') }}", "Merci", "error");
</script>
@endif
<div class="page-body">
  <div class="card">
    <div class="card-header">
      <h5>Liste des Courses du Contact <b style="color: orange;">{{ $particulier->telephone }}</b></h5>
</div>
<div class="card-block">
  <div class="dt-responsive table-responsive">
    <table id="simpletable" class="table table-striped table-hover table-bordered nowrap">
      <thead>
        <tr>
          <th>Numéro de Plaque</th>
          <th>Destination</th>
          <th>Prix</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach($courses as $course)
        <tr>
          <td>{{$course->num_plaque}}</td>
          <td>{{$course->destination}}</td>
          <td>{{$course->prix}}</td>
          <td>{{$course->created_at}}</td>
        </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
          <th>Numéro de Plaque</th>
          <th>Destination</th>
          <th>Prix</th>
           <th>Date</th>
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
 
</script>
@endsection
