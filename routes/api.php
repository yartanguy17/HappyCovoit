<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/search-pays-destination-chauffeur', 'Api\ApiVoyageurController@searchPaysDestinationChauffeur');
Route::get('/search-ville-destination-chauffeur', 'Api\ApiVoyageurController@searchVilleDestinationChauffeur');
Route::get('/search-pays-demarrage-chauffeur', 'Api\ApiVoyageurController@searchPaysDemarrageChauffeur');
Route::get('/search-ville-demarrage-chauffeur', 'Api\ApiVoyageurController@searchVilleDemarrageChauffeur');


Route::get('/search-pays-destination-compagnie', 'Api\ApiVoyageurController@searchPaysDestinationCompagnie');
Route::get('/search-ville-destination-compagnie', 'Api\ApiVoyageurController@searchVilleDestinationCompagnie');
Route::get('/search-pays-demarrage-compagnie', 'Api\ApiVoyageurController@searchPaysDemarrageCompagnie');
Route::get('/search-ville-demarrage-compagnie', 'Api\ApiVoyageurController@searchVilleDemarrageCompagnie');






/*
    Api Gestion des Destinations
 */
    Route::post("add-destination", "Api\ApiController@addDestination");
    Route::post("edit-destination", "Api\ApiController@editDestination");
    Route::post("confirm-destination/{id}", "Api\ApiController@confirmDestination");
    Route::post("search-departure", "Api\ApiController@searchDeparture");
    Route::get("destinations/{id}", "Api\ApiController@destinationsDetails");
    Route::get("destinations-compagnies/{id}", "Api\ApiController@destinationsDetailsCompagnies");
    Route::get("destinations-compagnies-ligne/{id}", "Api\ApiController@destinationsDetailsCompagniesLigne");
    Route::get("compagnies", "Api\ApiController@compagnies");
    Route::prefix('user')->group(function () {
    	Route::post("login", "Api\AuthController@login");
    	Route::post("save-infos", "Api\AuthController@saveInfos");
        Route::post("send-code-auth", "Api\AuthController@sendCodeAuth");
        Route::post("reinitialize-password", "Api\AuthController@reinitializePassword");
    	Route::post("register", "Api\AuthController@register");
    	Route::match(['get', 'post'], '/update-password', 'Api\AuthController@updatePassword');
    	Route::match(['get', 'post'], '/update-infos', 'Api\AuthController@updateInfos');
        Route::match(['get', 'post'], '/update-avatar', 'Api\AuthController@updateAvatar');
        Route::match(['get', 'post'], '/update-chauffeur', 'Api\AuthController@updateChauffeur');
    	Route::get("destinations/{id}", "Api\ApiController@destinations");
        Route::post('service-notification', 'Api\ApiController@serviceNotification');
    	Route::get("reservations/{id}", "Api\ApiController@reservations");
        Route::get("souscriptions/{id}", "Api\ApiController@souscriptions");
        Route::get("reservations-month/{id}", "Api\ApiController@reservationsMonth");
    	Route::get("messages-admin/{id}", "Api\ApiController@messagesAdmin");
    	Route::match(['get', 'post'], '/notifications/{id}', 'Api\ApiController@notifications');
        Route::post("subscribe-compagnie/{id}", "Api\ApiController@subscribeCompagnie");
        Route::post("unsubscribe-compagnie/{id}", "Api\ApiController@unsubscribeCompagnie");
        Route::post("subscribe", "Api\ApiController@souscription");
        Route::post("pay-subscribe/{id}", "Api\ApiController@paySouscription");
        Route::post("subscribe-assurance", "Api\ApiController@souscriptionAssurance");
        Route::post("finalize-operation", "Api\ApiController@finalizeOperation");
        Route::post("signaler-reservation/{id}", "Api\ApiController@signalerReservation");
        Route::post("annuler-reservation/{id}", "Api\ApiController@annulerReservation");
    });

    Route::post("feedback", "Api\ApiController@feedback");
    Route::post("message-admin", "Api\ApiController@messageAdmin");
    Route::get("print-ticket-pdf/{id}", "Api\ApiController@printTicketPDF");
