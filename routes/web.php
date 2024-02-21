<?php

# For language
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale',$locale);
    return redirect()->back();
});

Route::match(['get', 'post'], '/test-mail', 'FrontendController@testMail');

Route::match(['get', 'post'], '/test-notification', 'FrontendController@testNotification');

Route::match(['get', 'post'], '/get-currencies-values', 'FrontendController@getCurrenciesValues');

Route::match(['get', 'post'], '/', 'FrontendController@index');
Route::match(['get', 'post'], '/test-sms', 'FrontendController@testSms');
Route::match(['get', 'post'], '/test-fedapay', 'FrontendController@testFedapay');
Route::match(['get', 'post'], '/test-paygate', 'FrontendController@testPaygate');
Route::match(['get', 'post'], '/test-clicksend', 'FrontendController@testClickSend');
Route::match(['get', 'post'], '/callback-fedapay', 'FrontendController@callbackFedapay');
Route::match(['get', 'post'], '/callback-fedapay-souscription', 'FrontendController@callbackFedapaySouscription');
Route::match(['get', 'post'], '/callback-fedapay-mobile', 'FrontendController@callbackFedapayMobile');
Route::match(['get', 'post'], '/callback-fedapay-souscription-mobile', 'FrontendController@callbackFedapaySouscriptionMobile');
Route::match(['get', 'post'], '/callback-paygate', 'FrontendController@callbackPaygate');
Route::match(['get', 'post'], '/test-reservation', 'VoyageurController@testReservation');
Route::match(['get', 'post'], '/about', 'FrontendController@quiSommesNous');
Route::match(['get', 'post'], '/pay', 'FrontendController@payWithMomo');
Route::match(['get', 'post'], '/contact', 'FrontendController@contact');
Route::match(['get', 'post'], '/faq', 'FrontendController@faq');
Route::match(['get', 'post'], '/packages', 'FrontendController@packages');
Route::match(['get', 'post'], '/cgu', 'FrontendController@cgu');
Route::match(['get', 'post'], '/contrat-assurance', 'FrontendController@contratAssurance');
Route::match(['get', 'post'], '/policy', 'FrontendController@policy');
Route::match(['get', 'post'], '/login', 'AuthentificationController@login');
Route::match(['get', 'post'], '/login-compagnie', 'AuthentificationController@loginCompagnie');
Route::match(['get', 'post'], '/register', 'AuthentificationController@register');
Route::match(['get', 'post'], '/forget-password', 'AuthentificationController@forgetPassword');

Route::match(['get', 'post'], '/user', 'AuthentificationController@login');
Route::match(['get', 'post'], '/user-compagnie', 'AuthentificationController@loginCompagnie');
Route::match(['get', 'post'], '/choice', 'FrontendController@choice');
Route::match(['get', 'post'], '/validate-choice', 'FrontendController@validateChoice');
Route::match(['get', 'post'], '/choice-suggestion/{id}', 'FrontendController@choiceSuggestion');
Route::match(['get', 'post'], '/choice-suggestion-compagnie/{id}', 'FrontendController@choiceSuggestionCompagnie');
Route::match(['get', 'post'], '/choice-suggestion-compagnie-ligne/{id}', 'FrontendController@choiceSuggestionCompagnieLigne');
Route::match(['get', 'post'], '/subscribe-compagnie/{id}', 'FrontendController@subscribeCompagnie');
Route::match(['get', 'post'], '/desubscribe-compagnie/{id}', 'FrontendController@desubscribeCompagnie');
Route::match(['get', 'post'], '/compagnies-transport', 'FrontendController@compagniesTransport');

Route::match(['get', 'post'], '/payment-callback', 'FrontendController@paymentCallback');
Route::match(['get', 'post'], '/webhook', 'FrontendController@webhook');

Route::match(['get', 'post'], '/analyse-reservation', 'FrontendController@analyseReservation');




//Routes for User Dashboard
Route::group(['middleware' => ['user_logged']], function () {
    Route::match(['get', 'post'], '/user/confirm', 'AuthentificationController@confirm');
    Route::match(['get', 'post'], '/user/send-code', 'AuthentificationController@sendCode');
    Route::get('/user/dashboard', 'DashboardUserController@index');
    Route::match(['get', 'post'], '/user/add-departure', 'ChauffeurController@addDeparture');
    Route::match(['get', 'post'], '/user/edit-departure/{id}', 'ChauffeurController@editDeparture');
    Route::match(['get', 'post'], '/user/confirm-departure/{id}', 'ChauffeurController@confirmDeparture');
    Route::match(['get', 'post'], '/user/search-departure', 'VoyageurController@searchDeparture');
    Route::match(['get', 'post'], '/user/save-vehicule-infos', 'ChauffeurController@saveVehiculeInfos');
    Route::match(['get', 'post'], '/user/save-chauffeur-infos', 'ChauffeurController@saveChauffeurInfos');
    Route::match(['get', 'post'], '/user/save-voyageur-infos', 'VoyageurController@saveVoyageurInfos');
    Route::match(['get', 'post'], '/user/post-choice', 'VoyageurController@postChoice');
    Route::match(['get', 'post'], '/user/subscribe', 'ChauffeurController@subscribe');
    Route::match(['get', 'post'], '/user/pay-subscribe/{id}', 'ChauffeurController@paySubscribe');
    Route::match(['get', 'post'], '/user/subscribe-assurance', 'ChauffeurController@subscribeAssurance');
    Route::match(['get', 'post'], '/user/post-choice-compagnie', 'VoyageurController@postChoiceCompagnie');
    Route::match(['get', 'post'], '/user/validate-post-choice-compagnie', 'VoyageurController@validatePostChoiceCompagnie');
    Route::match(['get', 'post'], '/user/signal-chauffeur/{id}', 'VoyageurController@signalChauffeur');
    Route::match(['get', 'post'], '/user/note-chauffeur/{id}', 'VoyageurController@noteChauffeur');
    Route::match(['get', 'post'], '/user/annuler-voyage/{id}', 'VoyageurController@annulerVoyage');
    Route::match(['get', 'post'], '/user/annuler-voyage-places/{id}', 'VoyageurController@annulerVoyagePlaces');
    Route::get('/user/print-ticket-pdf/{id}', 'VoyageurController@printTicketPDF');
    Route::match(['get', 'post'], '/user/change-password', 'DashboardUserController@changePassword');
    Route::get('/user/logout', 'DashboardUserController@logout');

    
});
//Routes for User Dashboard
Route::group(['middleware' => ['compagnie']], function () {
    Route::get('/user-compagnie/dashboard', 'DashboardCompagnieController@index');
    Route::get('/user-compagnie/logout', 'DashboardCompagnieController@logout');
    Route::match(['get', 'post'], '/user-compagnie/change-password', 'DashboardCompagnieController@changePassword');
    Route::match(['get', 'post'], '/user-compagnie/add-depart', 'CompagnieController@addDeparture');
    Route::match(['get', 'post'], '/user-compagnie/edit-depart/{id}', 'CompagnieController@editDeparture');
    Route::match(['get', 'post'], '/user-compagnie/annuler-depart/{id}', 'CompagnieController@annulerDeparture');
    Route::match(['get', 'post'], '/user-compagnie/delete-depart/{id}', 'CompagnieController@deleteDeparture');
    Route::match(['get', 'post'], '/user-compagnie/all-departs', 'CompagnieController@showDeparture');
    Route::match(['get', 'post'], '/user-compagnie/show-departs', 'CompagnieController@showDeparture2');
    Route::match(['get', 'post'], '/user-compagnie/show-departs/{id}', 'CompagnieController@detailsDeparture');
    Route::match(['get', 'post'], '/user-compagnie/lignes-depart/{id}', 'CompagnieController@lignesDeparture');
    Route::match(['get', 'post'], '/user-compagnie/add-ligne-depart/{id}', 'CompagnieController@addLigneDepart');
    Route::match(['get', 'post'], '/user-compagnie/edit-ligne-depart/{id}', 'CompagnieController@editLigneDepart');
    Route::match(['get', 'post'], '/user-compagnie/delete-ligne-depart/{id}', 'CompagnieController@deleteLigneDepart');
    Route::match(['get', 'post'], '/user-compagnie/add-client', 'CompagnieController@addClient');
    Route::match(['get', 'post'], '/user-compagnie/edit-client/{id}', 'CompagnieController@editClient');
    Route::match(['get', 'post'], '/user-compagnie/add-client-reservation/{id}', 'CompagnieController@addClientReservation');
    Route::match(['get', 'post'], '/user-compagnie/delete-client/{id}', 'CompagnieController@deleteClient');
    Route::match(['get', 'post'], '/user-compagnie/all-clients', 'CompagnieController@showClient');
    Route::match(['get', 'post'], '/user-compagnie/show-client-reservations/{id}', 'CompagnieController@showClientReservations');
    Route::match(['get', 'post'], '/user-compagnie/all-reservations', 'CompagnieController@allReservations');
    Route::match(['get', 'post'], '/user-compagnie/add-new', 'CompagnieController@addNew');
    Route::match(['get', 'post'], '/user-compagnie/edit-new/{id}', 'CompagnieController@editNew');
    Route::match(['get', 'post'], '/user-compagnie/delete-new/{id}', 'CompagnieController@deleteNew');
    Route::match(['get', 'post'], '/user-compagnie/all-news', 'CompagnieController@showNew');
    Route::match(['get', 'post'], '/user-compagnie/all-abonnes', 'CompagnieController@showAbonnes');
    Route::get('/user-compagnie/print-ticket-pdf/{id}', 'CompagnieController@printTicketPDF');
    Route::get('/user-compagnie/print-ticket-pdf2/{id}', 'CompagnieController@printTicketPDF2');
    Route::match(['get', 'post'], '/user-compagnie/add-depart', 'CompagnieController@addDeparture');
    Route::match(['get', 'post'], '/user-compagnie/edit-depart/{id}', 'CompagnieController@editDeparture');
    Route::match(['get', 'post'], '/user-compagnie/delete-depart/{id}', 'CompagnieController@deleteDeparture');
    Route::match(['get', 'post'], '/user-compagnie/all-departs', 'CompagnieController@showDeparture');
    Route::post('/user-compagnie/attribute-siege-client/{id}', 'CompagnieController@attributeSiegeClient');
    Route::post('/user-compagnie/attribute-siege/{id}', 'CompagnieController@attributeSiege');
    Route::match(['get', 'post'], '/user-compagnie/messages', 'DashboardCompagnieController@messages');

    Route::match(['get', 'post'], '/user-compagnie/all-voyageurs', 'DashboardCompagnieController@allVoyageurs');
    Route::match(['get', 'post'], '/user-compagnie/send-message-voyageurs', 'DashboardCompagnieController@sendMessageVoyageurs');
    Route::match(['get', 'post'], '/user-compagnie/send-message-voyageurs/{id}', 'DashboardCompagnieController@sendMessageVoyageursDetails');
    Route::match(['get', 'post'], '/user-compagnie/send-message-abonnes', 'DashboardCompagnieController@sendMessageAbonnes');
    Route::match(['get', 'post'], '/user-compagnie/send-message-abonnes/{id}', 'DashboardCompagnieController@sendMessageAbonnesDetails');

    Route::match(['get', 'post'], '/user-compagnie/check-destination-places', 'CompagnieController@checkDestinationPlaces');


    
});


Route::match(['get', 'post'], '/admin/login', 'AdminLoginController@login');
Route::match(['get', 'post'], '/admin', 'AdminLoginController@login');
//Routes for Admin Dashboard
Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/dashboard', 'DashboardAdminController@index');
    Route::match(['get', 'post'], '/admin/change-password', 'DashboardAdminController@changePassword');
    Route::match(['get', 'post'], '/admin/change-password-compagnie/{id}', 'DashboardAdminController@changePasswordCompagnie');
    Route::match(['get', 'post'], '/admin/journaux', 'DashboardAdminController@journaux');
    Route::match(['get', 'post'], '/admin/delete-user/{id}', 'DashboardAdminController@deleteUser');
    Route::match(['get', 'post'], '/admin/add-admin', 'AdminController@add');
    Route::match(['get', 'post'], '/admin/edit-admin/{id}', 'AdminController@edit');
    Route::match(['get', 'post'], '/admin/delete-admin/{id}', 'AdminController@delete');
    Route::match(['get', 'post'], '/admin/all-admins', 'AdminController@show');
    Route::match(['get', 'post'], '/admin/all-voyageurs', 'DashboardAdminController@allVoyageurs');
    Route::match(['get', 'post'], '/admin/all-messages-voyageurs', 'DashboardAdminController@allMessagesVoyageurs');
    Route::match(['get', 'post'], '/admin/all-chauffeurs', 'DashboardAdminController@allChauffeurs');
    Route::match(['get', 'post'], '/admin/all-messages-chauffeurs', 'DashboardAdminController@allMessagesChauffeurs');
    Route::match(['get', 'post'], '/admin/add-compagnie', 'AdminCompagnieController@add');
    Route::match(['get', 'post'], '/admin/edit-compagnie/{id}', 'AdminCompagnieController@edit');
    Route::match(['get', 'post'], '/admin/details-compagnie/{id}', 'AdminCompagnieController@details');
     Route::match(['get', 'post'], '/admin/compagnie/stats-departs/{id}', 'AdminCompagnieController@statsDeparts');
     Route::match(['get', 'post'], '/admin/compagnie/stats-departs-details', 'AdminCompagnieController@statsDepartsDetails');
    Route::match(['get', 'post'], '/admin/delete-compagnie/{id}', 'AdminCompagnieController@delete');
    Route::match(['get', 'post'], '/admin/all-compagnies', 'AdminCompagnieController@show');

    Route::match(['get', 'post'], '/admin/add-depart', 'AdminVoyageController@addDeparture');
    Route::match(['get', 'post'], '/admin/edit-depart/{id}', 'AdminVoyageController@editDeparture');
    Route::match(['get', 'post'], '/admin/delete-depart/{id}', 'AdminVoyageController@deleteDeparture');
    Route::match(['get', 'post'], '/admin/all-departs', 'AdminVoyageController@showDeparture');
    Route::match(['get', 'post'], '/admin/lignes-depart/{id}', 'AdminVoyageController@lignesDeparture');
    Route::match(['get', 'post'], '/admin/add-ligne-depart/{id}', 'AdminVoyageController@addLigneDepart');
    Route::match(['get', 'post'], '/admin/edit-ligne-depart/{id}', 'AdminVoyageController@editLigneDepart');
    Route::match(['get', 'post'], '/admin/delete-ligne-depart/{id}', 'AdminVoyageController@deleteLigneDepart');

    Route::match(['get', 'post'], '/admin/mark-message/{id}', 'DashboardAdminController@markMessage');
    
    Route::match(['get', 'post'], '/admin/all-souscriptions-assurances', 'DashboardAdminController@allSouscriptionsAssurances');

    Route::match(['get', 'post'], '/admin/send-message-voyageurs', 'DashboardAdminController@sendMessageVoyageurs');
    Route::match(['get', 'post'], '/admin/send-message-voyageurs/{id}', 'DashboardAdminController@sendMessageVoyageursDetails');
    Route::match(['get', 'post'], '/admin/send-message-chauffeurs', 'DashboardAdminController@sendMessageChauffeurs');
    Route::match(['get', 'post'], '/admin/send-message-chauffeurs/{id}', 'DashboardAdminController@sendMessageChauffeursDetails');
    Route::match(['get', 'post'], '/admin/send-message-compagnies', 'DashboardAdminController@sendMessageCompagnies');
    Route::match(['get', 'post'], '/admin/send-message-compagnies/{id}', 'DashboardAdminController@sendMessageCompagniesDetails');
    Route::match(['get', 'post'], '/admin/verify-chauffeur/{id}', 'DashboardAdminController@verifyChauffeur');

    Route::get('/admin/logout', 'DashboardAdminController@logout');
    
});

Route::get('500', function()
{
    abort(500);
});

// For others functionality
Route::get('/migrate-fresh', function () {

    Artisan::call('migrate:fresh');

    Artisan::call('db:seed');

    /*Artisan::call('ide-helper:models -R');*/

    Artisan::call('config:cache');

    Artisan::call('config:clear');

    Artisan::call('cache:clear');

    Artisan::call('route:clear');

    Artisan::call('view:clear');

    Artisan::call('clear-compiled');

    return "OK.";
});

// For others functionality
Route::get('/migrate', function () {

    Artisan::call('migrate');

    Artisan::call('config:cache');

    Artisan::call('config:clear');

    Artisan::call('cache:clear');

    Artisan::call('route:clear');

    Artisan::call('view:clear');

    Artisan::call('clear-compiled');

    return "OK.";
});

Route::get('/clear-cache', function () {

    Artisan::call('config:cache');

    Artisan::call('config:clear');

    Artisan::call('cache:clear');

    Artisan::call('route:clear');

    Artisan::call('view:clear');

    Artisan::call('clear-compiled');

    return "OK.";
});