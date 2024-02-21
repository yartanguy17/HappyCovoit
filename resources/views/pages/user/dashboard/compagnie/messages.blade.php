@extends("layouts.base_compagnie") @section('title') Mes messages @endsection @section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Mes messages</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Mes messages</a>
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
      <h5>Mes messages</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="simpletable" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Message</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
           @foreach($messages as $message)
           @if($message->titre == "Nouveau message Admin")
           <tr>
            <td>{{$message->titre}}</td>
            <td>{{$message->contenu}}</td>
            <td>{{$message->created_at}}</td>
          </tr>
          @endif
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Titre</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
</div>
@endsection 
