@extends("layouts.base_compagnie") @section('title') Tous les News @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Tous les News</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Tous les News</a>
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
      <h5>Liste des News</h5>
    </div>
    <div class="card-block">
      <div class="dt-responsive table-responsive">
        <table id="simple-table" class="table table-striped table-hover table-bordered nowrap">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Date de Publication</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($news as $new)
            <tr>
             <td>{{$new->titre}}</td>
             <td>
               <?php
               $dateDemarrage = $new->created_at;
               $explodeElements = explode(" ", $dateDemarrage);
               $explodeDats = explode("-", $explodeElements[0]);
               echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0] . " " .$explodeElements[1];
               ?>
             </td>
             <td>
              <a class="btn btn-primary"
              href="/user-compagnie/edit-new/{{$new->id}}">
              <i class="feather icon-edit"></i>
            </a>
              <!--<button type="button" class="btn btn-danger" data-toggle="modal"
              data-target="#deleteCard{{$new->id}}">
              <i class="feather icon-trash"></i>
            </button>-->
          </td>
        </tr>
        <!--<div class="modal fade" id="deleteCard{{$new->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <p>Etes-vous sûr de supprimer l' Agent {{$new->pseudo}} ?</p>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a href="/delete-new/{{$new->id}}"
                  class="btn btn-primary"> Oui</a>
                  <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>-->
          @endforeach
        </tbody>
        <tfoot>
          <tr>
              <th>Titre</th>
              <th>Date de Publication</th>
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
