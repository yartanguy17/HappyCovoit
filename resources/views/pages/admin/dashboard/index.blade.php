@extends("layouts.base_admin") @section('title') Tableau de Bord @endsection @section('content')
<div class="page-body">
    <div class="row">
        @if(getAdminAuth()->niveau == 1)
        <div class="col-xl-4 col-md-6">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(1) }}</h4>
                            <h6 class="text-white m-b-0">Tous les Comptes Voyageurs</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-1" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: orange;border-color: orange;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(5) }}</h4>
                            <h6 class="text-white m-b-0">Nombre de Voyages effectués</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: black;border-color: black;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(6) }}</h4>
                            <h6 class="text-white m-b-0">Voyages effectués ce Mois</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif(getAdminAuth()->niveau == 2)
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(2) }}</h4>
                            <h6 class="text-white m-b-0">Comptes Chauffeurs Personnels</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-2" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card update-card" style="background-color: blue;border-color: blue;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(4) }}</h4>
                            <h6 class="text-white m-b-0">Souscriptions HT-Assurance</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card update-card" style="background-color: orange;border-color: orange;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(7) }}</h4>
                            <h6 class="text-white m-b-0">Nombre de Voyages effectués</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card update-card" style="background-color: black;border-color: black;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(8) }}</h4>
                            <h6 class="text-white m-b-0">Voyages effectués ce Mois</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif(getAdminAuth()->niveau == 3)
        <div class="col-xl-4 col-md-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(3) }}</h4>
                            <h6 class="text-white m-b-0">Toutes les Compagnies</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: orange;border-color: orange;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(9) }}</h4>
                            <h6 class="text-white m-b-0">Nombre de Voyages effectués</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: black;border-color: black;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(10) }}</h4>
                            <h6 class="text-white m-b-0">Voyages effectués ce Mois</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-xl-4 col-md-6">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(1) }}</h4>
                            <h6 class="text-white m-b-0">Tous les Comptes Voyageurs</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-1" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-c-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(2) }}</h4>
                            <h6 class="text-white m-b-0">Comptes Chauffeurs Personnels</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-2" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(3) }}</h4>
                            <h6 class="text-white m-b-0">Toutes les Compagnies</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: blue;border-color: blue;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(4) }}</h4>
                            <h6 class="text-white m-b-0">Souscriptions HT-Assurance</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: orange;border-color: orange;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(5) }}</h4>
                            <h6 class="text-white m-b-0">Nombre de Voyages effectués</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card update-card" style="background-color: black;border-color: black;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ getNbreStats(6) }}</h4>
                            <h6 class="text-white m-b-0">Voyages effectués ce Mois</h6>
                        </div>
                        <div class="col-4 text-right">
                            <canvas id="update-chart-3" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection @section('script') @endsection