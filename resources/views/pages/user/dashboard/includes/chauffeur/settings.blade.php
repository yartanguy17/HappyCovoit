 <div role="tabpanel" class="tab-pane" id="settings">
    <div class="personal-info">
        <div class="row">
            <div class="col-lg-6">
                <h4>Informations personnelles</h4>
            </div>
        </div>
        <div class="personal-details">
            <form action="/user/save-chauffeur-infos" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="text" id="indicatif" class="form-control" name="indicatif" hidden>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{getUserAuthChauffeur()->nom}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Prénoms</label>
                            <input type="text" name="prenoms" class="form-control" value="{{getUserAuthChauffeur()->prenoms}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Votre pseudo</label>
                            <input type="text" name="pseudo" class="form-control" value="{{getUserAuth()->pseudo}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Numéro de téléphone</label><br>
                            <input type="tel" value="{{getUserAuth()->telephone}}" class="form-control" name="telephone" placeholder="Numéro de téléphone" required style="width:100%;">
                            <small class="mr-2" style="color:red;display:none;" id="alert_phone">Entrez le numéro de téléphone avec indicatif (Ex : +228)
                            </small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Avatar</label><br>
                            <input type="file" name="avatar">
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <center>
                            <button type="submit" class="button button-dark tiny">Modifier</buttton>
                            </center>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>