@extends("layouts.base_compagnie") @section('title') Tableau de Bord @endsection @section('content')
<div class="page-body">
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getAllAbonnesCompagnies() }}</h4>
                            <h6 class="text-white m-b-0">Nombre d'abonnés</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-1" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getAllReservationsCompagnies() }}</h4>
                            <h6 class="text-white m-b-0">Réservations</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-2" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getAllDepartsCompagnies() }}</h4>
                            <h6 class="text-white m-b-0">Tous les Départs</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-lite-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getAllNewsCompagnies() }}</h4>
                            <h6 class="text-white m-b-0">News</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-4" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection @section('script') @endsection