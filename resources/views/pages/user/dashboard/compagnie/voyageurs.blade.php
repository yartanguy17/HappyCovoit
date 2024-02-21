@extends("layouts.base_compagnie") @section('title') Tous les News @endsection
@section('top_script') 
@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Tous les Voyageurs</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Tous les Voyageurs</a>
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
      <h5>Liste des Voyageurs</h5>
      <button type="button" class="btn btn-success" style="float: right;" data-toggle="modal"
      data-target="#groupMessageCard">
      <i class="feather icon-share"></i> Message groupé
    </button>
    <div class="modal fade" id="groupMessageCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Envoyer un message groupé</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/user-compagnie/send-message-voyageurs" method="post">
          <div class="modal-body">
            {{ csrf_field() }} 
            <div class="m-b-20">
              <div class="row">
                <div class="col-lg-12">
                  <label class="col-sm-12 col-form-label">Message</label>
                  <div class="col-sm-12 col-lg-10">
                    <div class="input-group">

                      <textarea name="message" placeholder="Tapez le message" class="form-control" required></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <center>
                    <button type="submit" class="btn btn-primary m-b-0">Envoyer</button>
                  </center>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>
<div class="card-block">
  <div class="dt-responsive table-responsive">
    <table id="simpletable" class="table table-striped table-hover table-bordered nowrap">
      <thead>
        <tr>
          <th>Nom Complet</th>
          <th>Numéro de téléphone</th>
          <th>Voyages effectués</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($voyageurs as $voyageur)
        <tr>
          <td>{{$voyageur->nom}} {{$voyageur->prenoms}}</td>
          <td>{{$voyageur->telephone}}</td>
          <td>{{ getAllVoyageurDepartCompagnieCount($voyageur->id,getUserAuth()->id) }}</td>
          <td>
            <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#sendCard{{$voyageur->id}}">
            <i class="feather icon-share"></i>
          </button>
        </td>
      </tr>
      <div class="modal fade" id="sendCard{{$voyageur->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Envoi de message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/user-compagnie/send-message-voyageurs/{{$voyageur->id}}" method="post">
              {{ csrf_field() }}
              <div class="modal-body">
               <div class="row">
                <div class="col-lg-12">
                  <label class="col-sm-12 col-form-label">Message</label>
                  <div class="col-sm-12 col-lg-10">
                    <div class="input-group">

                      <textarea name="message" placeholder="Tapez le message" class="form-control" required></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="submit"
              class="btn btn-primary"> Envoyer</a>
              <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
            </div>
          </form>

        </div>
      </div>
    </div>
    @endforeach
  </tbody>
  <tfoot>
   <tr>
    <th>Nom Complet</th>
    <th>Numéro de téléphone</th>
    <th>Voyages effectués</th>
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

</script>
@endsection
