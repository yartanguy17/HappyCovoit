 <div role="tabpanel" class="tab-pane" id="vehicles">
    <div class="personal-info">
        <div class="row">
            <div class="col-lg-6">
                <h4>Informations véhicules</h4>
            </div>
        </div>
        <div class="personal-details">
            <form action="/user/save-vehicule-infos" method="POST">
                {{ csrf_field() }}
                <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Immatriculation</label>
                        <input type="text" class="form-control" placeholder="Immatriculation" value="{{ getUserAuthImmatriculation() }}" name="immatriculation" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Type de Véhicule (Plus de détails possible)</label>
                        <textarea class="form-control" name="type_vehicule" placeholder="Voiture de marque...." required>{{ getUserAuthTypeVehicule() }}</textarea>
                    </div>
                    <center>
                        <button type="submit" class="button button-dark tiny">Modifier</buttton>
                    </center>
                </div>
            </div>
            </form>
            
        </div>
    </div>
</div>