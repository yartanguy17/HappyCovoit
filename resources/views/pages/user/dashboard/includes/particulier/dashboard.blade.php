<div role="tabpanel" class="tab-pane active" id="dashboard">
    <div class="dashboard-info">
        <div class="overview-counter small-section">
            <h4>Statistiques</h4>
            <div class="counter-wrapper bg-gray small-section-item">
                <div class="single-counter-box">
                    <h2 class="counter-number">{{ getNbreReservationByIdSession() }}</h2>
                    <p class="counter-text">Tous mes Voyages</p>
                </div>
                <!--<div class="single-counter-box">
                    <h2 class="counter-number">0</h2>
                    <p class="counter-text">Nombre de Chauffeurs</p>
                </div>-->
                <div class="single-counter-box">
                    <h2 class="counter-number">{{ getNbreReservationByIdSessionMonth() }}</h2>
                    <p class="counter-text">Voyages du Mois</p>
                </div>
            </div>
        </div>

        <!--<div class="earning-details small-section">
            <h4>Mes derniers voyages</h4>
            <div class="total-earning-table table-responsive small-section-item">
             
</div>
</div>-->
</div>
</div>