<div role="tabpanel" class="tab-pane active" id="dashboard">
    <div class="dashboard-info">
        <div class="overview-counter small-section">
            <h4>Statistiques</h4>
            <div class="counter-wrapper bg-gray small-section-item">
                <div class="single-counter-box">
                    <h2 class="counter-number">{{ getNbreVoyageByIdSession() }}</h2>
                    <p class="counter-text">Tous les Voyages</p>
                </div>
                <!--<div class="single-counter-box">
                    <h2 class="counter-number">0</h2>
                    <p class="counter-text">Nombre de Passagers</p>
                </div>-->
                <div class="single-counter-box">
                    <h2 class="counter-number">{{ getNbreVoyageByIdSessionMonth() }}</h2>
                    <p class="counter-text">Voyages du Mois</p>
                </div>
            </div>
        </div>

        <div class="earning-details small-section">
            <h4>Mes derniers voyages</h4>
            <div class="total-earning-table table-responsive small-section-item">
                <table class="table">
                    <thead>
                        <tr>
                                <th scope="col">Destination</th>
                                <th scope="col">Date et Heure Départ</th>
                                <th scope="col">Nombre de places</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">Actions</th>
                            </tr>
                    </thead>
                    <tbody>
                         @foreach(getAllChauffeurDestination() as $destination)
                           <tr>
                            <td>{{$destination->ville_destination}}, {{$destination->pays_destination}}</td>
                            <td>
                                 <?php
                                $dateDemarrage = $destination->date_demarrage;
                                $explodeDats = explode("-", $dateDemarrage);
                                echo $explodeDats[2] . "-" . $explodeDats[1] . "-" . $explodeDats[0] . " " .$destination->heure;
                                ?>
                            </td>
                            <td>{{$destination->nbre_places}}</td>
                            <td>{{$destination->prix_unitaire}} FCFA</td>
                            <td>
                                <?php
                            if ($destination->is_confirmed == 0) {
                            ?>
                            <a href="/user/edit-departure/{{$destination->id}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                             <?php
                }else{
                    echo "--";
                }
                ?>
                            <?php
                            if ($destination->is_confirmed == 0) {
                            ?>
                            <a class="btn btn-success" data-toggle="modal"
                            data-target="#confirmCard{{$destination->id}}"><i class="fas fa-check" style="color: white"></i></a>
                            <div class="modal fade" id="confirmCard{{$destination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <p>Etes-vous sûr de confirmer cette destination?</p>
                              </div>
                              <div class="modal-footer bg-whitesmoke br">
                                  <a href="/user/confirm-departure/{{$destination->id}}"
                                    class="btn btn-primary"> Oui</a>
                                    <button type="button" class="btn btn-warning" style="color:white;" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>