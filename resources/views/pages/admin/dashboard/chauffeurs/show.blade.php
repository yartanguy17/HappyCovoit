@extends("layouts.base_admin") @section('title') Tous les Chauffeurs @endsection
@section('top_script') 

@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Tous les Chauffeurs</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Tous les Chauffeurs</a>
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
      <h5>Liste des Chauffeurs</h5>
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
        <form action="/admin/send-message-chauffeurs" method="post">
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
          <th>Pseudo</th>
          <th>Signalisation</th>
          <th>Départs publiés</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($chauffeurs as $chauffeur)
        @if($chauffeur->user->status==1)
        <tr>
          <td>{{$chauffeur->nom}} {{$chauffeur->prenoms}}</td>
          <td>{{$chauffeur->user->telephone}}</td>
          <td>{{$chauffeur->user->pseudo}}</td>
          <td>{{ getAllChauffeurSignalisation($chauffeur->user->id) }} <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#viewCard{{$chauffeur->id}}">
            <i class="feather icon-eye"></i>
          </button></td>
          <td>{{ getAllChauffeurDepartCount($chauffeur->user->id) }}</td>
          <td>
            <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#sendCard{{$chauffeur->id}}">
            <i class="feather icon-share"></i>
          </button>
          @if($chauffeur->status==0)
          <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#verifyCard{{$chauffeur->id}}">
            <i class="feather icon-check"></i>
          </button>
          @endif
          <button type="button" class="btn btn-danger" data-toggle="modal"
          data-target="#deleteCard{{$chauffeur->id}}">
          <i class="feather icon-trash"></i>
        </button>
      </td>
    </tr>
    <div class="modal fade" id="deleteCard{{$chauffeur->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
            <p>Etes-vous sûr de supprimer le chauffeur {{$chauffeur->nom}} {{$chauffeur->prenoms}} ?</p>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <a href="/admin/delete-user/{{$chauffeur->user->id}}"
              class="btn btn-primary"> Oui</a>
              <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="viewCard{{$chauffeur->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Liste des Signalisations</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @foreach(getAllChauffeurSignalisationList($chauffeur->user->id) as $signal)
            Date : <b>{{ $signal->created_at }}</b><br>
            Motif : <b>{{ $signal->motif }}</b>
            <hr>
            @endforeach
          </div>
          <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="sendCard{{$chauffeur->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Envoi de message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/admin/send-message-chauffeurs/{{$chauffeur->user->id}}" method="post">
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
    <div class="modal fade" id="verifyCard{{$chauffeur->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Vérification</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/admin/verify-chauffeur/{{$chauffeur->id}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-body">
               <div class="row">
                <div class="col-lg-12">
                  <label class="col-sm-12 col-form-label">Téléverser une carte d'identité</label>
                  <div class="col-sm-12 col-lg-10">
                    <div class="input-group">
                     <input type="file" name="cni" required accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="submit"
              class="btn btn-primary"> Valider</a>
              <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endif
    @endforeach
  </tbody>
  <tfoot>
   <tr>
    <th>Nom Complet</th>
    <th>Numéro de téléphone</th>
    <th>Pseudo</th>
    <th>Signalisation</th>
    <th>Départs publiés</th>
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
