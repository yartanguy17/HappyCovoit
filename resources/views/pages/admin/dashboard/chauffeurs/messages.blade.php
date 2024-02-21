@extends("layouts.base_admin") @section('title') Messages des Chauffeurs @endsection
@section('top_script') 

@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Messages des Chauffeurs</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Messages des Chauffeurs</a>
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
      <h5>Messages des Chauffeurs</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="simpletable" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Nom Complet</th>
              <th>Message</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
           @foreach($messages as $message)
           @if($message->user->type_user == 2)
           <tr>
            <td>{{ getUserNameById($message->user_id) }}</td>
            <td><p style="width: 300px;overflow: auto;@if($message->status == 0) font-weight: bold; @endif">{{$message->contenu}}</p></td>
            <td>{{$message->created_at}}</td>
            <td>@if($message->status == 0)
            <button type="button" class="btn btn-info" data-toggle="modal"
              data-target="#markCard{{$message->id}}">
              <i class="feather icon-check"></i>
            </button>@endif
            <div class="modal fade" id="markCard{{$message->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marquer comme lu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Etes-vous sûr de marquer ce message comme lu ?</p>
                  </div>
                  <div class="modal-footer bg-whitesmoke br">
                    <a href="/admin/mark-message/{{$message->id}}"
                      class="btn btn-primary"> Oui</a>
                      <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @endif
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Nom Complet</th>
            <th>Message</th>
            <th>Date</th>
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
