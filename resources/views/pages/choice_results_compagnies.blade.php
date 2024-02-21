@extends('layouts.base')
@section('title')
Packages
@endsection
@section('content')
<section class="breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <ol class="breadcrumb">
          <li><a href="/">Happy-Travel World</a></li>
        </ol>
      </div>
      <div class="col-6">
        <div class="text-right">
          <h2>Résultats</h2>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding our-pakages-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <h2 class="section-title text-center">Résultats</h2>
      </div>
      @if($result == 0)
      <div class="col-lg-12" style="text-align: center;">
        <h4 style="color: red;">Aucune correspondance</h4>
      </div>
      @else
      <div class="col-lg-12">
        <div class="total-earning-table table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Départ</th>
                <th scope="col">Destination</th>
                <th scope="col">Jour et Heure Départ</th>
                <th scope="col">Nombre de places disponibles</th>
                <th scope="col">Prix unitaire</th>
                <th scope="col">
                 Compagnie
               </th>
               <th>Choix</th>
             </tr>
           </thead>
           <tbody>
             @foreach($destinations as $destination)
             @if($destination->annulations->count() > 0)
             <?php $found = 0 ?>
             @foreach($destination->annulations as $annulation)
             @if($annulation->date_annulation == $date_demarrage)
             <?php $found = 1 ?>
             @endif
             @endforeach
             <?php if($found == 0){ ?>
               <tr>
                <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
                <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
                <td style="color: orange;font-weight: bold;">
                  <?= $destination->jour . " à " .$destination->heure; ?>
                </td>
                <td style="color: orange;font-weight: bold;">{{getPlacesDispoCompagnieNew($destination->id,$date_demarrage)}}</td>
                <td>{{$destination->prix_unitaire}} FCFA</td>
                <td>{{ getUserNameById($destination->user->id)}}</td>
                <td>
                  @if($destination->lignes->count() > 0)
                  <button type="button" class="btn btn-success" data-toggle="modal"
                  data-target="#lignesCard{{$destination->id}}">
                  <i class="feather icon-eye"></i> Lignes
                </button>
                @endif
                <a href="/choice-suggestion-compagnie/{{$destination->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
              </td>
            </tr>
            <div class="modal fade" id="lignesCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lignes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>
                      @foreach($destination->lignes as $ligne)
                      {{$ligne->ville_destination}}, {{$ligne->pays_destination}} :: {{$ligne->prix_unitaire}} FCFA
                      <hr>
                      @endforeach
                    </p>
                  </div>
                  <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          @else
          <tr>
            <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
            <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
            <td style="color: orange;font-weight: bold;">
              <?= $destination->jour . " à " .$destination->heure; ?>
            </td>
            <td style="color: orange;font-weight: bold;">{{getPlacesDispoCompagnieNew($destination->id,$date_demarrage)}}</td>
            <td>{{$destination->prix_unitaire}} FCFA</td>
            <td>{{ getUserNameById($destination->user->id)}}</td>
            <td>
              <!--@if($destination->lignes->count() > 0)
              <button type="button" class="btn btn-success" data-toggle="modal"
              data-target="#lignesCard{{$destination->id}}">
              <i class="feather icon-eye"></i> Lignes
            </button>
            @endif-->
            <a href="/choice-suggestion-compagnie/{{$destination->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
          </td>
        </tr>
        <!--<div class="modal fade" id="lignesCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lignes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>
                  @foreach($destination->lignes as $ligne)
                  {{$ligne->ville_destination}}, {{$ligne->pays_destination}} :: {{$ligne->prix_unitaire}} FCFA
                  <hr>
                  @endforeach
                </p>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>-->
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
</div>
@if($result == 0)
@if($result2 != 0)
<hr>
<div class="row">
 <div class="col-lg-12" style="">
  <h2 style="color: orange;">Résultats similaires</h2>
</div>        
<div class="col-lg-12">
  <div class="total-earning-table table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Départ</th>
          <th scope="col">Destination</th>
          <th scope="col">Jour et Heure Départ</th>
          <th scope="col">Nombre de places disponibles</th>
          <th scope="col">Prix unitaire</th>
          <th scope="col">
            Compagnie
          </th>
          <th>Choix</th>
        </tr>
      </thead>
      <tbody>
       @foreach($destinations as $destination)
       @if($destination->annulations->count() > 0)
       <?php $found = 0 ?>
       @foreach($destination->annulations as $annulation)
       @if($annulation->date_annulation == $date_demarrage)
       <?php $found = 1 ?>
       @endif
       @endforeach
       <?php if($found == 0){ ?>
         <tr>
          <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
          <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
          <td style="color: orange;font-weight: bold;">
            <?= $destination->jour . " à " .$destination->heure; ?>
          </td>
          <td style="color: orange;font-weight: bold;">{{getPlacesDispoCompagnieNew($destination->id,$date_demarrage)}}</td>
          <td>{{$destination->prix_unitaire}} FCFA</td>
          <td>{{ getUserNameById($destination->user->id)}}</td>
          <td>
            <!--@if($destination->lignes->count() > 0)
            <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#lignesCard{{$destination->id}}">
            <i class="feather icon-eye"></i> Lignes
          </button>
          @endif-->
          <a href="/choice-suggestion-compagnie/{{$destination->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
        </td>
      </tr>
      <!--<div class="modal fade" id="lignesCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Lignes</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
                @foreach($destination->lignes as $ligne)
                {{$ligne->ville_destination}}, {{$ligne->pays_destination}} :: {{$ligne->prix_unitaire}} FCFA
                <hr>
                @endforeach
              </p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>-->
    <?php } ?>
    @else
    <tr>
      <td>{{$destination->ville_demarrage}}, {{$destination->pays_demarrage}}</td>
      <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
      <td style="color: orange;font-weight: bold;">
        <?= $destination->jour . " à " .$destination->heure; ?>
      </td>
      <td style="color: orange;font-weight: bold;">{{getPlacesDispoCompagnieNew($destination->id,$date_demarrage)}}</td>
      <td>{{$destination->prix_unitaire}} FCFA</td>
      <td>{{ getUserNameById($destination->user->id)}}</td>
      <td>
        <!--@if($destination->lignes->count() > 0)
        <button type="button" class="btn btn-success" data-toggle="modal"
        data-target="#lignesCard{{$destination->id}}">
        <i class="feather icon-eye"></i> Lignes
      </button>
      @endif-->
      <a href="/choice-suggestion-compagnie/{{$destination->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
    </td>
  </tr>
  <!--<div class="modal fade" id="lignesCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Lignes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            @foreach($destination->lignes as $ligne)
            {{$ligne->ville_destination}}, {{$ligne->pays_destination}} :: {{$ligne->prix_unitaire}} FCFA
            <hr>
            @endforeach
          </p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>-->
  @endif
  @endforeach
</tbody>
</table>
</div>
</div>
</div>
@else
<hr>
<div class="row">
 <div class="col-lg-12" style="">
  <h2 style="color: orange;">Résultats similaires</h2>
</div>        
<div class="col-lg-12">
  <div class="total-earning-table table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Départ</th>
          <th scope="col">Destination</th>
          <th scope="col">Jour et Heure Départ</th>
          <th scope="col">Nombre de places disponibles</th>
          <th scope="col">Prix unitaire</th>
          <th scope="col">
            Compagnie
          </th>
          <th>Choix</th>
        </tr>
      </thead>
      <tbody>
        @foreach($lignes as $ligne)
       @if($ligne->destination->annulations->count() > 0)
       <?php $found = 0 ?>
       @foreach($ligne->destination->annulations as $annulation)
       @if($annulation->date_annulation == $date_demarrage)
       <?php $found = 1 ?>
       @endif
       @endforeach
       <?php if($found == 0){ ?>
         <tr>
          <td>{{$ligne->destination->ville_demarrage}}, {{$ligne->destination->pays_demarrage}}</td>
          <td>{{$ligne->ville_destination}}, {{$ligne->pays_destination}}</td>
          <td style="color: orange;font-weight: bold;">
            <?= $ligne->destination->jour . " à " .$ligne->destination->heure; ?>
          </td>
          <td style="color: orange;font-weight: bold;">{{getPlacesDispoCompagnieNew($ligne->destination->id,$date_demarrage)}}</td>
          <td>{{$ligne->prix_unitaire}} FCFA</td>
          <td>{{ getUserNameById($ligne->destination->user->id)}}</td>
          <td>
          <a href="/choice-suggestion-compagnie-ligne/{{$ligne->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
        </td>
      </tr>
    <?php } ?>
    @else
    <tr>
      <td>{{$ligne->destination->ville_demarrage}}, {{$ligne->destination->pays_demarrage}}</td>
      <td>{{$ligne->ville_destination}}, {{$ligne->pays_destination}}</td>
      <td style="color: orange;font-weight: bold;">
        <?= $ligne->destination->jour . " à " .$ligne->destination->heure; ?>
      </td>
      <td style="color: orange;font-weight: bold;">{{getPlacesDispoCompagnieNew($ligne->destination->id,$date_demarrage)}}</td>
      <td>{{$ligne->prix_unitaire}} FCFA</td>
      <td>{{ getUserNameById($ligne->destination->user->id)}}</td>
      <td>
      <a href="/choice-suggestion-compagnie-ligne/{{$ligne->id}}" class="btn btn-primary" style="background-color: orange;border-color: orange;">Choisir</a>
    </td>
  </tr>
  @endif
  @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>


@endif
@endif

</div>
</section>
@endsection
@section('scripts')
@endsection
