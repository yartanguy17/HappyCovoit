<div role="tabpanel" class="tab-pane" id="notifications">
    <div class="rides-details">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-dashboard">
                    <ul class="nav nav-tabs tab-navigation" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#news" aria-controls="news" class="active" role="tab" data-toggle="tab">News</a>
                        </li>
                        <li role="presentation">
                            <a href="#voyages" aria-controls="voyages" role="tab" data-toggle="tab">Voyages</a>
                        </li>
                        <li role="presentation">
                            <a href="#messages-admin" aria-controls="messages-admin" role="tab" data-toggle="tab">Messages Admin</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="news">
                            <div class="rides-details">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="total-earning-table table-responsive">
                                            <table class="table">
                                             <thead>
                                                <tr>
                                                    <th scope="col">Compagnie</th>
                                                    <th scope="col">Titre</th>
                                                    <th scope="col">Contenu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($news as $new)
                                               <tr>
                                                <td>{{ getUserNameById($new->user->id) }}</td>
                                                <td>{{ $new->titre }}</td>
                                                <td>{{ $new->contenu }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="voyages">
                    <div class="rides-details">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="total-earning-table table-responsive">
                                    <table class="table">
                                     <thead>
                                        <tr>
                                            <th scope="col">Titre</th>
                                            <th scope="col">Contenu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($notifications as $notification)
                                       <tr>
                                        <td>{{ $notification->titre }}</td>
                                        <td>{{ $notification->contenu }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="messages-admin">
            <div class="rides-details">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="total-earning-table table-responsive">
                            <table class="table">
                             <thead>
                                <tr>
                                    <th scope="col">Contenu</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($messages as $message)
                               <tr>
                                <td>{{ $message->contenu }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

</div>

</div>
</div>