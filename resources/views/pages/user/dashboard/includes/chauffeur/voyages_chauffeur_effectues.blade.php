<div role="tabpanel" class="tab-pane" id="voyages-chauffeur-effectues">
  <div class="rides-details">
    <div class="row">
      <div class="col-lg-6">
        <h4>Mes voyages</h4>
      </div>
    </div>

    <div class="row small-section">
      <div class="col-lg-12">
        <div class="total-earning-table table-responsive">
         <table class="table">
          <thead>
            <tr>
              <th scope="col">Destination</th>
              <th scope="col">Date et Heure Départ</th>
              <th scope="col">Nombre de places</th>
              <th scope="col">Prix</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
           @foreach(getAllParticulierReservation() as $reservation)
           <tr style="<?= ($reservation->is_signal==1)?'background-color: #F08080;color:white;':''?>">
            <?php
            if ($reservation->type_destination == 1) {
              ?>
              <td>{{$reservation->destination->ville_destination}}, {{$reservation->destination->pays_destination}}</td>
              <td>
               <?php
               $dateDemarrage = $reservation->destination->date_demarrage;
               $explodeDats = explode("-", $dateDemarrage);
               echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0] . " " .$reservation->destination->heure;
               ?>
             </td>
             <?php
           }else{
            ?>
            <td>{{$reservation->destinationCompagnie->ville_destination}}, {{$reservation->destinationCompagnie->pays_destination}}</td>
            <td>
             <?php
             $jour = $reservation->destinationCompagnie->jour;
                               // $explodeDats = explode("-", $dateDemarrage);
             echo $jour . " " .$reservation->destinationCompagnie->heure;
             ?>
           </td>
           <?php
         }
         ?>

         <td>{{$reservation->nbre_places - $reservation->nbre_places_annules}}</td>
         <td>{{$reservation->prix_total_commission}} FCFA</td>
         <td>
          @if($reservation->type_destination == 2)
          <?php
          if ($reservation->paiement->count() > 0) {
            if($reservation->paiement[0]['type'] == 1){
             if (checkPayment($reservation->paiement[0]['identifier']) == 0) {
               ?>
               <a href="/user/print-ticket-pdf/{{$reservation->id}}" class="btn btn-info"><i class="fas fa-file-invoice"></i>
               </a>
               <?php
             }else{
              $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=' . $reservation->paiement[0]['amount']  . '&description=Reservation de Ticket&identifier='. $reservation->paiement[0]['identifier'];
              ?>
              <b style="color: black">Non Payé</b>&nbsp;&nbsp;
             <!--<a href="<?= $urlPaiement ?>" target="_blank" class="btn btn-warning" style="color:white;">Payer maintenant
             </a>-->
             <?php
           }
         }else{
          if ($reservation->paiement[0]['status'] == 1) {
           ?>
           <a href="/user/print-ticket-pdf/{{$reservation->id}}" class="btn btn-info"><i class="fas fa-file-invoice"></i>
           </a>
           <?php
         }else{
          ?>
          <b style="color: black">Non Payé</b>
          &nbsp;&nbsp;
          <?php
        }
      }
    }
    
    ?>
    @else
    <?php

    if ($reservation->status_reservation == 1) {
      if ($reservation->type_destination == 1) {
        ?>
        ?>
        <a class="btn btn-info" data-toggle="modal"
        data-target="#infoCard{{$reservation->id}}" style="color: white"><i class="fas fa-info"></i> Infos</a>
        <?php
      }
    }else{
      if ($reservation->nbre_places_annules == $reservation->nbre_places) {
       echo "<b>Voyage annulé (" . $reservation->nbre_places_annules . " places)</b>";
     }else{
      if ($reservation->type_destination == 1) {
        ?>
        ?>
        <a class="btn btn-info" data-toggle="modal"
        data-target="#infoCard{{$reservation->id}}" style="color: white"><i class="fas fa-info"></i> Infos</a>
        <?php
      }
    }

  }
  ?>
  @endif
  <?php
  if ($reservation->status_reservation == 1) {
    if ($reservation->type_destination == 1) {
      $dateTime = $reservation->destination->date_demarrage . " " . $reservation->destination->heure;
      if (compareToCurrentTime($dateTime) >= 3600) {
        if ($reservation->is_signal == 0) {
          ?>
          <a class="btn btn-danger" data-toggle="modal"
          data-target="#signalCard{{$reservation->id}}"><i class="fas fa-info" style="color: white"></i></a>
          <?php
        }
        ?>
        <a class="btn btn-success" data-toggle="modal"
        data-target="#noteCard{{$reservation->id}}"><i class="fas fa-edit" style="color: white"></i></a>
        <?php
      }
      if (compareToCurrentTime($dateTime) <= 7200) {
        ?>
        <a class="btn btn-danger" data-toggle="modal"
        data-target="#annulerCard{{$reservation->id}}" style="color: white"><i class="fas fa-trash" style="color: white"></i> Annuler</a>
        <?php
      }
    }
  }else{
    if ($reservation->nbre_places_annules < $reservation->nbre_places) {
      if ($reservation->type_destination == 1) {
        $dateTime = $reservation->destination->date_demarrage . " " . $reservation->destination->heure;
        if (compareToCurrentTime($dateTime) >= 3600) {
          if ($reservation->is_signal == 0) {
            ?>
            <a class="btn btn-danger" data-toggle="modal"
            data-target="#signalCard{{$reservation->id}}"><i class="fas fa-info" style="color: white"></i></a>
            <?php
          }
          ?>
          <a class="btn btn-success" data-toggle="modal"
          data-target="#noteCard{{$reservation->id}}"><i class="fas fa-edit" style="color: white"></i></a>
          <?php
        }
        if (compareToCurrentTime($dateTime) <= 7200) {
          ?>
          <a class="btn btn-danger" data-toggle="modal"
          data-target="#annulerCard{{$reservation->id}}" style="color: white"><i class="fas fa-trash" style="color: white"></i> Annuler</a>
          <?php
        }
      }
    }
  }
  ?>
</td>
</tr>
<?php
if ($reservation->type_destination == 1) {
  ?>
  <div class="modal fade" id="infoCard{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informations du chauffeur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            <span>Nom Complet</span> : {{ getUserNameById($reservation->destination->user->id) }}<hr>
            <span>Numéro de Téléphone</span> : {{$reservation->destination->user->telephone}}<hr>
            <span>Immatriculation</span> : {{ getVoyageurById($reservation->destination->user->id)->immatriculation }}<hr>
            <span>Type véhicule</span> : {{getVoyageurById($reservation->destination->user->id)->type_vehicule}}<hr>
          </p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
  <?php
}  ?>

<div class="modal fade" id="annulerCard{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Annuler le voyage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/user/annuler-voyage-places/{{$reservation->id}}" method="post">
         {{ csrf_field() }}
         <div class="row">
          <div class="col-lg-12">
            <label class="col-sm-12 col-form-label">Nombre de places à Annuler</label>
            <input type="number" name="nbre_places" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <center>
             <button type="submit" class="btn btn-success m-b-0">ANNULER</button>
           </center>
         </div>
       </div>
     </form>
   </div>
   <div class="modal-footer bg-whitesmoke br">
    <button type="button" class="btn btn-danger" style="color:white;" data-dismiss="modal">Fermer</button>
    <a href="/user/annuler-voyage/{{$reservation->id}}"
      class="btn btn-info"> TOUT ANNULER</a>
    </div>
  </div>
</div>
</div>
  <div class="modal fade" id="signalCard{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Signaler ce chauffeur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/user/signal-chauffeur/{{$reservation->id}}" method="post">
           {{ csrf_field() }}
           <div class="row">
            <div class="col-lg-12">
              <label class="col-sm-12 col-form-label">Motif</label>
              <textarea name="motif" class="form-control" required></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <center>
               <button type="submit" class="btn btn-success m-b-0">SIGNALER</button>
             </center>
           </div>
         </div>
       </form>
     </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="noteCard{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Noter ce Chauffeur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/user/note-chauffeur/{{$reservation->id}}" method="post">
             {{ csrf_field() }}
             <div class="row">
              <div class="col-lg-6">
                <label class="col-sm-12 col-form-label">Noter ce chauffeur</label>
                <input type="text" name="note{{$reservation->id}}" value="0" hidden>
                <div class="col-sm-12 col-lg-12">
                  <span class="fa fa-star" id="one{{$reservation->id}}"></span>
                  <span class="fa fa-star" id="two{{$reservation->id}}"></span>
                  <span class="fa fa-star" id="three{{$reservation->id}}"></span>
                  <span class="fa fa-star" id="four{{$reservation->id}}"></span>
                  <span class="fa fa-star" id="five{{$reservation->id}}"></span>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-lg-12">
                <center>
                 <button type="button" class="btn btn-danger" style="color: white;" id="effacer{{$reservation->id}}">EFFACER</button>
                 <button type="submit" class="btn btn-primary m-b-0">VALIDER</button>
               </center>
             </div>
           </div>
         </form>
       </div>
       <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('#effacer{{$reservation->id}}').on('click',function(){
    var element = document.getElementById("one{{$reservation->id}}");
    element.removeAttribute("class");
    element.classList.add("fa");
    element.classList.add("fa-star");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.removeAttribute("class");
    element2.classList.add("fa");
    element2.classList.add("fa-star");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.removeAttribute("class");
    element3.classList.add("fa");
    element3.classList.add("fa-star");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.removeAttribute("class");
    element4.classList.add("fa");
    element4.classList.add("fa-star");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.removeAttribute("class");
    element5.classList.add("fa");
    element5.classList.add("fa-star");
  });
  $('#one{{$reservation->id}}').on('click',function(){
    var element = document.getElementById("one{{$reservation->id}}");
    element.removeAttribute("class");
    element.classList.add("fa");
    element.classList.add("fa-star");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.removeAttribute("class");
    element2.classList.add("fa");
    element2.classList.add("fa-star");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.removeAttribute("class");
    element3.classList.add("fa");
    element3.classList.add("fa-star");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.removeAttribute("class");
    element4.classList.add("fa");
    element4.classList.add("fa-star");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.removeAttribute("class");
    element5.classList.add("fa");
    element5.classList.add("fa-star");


    var element = document.getElementById("one{{$reservation->id}}");
    element.classList.add("checked");
    $("input[name=note{{$reservation->id}}]").val("1");
  });
  $('#two{{$reservation->id}}').on('click',function(){
    var element = document.getElementById("one{{$reservation->id}}");
    element.removeAttribute("class");
    element.classList.add("fa");
    element.classList.add("fa-star");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.removeAttribute("class");
    element2.classList.add("fa");
    element2.classList.add("fa-star");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.removeAttribute("class");
    element3.classList.add("fa");
    element3.classList.add("fa-star");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.removeAttribute("class");
    element4.classList.add("fa");
    element4.classList.add("fa-star");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.removeAttribute("class");
    element5.classList.add("fa");
    element5.classList.add("fa-star");


    var element = document.getElementById("one{{$reservation->id}}");
    element.classList.add("checked");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.classList.add("checked");
    $("input[name=note{{$reservation->id}}]").val("2");
  });
  $('#three{{$reservation->id}}').on('click',function(){
    var element = document.getElementById("one{{$reservation->id}}");
    element.removeAttribute("class");
    element.classList.add("fa");
    element.classList.add("fa-star");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.removeAttribute("class");
    element2.classList.add("fa");
    element2.classList.add("fa-star");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.removeAttribute("class");
    element3.classList.add("fa");
    element3.classList.add("fa-star");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.removeAttribute("class");
    element4.classList.add("fa");
    element4.classList.add("fa-star");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.removeAttribute("class");
    element5.classList.add("fa");
    element5.classList.add("fa-star");


    var element = document.getElementById("one{{$reservation->id}}");
    element.classList.add("checked");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.classList.add("checked");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.classList.add("checked");
    $("input[name=note{{$reservation->id}}]").val("3");
  });
  $('#four{{$reservation->id}}').on('click',function(){
    var element = document.getElementById("one{{$reservation->id}}");
    element.removeAttribute("class");
    element.classList.add("fa");
    element.classList.add("fa-star");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.removeAttribute("class");
    element2.classList.add("fa");
    element2.classList.add("fa-star");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.removeAttribute("class");
    element3.classList.add("fa");
    element3.classList.add("fa-star");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.removeAttribute("class");
    element4.classList.add("fa");
    element4.classList.add("fa-star");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.removeAttribute("class");
    element5.classList.add("fa");
    element5.classList.add("fa-star");


    var element = document.getElementById("one{{$reservation->id}}");
    element.classList.add("checked");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.classList.add("checked");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.classList.add("checked");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.classList.add("checked");
    $("input[name=note{{$reservation->id}}]").val("4");
  });
  $('#five{{$reservation->id}}').on('click',function(){
    var element = document.getElementById("one{{$reservation->id}}");
    element.removeAttribute("class");
    element.classList.add("fa");
    element.classList.add("fa-star");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.removeAttribute("class");
    element2.classList.add("fa");
    element2.classList.add("fa-star");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.removeAttribute("class");
    element3.classList.add("fa");
    element3.classList.add("fa-star");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.removeAttribute("class");
    element4.classList.add("fa");
    element4.classList.add("fa-star");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.removeAttribute("class");
    element5.classList.add("fa");
    element5.classList.add("fa-star");


    var element = document.getElementById("one{{$reservation->id}}");
    element.classList.add("checked");
    var element2 = document.getElementById("two{{$reservation->id}}");
    element2.classList.add("checked");
    var element3 = document.getElementById("three{{$reservation->id}}");
    element3.classList.add("checked");
    var element4 = document.getElementById("four{{$reservation->id}}");
    element4.classList.add("checked");
    var element5 = document.getElementById("five{{$reservation->id}}");
    element5.classList.add("checked");
    $("input[name=note{{$reservation->id}}]").val("5");
  });
</script>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>