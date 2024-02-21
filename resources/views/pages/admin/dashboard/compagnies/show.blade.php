@extends("layouts.base_admin") @section('title') Toutes les Compagnies @endsection
@section('top_script') 

@endsection

@section('content')
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <div class="d-inline">
          <h4>Toutes les Compagnies</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
          <li class="breadcrumb-item">
            <a href="/dashboard"> <i class="feather icon-home"></i> </a>
          </li>
          <li class="breadcrumb-item"><a href="#!">Toutes les Compagnies</a>
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
      <h5>Liste des Compagnies</h5>
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
        <form action="/admin/send-message-compagnies" method="post">
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
              <th>Dénomination</th>
              <th>Téléphone</th>
              <th>Pseudo</th>
              <th>Nombre d'abonnés</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($compagnies as $compagnie)
            @if($compagnie->user->status==1)
            <tr>
              <td><img src="{{$compagnie->user->avatar}}" alt="{{$compagnie->user->avatar}}"
                                                        class="rounded-circle" width="40" height="40" /> {{$compagnie->denomination}}</td>
              <td>{{$compagnie->user->telephone}}</td>
              <td>{{ $compagnie->user->pseudo }}</td>
              <td>{{ getNbreAbonnes($compagnie->id) }}</td>
              <td>
                <a class="btn btn-primary"
                href="/admin/edit-compagnie/{{$compagnie->id}}">
                <i class="feather icon-edit"></i>
              </a>
              <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#sendCard{{$compagnie->id}}">
            <i class="feather icon-share"></i>
          </button>
              <button type="button" class="btn btn-danger" data-toggle="modal"
              data-target="#deleteCard{{$compagnie->id}}">
              <i class="feather icon-trash"></i>
            </button>
            <a class="btn btn-success"
            data-toggle="modal"
            data-target="#passwordCard{{$compagnie->id}}">
            <i class="feather icon-lock" style="color: white;"></i>
          </a>
          <a class="btn btn-info"
          href="/admin/details-compagnie/{{$compagnie->id}}">
          <i class="feather icon-layers"></i>Recettes
        </a>
      </td>
    </tr>
    <div class="modal fade" id="sendCard{{$compagnie->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Envoi de message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/admin/send-message-compagnies/{{$compagnie->user->id}}" method="post">
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
    <div class="modal fade" id="passwordCard{{$compagnie->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier le mot de passe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="/admin/change-password-compagnie/{{ $compagnie->id }}" method="post">
           {{ csrf_field() }}
           <div class="m-b-20">
            <div class="row">
              <div class="col-lg-6">
                <label class="col-sm-12 col-form-label">Nouveau Mot de passe</label>
                <div class="col-sm-12 col-lg-12">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-shield"></i></span>
                    <input type="password" name="n_password" placeholder="Nouveau Mot de passe" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <label class="col-sm-12 col-form-label">Confirmation</label>
                <div class="col-sm-12 col-lg-12">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-shield"></i></span>
                    <input type="password" name="cn_password" placeholder="Confirmation" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <center>
                  <button type="submit" class="btn btn-primary m-b-0">MODIFIER</button>
                </center>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteCard{{$compagnie->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        <p>Etes-vous sûr de supprimer le compagnie{{$compagnie->nom}} ?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <a href="/admin/delete-compagnie/{{$compagnie->id}}"
          class="btn btn-primary"> Oui</a>
          <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
  @endif
  @endforeach
</tbody>
<tfoot>
 <tr>
  <th>Dénomination</th>
  <th>Téléphone</th>
  <th>Pseudo</th>
  <th>Nombre d'abonnés</th>
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
