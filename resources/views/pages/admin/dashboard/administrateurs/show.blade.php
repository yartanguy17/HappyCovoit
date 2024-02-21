@extends("layouts.base_admin") @section('title') Tous les Administrateurs @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Tous les Administrateurs</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Tous les Administrateurs</a>
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
      <h5>Liste des Administrateurs</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="simpletable" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Email</th>
              <th>Rôle</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $admin)
            <tr>
              <td>{{$admin->email}}</td>
              <td>
                @if($admin->niveau == 1)
                Gestion des Voyageurs
                @elseif($admin->niveau == 2)
                Gestion des Chauffeurs
                @elseif($admin->niveau == 3)
                Gestion des Compagnies
                @endif
              </td>
              <td>
                <a class="btn btn-primary"
                href="/admin/edit-admin/{{$admin->id}}">
                <i class="feather icon-edit"></i>
              </a>
              <button type="button" class="btn btn-danger" data-toggle="modal"
              data-target="#deleteCard{{$admin->id}}">
              <i class="feather icon-trash"></i>
            </button>
          </td>
        </tr>
        <div class="modal fade" id="deleteCard{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Etes-vous sûr de supprimer l' Agent {{$admin->email}} ?</p>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a href="/admin/delete-admin/{{$admin->id}}"
                  class="btn btn-primary"> Oui</a>
                  <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
              <th>Email</th>
              <th>Rôle</th>
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
