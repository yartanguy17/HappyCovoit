<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Menu Principal</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="/admin/dashboard">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Tableau de Bord</span>
                </a>
            </li>
            @if(getAdminAuth()->niveau == 1)
            <li class="">
                <a href="/admin/all-voyageurs">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Tous les Voyageurs</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/all-messages-voyageurs">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Messages des Voyageurs</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Paramètres</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/change-password">
                            <span class="pcoded-mtext">Changer de mot passe</span>
                        </a>
                    </li>
                </ul>
            </li>
            <div class="pcoded-navigatio-lavel">Autres</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="/admin/logout">
                        <span class="pcoded-micon"><i class="feather icon-power"></i></span>
                        <span class="pcoded-mtext">Déconnexion</span>
                    </a>
                </li>
            </ul>
            @elseif(getAdminAuth()->niveau == 2)
            <li class="">
                <a href="/admin/all-chauffeurs">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Tous les Chauffeurs</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/all-messages-chauffeurs">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Messages des Chauffeurs</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/all-souscriptions-assurances">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Souscriptions HT-Assurance</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Paramètres</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/change-password">
                            <span class="pcoded-mtext">Changer de mot passe</span>
                        </a>
                    </li>
                </ul>
            </li>
            <div class="pcoded-navigatio-lavel">Autres</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="/admin/logout">
                        <span class="pcoded-micon"><i class="feather icon-power"></i></span>
                        <span class="pcoded-mtext">Déconnexion</span>
                    </a>
                </li>
            </ul>
            @elseif(getAdminAuth()->niveau == 3)
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Gestion des Compagnies</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/add-compagnie">
                            <span class="pcoded-mtext">Ajouter</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="/admin/all-compagnies">
                            <span class="pcoded-mtext">Toutes les Compagnies</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-navigation"></i></span>
                    <span class="pcoded-mtext">Gestion des départs</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/add-depart">
                            <span class="pcoded-mtext">Ajouter</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="/admin/all-departs">
                            <span class="pcoded-mtext">Tous les départs</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Paramètres</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/change-password">
                            <span class="pcoded-mtext">Changer de mot passe</span>
                        </a>
                    </li>
                </ul>
            </li>
            <div class="pcoded-navigatio-lavel">Autres</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="/admin/logout">
                        <span class="pcoded-micon"><i class="feather icon-power"></i></span>
                        <span class="pcoded-mtext">Déconnexion</span>
                    </a>
                </li>
            </ul>
            @else
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                    <span class="pcoded-mtext">Gestion des Admins</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/add-admin">
                            <span class="pcoded-mtext">Ajouter</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="/admin/all-admins">
                            <span class="pcoded-mtext">Tous les Admins</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Gestion des Compagnies</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/add-compagnie">
                            <span class="pcoded-mtext">Ajouter</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="/admin/all-compagnies">
                            <span class="pcoded-mtext">Toutes les Compagnies</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-navigation"></i></span>
                    <span class="pcoded-mtext">Gestion des départs</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/add-depart">
                            <span class="pcoded-mtext">Ajouter</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="/admin/all-departs">
                            <span class="pcoded-mtext">Tous les départs</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="/admin/all-voyageurs">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Tous les Voyageurs</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/all-chauffeurs">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Tous les Chauffeurs</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/all-messages-chauffeurs">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Messages des Chauffeurs</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/all-messages-voyageurs">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Messages des Voyageurs</span>
                </a>
            </li>

            <!--<li class="">
                <a href="/admin/all-messages-admins">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Tous les Messages Utilisateurs</span>
                </a>
            </li>-->

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Paramètres</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="/admin/change-password">
                            <span class="pcoded-mtext">Changer de mot passe</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="/admin/all-souscriptions-assurances">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Souscriptions HT-Assurance</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel">Autres</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="/admin/journaux">
                    <span class="pcoded-micon"><i class="feather icon-navigation"></i></span>
                    <span class="pcoded-mtext">Journal des Actions</span>
                </a>
            </li>
            <li class="">
                <a href="/admin/logout">
                    <span class="pcoded-micon"><i class="feather icon-power"></i></span>
                    <span class="pcoded-mtext">Déconnexion</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</nav>