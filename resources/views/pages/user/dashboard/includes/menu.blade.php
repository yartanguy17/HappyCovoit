<ul class="nav nav-tabs tab-navigation" role="tablist">
    
    <?php
    if(getUserAuth()->type_user == 1){
        ?>
        <li role="presentation" class="active">
            <a href="#dashboard" style="font-weight: bold;" aria-controls="dashboard" class="active" role="tab" data-toggle="tab">Tableau de bord</a>
        </li>
        <li role="presentation">
            <a href="#voyages-particulier" style="font-weight: bold;" aria-controls="voyages-particulier" role="tab" data-toggle="tab">Mes Voyages</a>
        </li>
        <li role="presentation">
            <a href="#settings" aria-controls="settings" style="font-weight: bold;" role="tab" data-toggle="tab">Informations personnelles</a>
        </li>
        <li role="presentation">
            <a href="#notifications" aria-controls="notifications" style="font-weight: bold;" role="tab" data-toggle="tab">Notifications</a>
        </li>
        <?php
    }else if(getUserAuth()->type_user == 2){
        ?>
        <li role="presentation" class="active">
            <a href="#dashboard" aria-controls="dashboard" style="font-weight: bold;font-size: 12px;" class="active" role="tab" data-toggle="tab">Tableau de bord</a>
        </li>
        <li role="presentation">
            <a href="#vehicles" aria-controls="vehicles" style="font-weight: bold;font-size: 12px;" role="tab" data-toggle="tab">Informations Véhicules</a>
        </li>
        <li role="presentation">
            <a href="#voyages-chauffeur" style="font-weight: bold;font-size: 12px;" aria-controls="voyages-chauffeur" role="tab" data-toggle="tab">Mes Départs</a>
        </li>
        <li role="presentation">
            <a href="#voyages-chauffeur-effectues" style="font-weight: bold;font-size: 12px;" aria-controls="voyages-chauffeur-effectues" role="tab" data-toggle="tab">Mes Voyages effectués</a>
        </li>
        <li role="presentation">
            <a href="#settings" aria-controls="settings" style="font-weight: bold;font-size: 12px;" role="tab" data-toggle="tab">Informations personnelles</a>
        </li>
        <li role="presentation">
            <a href="#notifications" aria-controls="notifications" style="font-weight: bold;font-size: 12px;" role="tab" data-toggle="tab">Notifications</a>
        </li>
        <li role="presentation">
            <a href="#souscriptions" aria-controls="souscriptions"  style="font-weight: bold;font-size: 12px;" role="tab" data-toggle="tab">Souscriptions</a>
        </li>
        <?php
    }
    ?>
    

    
    
</ul>