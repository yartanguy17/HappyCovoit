<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\DestinationCompagnie as DestinationCompagnieResource;
use App\Http\Resources\LigneDestination as LigneDestinationResource;
//use App\Http\Resources\DestinationCompagnieNew as DestinationCompagnieNewResource;
use App\Http\Resources\Destination as DestinationResource;
use App\Http\Resources\DestinationNew as DestinationNewResource;
use App\Http\Resources\Notification as NotificationResource;
use App\Http\Resources\Reservation as ReservationResource;
use App\Http\Resources\Souscription as SouscriptionResource;
use App\Http\Resources\Compagnie as CompagnieResource;
use App\Http\Controllers\Controller as LaravelController;
use App\Models\User;
use App\Models\DestinationCompagnie;
use App\Models\Destination;
use App\Models\LigneDestination;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\MessageAdmin;
use App\Models\Compagnie;
use App\Models\Souscription;
use App\Models\Feedback;
use App\Models\Paiement;
use App\Models\PaiementSouscription;
use App\Models\ClientSubscribeCompagnie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use Carbon\Carbon;
use App\Models\ReservationSiege;
use App\Models\Chauffeur;
use \Mailjet\Resources;
use PDF;
use QrCode;
use Redirect;
class ApiController extends LaravelController
{
 /**
   * @group  Api Destination
   *
   */
 public function destinationsDetails(Request $request, $idDestination)
 {
  $args = array();
  $destination = Destination::where('id', '=', $idDestination)->first();
  $args['destination'] = new DestinationResource($destination);

  return response()->json($args, 200);
}
   /**
   * @group  Api Destination
   *
   */
   public function destinationsDetailsCompagnies(Request $request, $idDestination)
   {
    $args = array();
    $destination = DestinationCompagnie::where('id', '=', $idDestination)->first();
    $args['destination'] = new DestinationCompagnieResource($destination);

    return response()->json($args, 200);
  }
   /**
   * @group  Api Destination Ligne
   *
   */
   public function destinationsDetailsCompagniesLigne(Request $request, $idLigne)
   {
    $args = array();
    $ligne = LigneDestination::where('id', '=', $idLigne)->first();
    $args['ligne'] = new LigneDestinationResource($ligne);

    return response()->json($args, 200);
  }
  /**
   * @group  Api Gestion Departs
   *
   */
  public function addDestination(Request $request)
  {
    $args = array();
    $args['error'] = false;
    $args['status'] = true;
    $user = User::where('id', '=', $request->id)->first();
    try {
      if ($user == null) {
        $args['error'] = true;
        $args['status'] = false;
        $args['error_message'] = "Erreur survenue avec l'Id";
        return response()->json($args, 200);
      }else{
        $searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $user->id,'type' => 1])->get()->count();
        if ($searchSouscription == 0) {
         $args['status'] = false;
         return response()->json($args, 200);
       }
       $searchSouscriptionLast = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $user->id,'type' => 1])->orderBy('id','DESC')->first();
       if($searchSouscriptionLast->paiements->count() > 0){
        if ($searchSouscriptionLast->paiements[0]->type == 1) {
          if (checkPayment($searchSouscriptionLast->paiements[0]->identifier) != 0) {
            $args['status'] = false;
            return response()->json($args, 200);
          }
        }else if($searchSouscriptionLast->paiements[0]->type ==2){
          if($searchSouscriptionLast->paiements[0]->status == 0){
            if (checkPaymentFedapay($searchSouscriptionLast->paiements[0]->identifier) != 0) {
              $args['status'] = false;
            }
          } 
        }
      }else{
        $args['status'] = false;
        return response()->json($args, 200);
      }

      $depart = new Destination();
      $depart->pays_destination = $request->pays_destination;
      $depart->ville_destination = $request->ville_destination;
      $depart->nbre_places = $request->nbre_places;
      $depart->nbre_places_dispo = $request->nbre_places;
      $depart->prix_unitaire = $request->prix_unitaire;
      $depart->pays_demarrage = $request->pays_demarrage;
      $depart->ville_demarrage = $request->ville_demarrage;
      $depart->date_demarrage = $request->date_demarrage;
      $depart->surcharge = $request->surcharge;
      $depart->heure = $request->heure;
      $depart->user_id = $user->id;
      $depart->status = 1;
      $depart->save();
      $args['destination'] = new DestinationNewResource($depart);
      $args['message'] = "Nouveau départ ajoutée avec succès";
    }
  } catch (\Exception $e) {
    $args['error'] = true;
    $args['status'] = false;
    $args['error_message'] = $e->errorInfo;
    $args['message'] = "Erreur lors de l'enregistrement de vos informations";
  }

  return response()->json($args, 200);
}
public function compagnies()
{
  $compagnies = Compagnie::all();
  return response()->json([
    'data' => CompagnieResource::collection($compagnies)
  ]);
}

public function signalerReservation(Request $request, $idReservation)
{
  $args = array();
  $args['status'] = false;
  try {
    $motif = $request->motif;
    Reservation::where(['id' => $idReservation])->update([
      'is_signal' => 1,
      'motif' => $motif
    ]);
    $args['status'] = true;
  } catch (\Exception $e) {
    $args['status'] = true;
    $args['error_message'] = $e->getMessage();;
    $args['message'] = "Erreur lors de la modification";
  }

  return response()->json($args, 200);
}
public function annulerReservation(Request $request, $idReservation)
{
  $args = array();
  $args['status'] = false;
  try {
    $nbrePlaces = $request->nbre_places;
    $reservation = Reservation::where(['id' => $idReservation])->first();
    if ($nbrePlaces > 0) { 
      if ($nbrePlaces == $reservation->nbre_places) {
       Reservation::where(['id' => $idReservation])->update([
        'status_reservation' => 99,
        'nbre_places_annules' => $reservation->nbre_places
      ]);
     } 
     if ($reservation->nbre_places_annules > 0) {
      $nbrePlaces += $reservation->nbre_places_annules;
    }
    $placesR = $reservation->nbre_places - $nbrePlaces;
    $prixTotalNew = $reservation->destination->prix_unitaire * $placesR;

    Reservation::where(['id' => $idReservation])->update([
      'status_reservation' => 0,
      'prix_total' => $prixTotalNew,
      'prix_total_commission' => $prixTotalNew,
      'nbre_places_annules' => $nbrePlaces
    ]);
  }else{
    Reservation::where(['id' => $idReservation])->update([
      'status_reservation' => 99,
      'nbre_places_annules' => $reservation->nbre_places
    ]);
  }

  $user = User::where(['id' => $request->id])->first();
  Notification::create([
    'titre' => "Annulation de réservation",
    'contenu' => getUserNameById($request->id) . " a annulé ". $nbrePlaces ." places de sa réservation  pour la destination " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . ". Son numéro de Téléphone est " . $user->telephone,
    'user_id' => $reservation->destination->user->id
  ]);
  $args['status'] = true;
} catch (\Exception $e) {
  $args['status'] = true;
  $args['error_message'] = $e->getMessage();
  $args['message'] = "Erreur lors de la modification";
}

return response()->json($args, 200);
}

public function subscribeCompagnie(Request $request,$idCompagnie)
{
  $args = array();
  $args['status'] = false;
  try {
    ClientSubscribeCompagnie::create([
      'client_id' => $request->id,
      'compagnie_id' => $idCompagnie
    ]);
    $args['status'] = true;
  } catch (\Exception $e) {
    $args['status'] = true;
    $args['error_message'] = $e->errorInfo;
    $args['message'] = "Erreur lors de la modification";
  }

  return response()->json($args, 200);
}

public function unsubscribeCompagnie(Request $request,$idCompagnie)
{
  $args = array();
  $args['status'] = false;
  try {
    $desubscribe = ClientSubscribeCompagnie::where(['compagnie_id' => $idCompagnie,'client_id' => $request->id])->first();
    $desubscribe->delete();
    $args['status'] = true;
  } catch (\Exception $e) {
    $args['status'] = true;
    $args['error_message'] = $e->errorInfo;
    $args['message'] = "Erreur lors de la modification";
  }

  return response()->json($args, 200);
}

  /**
     * @group  Api Gestion Departs
     *
     */
  public function editDestination(Request $request)
  {
    $args = array();
    $args['error'] = false;
    $destination = Destination::where('id', '=', $request->id)->first();
    if ($destination == null) {
      $args['error'] = true;
      $args['error_message'] = "Destination introuvable";
      return response()->json($args, 200);
    }
    try {
      Destination::where(['id' => $destination->id])->update([
        'pays_destination' => $request->pays_destination,
        'ville_destination' => $request->ville_destination,
        'nbre_places' => $request->nbre_places,
        'nbre_places_dispo' => $request->nbre_places,
        'prix_unitaire' => $request->prix_unitaire,
        'pays_demarrage' => $request->pays_demarrage,
        'ville_demarrage' => $request->ville_demarrage,
        'date_demarrage' => $request->date_demarrage,
        'heure' => $request->heure,
        'surcharge' => $request->surcharge
      ]);

      $destination = Destination::where('id', '=', $request->id)->first();

      /*$destination->pays_destination = $request->pays_destination;
      $destination->ville_destination = $request->ville_destination;
      $destination->nbre_places = $request->nbre_places;
      $destination->nbre_places_dispo = $request->nbre_places;
      $destination->prix_unitaire = $request->prix_unitaire;
      $destination->pays_demarrage = $request->pays_demarrage;
      $destination->ville_demarrage = $request->ville_demarrage;
      $destination->date_demarrage = $request->date_demarrage;
      $destination->surcharge = $request->surcharge;
      $destination->heure = $request->heure;
      $destination->save();*/
      $args['destination'] = new DestinationNewResource($destination);
      $args['message'] = "Destination modifiée avec succès";
    } catch (\Exception $e) {
      $args['error'] = true;
      $args['error_message'] = $e->errorInfo;
      $args['message'] = "Erreur lors de la modification";
    }

    return response()->json($args, 200);
  }

   /**
     * @group  Api Gestion Departs
     *
     */
   public function confirmDestination(Request $request,$id)
   {
    $args = array();
    $args['error'] = false;
    $destination = Destination::where('id', '=', $id)->first();
    if ($destination == null) {
      $args['error'] = true;
      $args['error_message'] = "Destination introuvable";
      return response()->json($args, 200);
    }
    try {
      $destination->is_confirmed = 1;
      $destination->save();
      $reservations = Reservation::where(['destination_id' => $destination->id])->get();
      foreach ($reservations as $reservation) {
        Notification::create([
          'titre' => "Démarrage du voyage",
          'contenu' => "Le Chauffeur de la destination " .$destination->ville_destination . " - " . $destination->pays_destination . " vient de démarrer.",
          'user_id' => $reservation->user->id
        ]);
      }
      $args['message'] = "Destination confirmée avec succès";
    } catch (\Exception $e) {
      $args['error'] = true;
      $args['error_message'] = $e->errorInfo;
      $args['message'] = "Erreur lors de la modification";
    }

    return response()->json($args, 200);
  }
/**
     * @group  Api Gestion Departs
     *
     */
public function destinations(Request $request, $idUser)
{
 $args = array();
 $args['data'] = DestinationNewResource::collection(Destination::where('user_id', '=', $idUser)->orderBy('created_at','DESC')->get());
 return response()->json(
  $args, 200
);
}
public function reservations(Request $request, $idUser)
{
 $args = array();
 $args['data'] = ReservationResource::collection(Reservation::where('user_id', '=', $idUser)->where('status_reservation', '!=', 99)->orderBy('created_at','DESC')->get());
 return response()->json(
  $args, 200
);
}
public function souscriptions(Request $request, $idUser)
{
 $args = array();
 $args['data'] = SouscriptionResource::collection(Souscription::where('user_id', '=', $idUser)->orderBy('created_at','DESC')->get());
 return response()->json(
  $args, 200
);
}
public function reservationsMonth(Request $request, $idUser)
{
 $args = array();
 $args['data'] = ReservationResource::collection(Reservation::where('user_id', '=', $idUser)->where('status_reservation', '!=', 99)->where(DB::raw('MONTH(created_at)'), '=', date('m'))->orderBy('created_at','DESC')->get());
 return response()->json(
  $args, 200
);
}
public function feedback(Request $request)
{
  $feedback = new Feedback();
  $feedback->contenu = $request->message;
  $feedback->user_id = $request->id;
  $feedback->save();
  $user = User::where('id', $request->id)->first();

  $name = getUserFirstName($user->id) . " " . getUserLastName($user->id);
  $telephone = $user->telephone;
  $contenu = $request->message;
  $email = getUserEmail($user->id);
  $values = '{"name":"'.$name.'","email":"'.$email.'","telephone":"'.$telephone.'","objet":"Informations","message":"'.$contenu.'"}';
  $mj = new \Mailjet\Client('3585dbe29d19cd029c599629e9248d7c','56576a5e8cc53dbbdb5e8854dc5d1941',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "contact@cdejericho.org",
          'Name' => "Site HappyTravelWorld"
        ],
        'To' => [
          [
            'Email' => "happytravel.htworld@gmail.com",
            'Name' => "Hapyy Travel World"
          ]
        ],
        'TemplateID' => 1534235,
        'TemplateLanguage' => true,
        'Subject' => "Demande d'informations",
        'Variables' => json_decode($values, true)
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  //$response->success() && var_dump($response->getData());

  return response()->json([
    'status' => 'success',
    'data' => $feedback
  ]);
}

public function messageAdmin(Request $request)
{
  $messageAdmin = new MessageAdmin();
  $messageAdmin->contenu = $request->message;
  $messageAdmin->user_id = $request->id;
  $messageAdmin->save();
  $user = User::where('id', $request->id)->first();

  return response()->json([
    'status' => 'success',
    'data' => $messageAdmin
  ]);
}


public function notifications($id)
{
  $messages = Notification::where('user_id', $id)
  ->orderBy("created_at", 'DESC')
  ->get();
  return response()->json([
    'data' => NotificationResource::collection($messages)
  ]);
}
public function serviceNotification(Request $request)
{

  try {
    $notifications= Notification::where('user_id', $request->id)->where('status', 0)->orderBy('created_at','DESC')->get();
    $user = User::where(['id' => $request->id])->first();
    $found = 0;
    $count = 0;
    foreach ($notifications as $notification) {
      //$difference = compareToCurrentTime($notification->created_at);
      sendNotification($notification->titre, $notification->contenu,$user->token);
      if (compareToCurrentTime($notification->created_at) < 3600) {
        $count += 1;
      }
      $notification->status = 1;
      $notification->save();

    }
    
  } catch (\Throwable $th) {
    return response()->json([
      'status' => false,
      'message' => $th->getMessage()
    ]);
  }
  return response()->json([
    'status' => true,
    'count' => $count,
    //'data' => NotificationResource::collection($notifications),
    'user' => new UserResource($user)
  ]);
}
public function searchDeparture(Request $request)
{
 $args = array();
 $args['error'] = false;
 try {
  $pays_destination = $request->pays_destination;
  $ville_destination = $request->ville_destination;
  $pays_demarrage = $request->pays_demarrage;
  $ville_demarrage = $request->ville_demarrage;
  $date_demarrage = $request->date_demarrage;
  $heure_demarrage = $request->heure_demarrage;
  $type = $request->type;
  if ($type==1) {
    $destinations = Destination::where(
      [
        'pays_destination' => $pays_destination,
        'ville_destination' => $ville_destination,
        'pays_demarrage' => $pays_demarrage,
        'ville_demarrage' => $ville_demarrage,
        'date_demarrage' => $date_demarrage,
        'heure' => $heure_demarrage,
        'status' => 1
      ]
    )->orderBy('created_at','DESC')->get();
    $result = $destinations->count();
    if ($result == 0) {
      $destinations = Destination::where(
        [
          'pays_destination' => $pays_destination,
          'ville_destination' => $ville_destination,
          'pays_demarrage' => $pays_demarrage,
          'ville_demarrage' => $ville_demarrage,
          'date_demarrage' => $date_demarrage,
          'status' => 1
        ]
      )->where('heure','>=',$heure_demarrage)->orderBy('created_at','DESC')->get();
    }
    $args['destinations'] = DestinationResource::collection($destinations);
    $args['result'] = $result;
    $args['type'] = $type;
  }else{
    $day = date('D', strtotime($date_demarrage));
    $lignes = null;
    $result2 = 0;
    $destinations = DestinationCompagnie::where(
      [
        'pays_destination' => $pays_destination,
        'ville_destination' => $ville_destination,
        'pays_demarrage' => $pays_demarrage,
        'ville_demarrage' => $ville_demarrage,
        'jour' => getJour($day),
        'heure' => $heure_demarrage,
        'status' => 1
      ]
    )->orderBy('created_at','DESC')->get();
    $result = $destinations->count();
    if ($result == 0) {
      $destinations = DestinationCompagnie::where(
        [
          'jour' => getJour($day),
          'pays_destination' => $pays_destination,
          'ville_destination' => $ville_destination,
          'pays_demarrage' => $pays_demarrage,
            'ville_demarrage' => $ville_demarrage,
            'status' => 1
        ]
      )->where('heure','>=',$heure_demarrage)->orderBy('created_at','DESC')->get();

      $result2 = $destinations->count();
      if ($result2 == 0) {
        $lignes = LigneDestination::where(
          [
          //'jour' => getJour($day),
            'pays_destination' => $pays_destination,
            'ville_destination' => $ville_destination,
            'status' => 1
          ]
        )->orderBy('created_at','DESC')->get();

      }

    }
    $args['destinations'] = DestinationCompagnieResource::collection($destinations);
    $args['result'] = $result;
    $args['result2'] = $result2;
    $args['lignes'] = ($lignes!=null)?LigneDestinationResource::collection($lignes):array();
    $args['type'] = $type;
    $args['jour'] = getJour($day);
  }
  $args['count'] = $destinations->count();
} catch (\Exception $e) {
  $args['error'] = true;
  $args['error_message'] = $e->getMessage();
  $args['message'] = "Erreur lors de la recherche";
}
return response()->json($args, 200);
}

public function souscription(Request $request)
{
  $args = array();
  $args['error'] = false;
  $user = User::where('id', '=', $request->id)->first();
  try {
    if ($user == null) {
      $args['error'] = true;
      $args['error_message'] = "Erreur survenue avec l'Id";
      $args['status'] = false;
      return response()->json($args, 200);
    }else{
      $validite = $request->validite;
      $dateCurrent = date('Y-m-d');
      $searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $user->id,'type'=>1])->get()->count();
      if ($searchSouscription > 0) {
        $args['status'] = false;
      }
      $timestamp1 = strtotime($dateCurrent);
      $count = 60 * 60 * 24 * 365;
      $timestamp2 = $timestamp1 + $count;

      $year = date('Y') + 1;
      $month = date('m');
      $day = date('d');

      $dateExpiration = date('Y-m-d', $timestamp2);

      $reference = getRamdomText(15);

      $identifier = getRamdomText(15);

      Souscription::create([
        'date_souscription' => Date('Y-m-d'),
        'validite' => $validite,
        'prix' => 5000,
        'facture' => $reference,
        'reference' => $reference,
        'expiration' => $dateExpiration,
        'user_id' => $user->id
      ]);

      $souscription = Souscription::where(['reference' => $reference])->first();

      $args['status'] = true;

      if ($user->indicatif=="+228") {
        PaiementSouscription::create([
          'identifier' => $identifier,
          'tx_reference' => "",
          'amount' => 5000,
          'souscription_id' => $souscription->id,
          'type'=>1
        ]);
        $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=5000&description=Souscription Compte Chauffeur&identifier='. $identifier;

      }elseif ($user->indicatif=="+229") {

        $transaction = payFedapay(getUserEmail($user->id), getUserFirstName($user->id), getUserLastName($user->id), 5000, "Souscription Compte Chauffeur", $user->telephone);

        $urlPaiement = $transaction['url'];
        PaiementSouscription::create([
          'identifier' => $identifier,
          'tx_reference' => "",
          'amount' => 5000,
          'souscription_id' => $souscription->id,
          'type'=>2,
          'token'=>$transaction['token']
        ]);
      }
      $args['url_paiement'] = $urlPaiement;
    }
  } catch (\Exception $e) {
    $args['error'] = true;
    $args['status'] = false;
    $args['error_message'] = $e->getMessage();
    $args['message'] = "Erreur lors de l'enregistrement de vos informations";
  }

  return response()->json($args, 200);
}


public function souscriptionAssurance(Request $request)
{
  $args = array();
  $args['error'] = false;
  $user = User::where('id', '=', $request->id)->first();
  try {
    if ($user == null) {
      $args['error'] = true;
      $args['error_message'] = "Erreur survenue avec l'Id";
      $args['status'] = false;
      return response()->json($args, 200);
    }else{
      $validite = $request->validite;
      $dateCurrent = date('Y-m-d');
      $searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $user->id,'type'=>2])->get()->count();
      if ($searchSouscription > 0) {
        $args['status'] = false;
      }
      $timestamp1 = strtotime($dateCurrent);
      $count = 60 * 60 * 24 * 365;
      $timestamp2 = $timestamp1 + $count;

      $year = date('Y') + 1;
      $month = date('m');
      $day = date('d');

      $dateExpiration = date('Y-m-d', $timestamp2);

      $reference = getRamdomText(15);

      $identifier = getRamdomText(15);

      Souscription::create([
        'date_souscription' => Date('Y-m-d'),
        'validite' => $validite,
        'prix' => 15000,
        'facture' => $reference,
        'reference' => $reference,
        'expiration' => $dateExpiration,
        'user_id' => $user->id,
        'type' => 2
      ]);

      $souscription = Souscription::where(['reference' => $reference])->first();

      $args['status'] = true;

      if ($user->indicatif=="+228") {
        PaiementSouscription::create([
          'identifier' => $identifier,
          'tx_reference' => "",
          'amount' => 15000,
          'souscription_id' => $souscription->id,
          'type'=>1
        ]);
        $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=15000&description=Souscription Compte Chauffeur&identifier='. $identifier;

      }elseif ($user->indicatif=="+229") {

        $transaction = payFedapaySouscription(getUserEmail($user->id), getUserFirstName($user->id), getUserLastName($user->id), 15000, "Souscription Compte Chauffeur", $user->telephone);

        $urlPaiement = $transaction['url'];
        PaiementSouscription::create([
          'identifier' => $identifier,
          'tx_reference' => "",
          'amount' => 15000,
          'souscription_id' => $souscription->id,
          'type'=>2,
          'token'=>$transaction['token']
        ]);
      }
      $args['url_paiement'] = $urlPaiement;
    }
  } catch (\Exception $e) {
    $args['error'] = true;
    $args['status'] = false;
    $args['error_message'] = $e->errorInfo;
    $args['message'] = "Erreur lors de l'enregistrement de vos informations";
  }

  return response()->json($args, 200);
}

public function paySouscription(Request $request,$idSouscription)
{
  $args = array();
  $args['error'] = false;
  try {

    $id = $request->id;
    $user = User::where(['id' => $id])->first();
    $souscription = Souscription::where(['id' => $idSouscription])->first();

    $identifier = getRamdomText(15);

    $paiementSouscription = PaiementSouscription::where(['souscription_id' => $souscription->id])->first();

    if ($paiementSouscription == null) {
      $paiementSouscription = new PaiementSouscription();
      $paiementSouscription->amount = 15000;
      $paiementSouscription->souscription_id = $souscription->id;

      if ($user->indicatif=="+228") {
        $paiementSouscription->identifier = $identifier;
        $paiementSouscription->type = 1;
        $paiementSouscription->save();

        $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount='.$paiementSouscription->amount.'&description=Souscription Compte Chauffeur&identifier='. $identifier;

      }elseif ($user->indicatif=="+229") {

        $transaction = payFedapaySouscriptionMobile(getUserEmail($user->id), getUserFirstName($user->id), getUserLastName($user->id), $paiementSouscription->amount, "Souscription Compte Chauffeur", $user->telephone);

        session(['identifier' => $identifier]);

        $urlPaiement = $transaction['url'];

        $paiementSouscription->identifier = $identifier;
        $paiementSouscription->type = 2;
        $paiementSouscription->token = $transaction['token'];
        $paiementSouscription->save();
      }
    }else{
      if ($user->indicatif=="+228") {
        $paiementSouscription->identifier = $identifier;
        $paiementSouscription->save();

        $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount='.$paiementSouscription->amount.'&description=Souscription Compte Chauffeur&identifier='. $identifier;

      }elseif ($user->indicatif=="+229") {

        $transaction = payFedapaySouscriptionMobile(getUserEmail($user->id), getUserFirstName($user->id), getUserLastName($user->id), $paiementSouscription->amount, "Souscription Compte Chauffeur", $user->telephone);

        session(['identifier' => $identifier]);

        $urlPaiement = $transaction['url'];

        $paiementSouscription->identifier = $identifier;
        $paiementSouscription->token = $transaction['token'];
        $paiementSouscription->save();
      }
      $args['status'] = true;
      $args['url_paiement'] = $urlPaiement;
    }
  } catch (Exception $e) {
   $args['error'] = true;
   $args['status'] = false;
   $args['error_message'] = $e->errorInfo;
   $args['message'] = "Erreur lors de l'enregistrement de vos informations";
 }

 return response()->json($args, 200);
}

public function printTicketPDF(Request $request,$idReservation)
{

  $reservation = Reservation::where(['id' => $idReservation])->first();
  $sieges = ReservationSiege::where(['reservation_id' => $reservation->id])->get();
  $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($reservation->facture));
  $pdf    = PDF::setOptions([
    'images' => true
  ])->loadView('factures.ticket_reservation', compact('reservation','qrcode','sieges'))->setPaper('a4', 'portrait');
  return $pdf->download('ticket'.$reservation->facture.'.pdf');
}

public function finalizeOperation(Request $request)
{
  $args = array();
  $args['error'] = false;
  $user = User::where('id', '=', $request->id)->first();
  try {
    if ($user == null) {
      $args['error'] = true;
      $args['error_message'] = "Erreur survenue avec l'Id";
      $args['status'] = false;
      return response()->json($args, 200);
    }else{
      $typeDestination = $request->type_destination;
      if ($typeDestination == 1) {
        $destination = Destination::where(['id' => $request->destination_id])->first();
        if ($destination->user_id==$user->id ) {
          $args['status'] = false;
        }
        $totalPrice = intval($request->total_price);
        $nbrePlaces = $request->nbre_places;
        $dateDepart = $request->date_depart;

        $reference = getRamdomText(15);
        $code = getRamdomCode(4);
        $nbrePlacesRestantes = $destination->nbre_places_dispo - $nbrePlaces;

        Reservation::create([
          'date_reservation' => Date('Y-m-d'),
          'nbre_places' => $nbrePlaces,
          'date_depart' => $dateDepart,
          'prix_total' => $destination->prix_unitaire * $nbrePlaces,
          'prix_total_commission' => $totalPrice,
          'facture' => getFacturePrefix($user->indicatif) . $code,
          'reference' => $reference,
          'type_destination' => 1,
          'status_reservation' => 1,
          'destination_id' => $destination->id,
          'user_id' => $user->id
        ]);

        Notification::create([
          'titre' => "Nouvelle réservation",
          'contenu' => getUserNameById($user->id) . " a fait une réservation de ". $nbrePlaces ." places pour la destination " .$destination->ville_destination . " - " . $destination->pays_destination . ". Son numéro de Téléphone est " . $user->telephone,
          'user_id' => $destination->user->id,
          'avatar' => $user->avatar
        ]);

        Destination::where(['id' => $destination->id])->update([
          'nbre_places_dispo' => $nbrePlacesRestantes
        ]);
        $args['status'] = true;
        $args['result'] = 1;
      }else{

        $totalPrice = $request->total_price;
        $nbrePlaces = $request->nbre_places;
        $nbrePlaces = $request->nbre_places;
        $ligneId = $request->ligne_id;
        $dateDepart = $request->date_depart;

        $destination = DestinationCompagnie::where(['id' => $request->destination_id])->first();
        
        if (getPlacesDispoCompagnieNew($destination->id,$dateDepart) < intval($nbrePlaces)) {
          $args['status'] = false;
        }
        $nbrePlacesRestantes = $destination->nbre_places_dispo - $nbrePlaces;

        
        if ($destination->user_id==$user->id ) {
          $args['status'] = false;
        }


        $reference = getRamdomText(15);
        $code = getRamdomCode(4);

        $prixUnitaire = 0;
        if ($ligneId>0) {
          $ligne = LigneDestination::where(['id' => $ligneId])->first();
          $prixUnitaire = $ligne->prix_unitaire;
        }else{
          $prixUnitaire = $destination->prix_unitaire;
        }


        Reservation::create([
          'date_reservation' => Date('Y-m-d'),
          'nbre_places' => $nbrePlaces,
          'date_depart' => $dateDepart,
          'prix_total' => $prixUnitaire * $nbrePlaces,
          'type_destination' => 2,
          'prix_total_commission' => $totalPrice,
          'facture' => getFacturePrefix($user->indicatif) . $code,
          'reference' => $reference,
          'ligne_destination_id' => $ligneId,
          'status_reservation' => 1,
          'destination_id' => $destination->id,
          'user_id' => $user->id
        ]);



        DestinationCompagnie::where(['id' => $destination->id])->update([
          'nbre_places_dispo' => $nbrePlacesRestantes
        ]);

        $reservation = Reservation::where(['reference' => $reference])->first();

        $identifier = getRamdomText(15);

        if ($user->indicatif=="+228") {
          Paiement::create([
            'identifier' => $identifier,
            'tx_reference' => "",
            'amount' => $totalPrice,
            'reservation_id' => $reservation->id,
            'type'=>1
          ]);
          $urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=' . $totalPrice  . '&description=Réservation de Ticket&identifier='. $identifier;
          
        }elseif ($user->indicatif=="+229") {
         $transaction = payFedapayMobile(getUserEmail($user->id), getUserFirstName($user->id), getUserLastName($user->id), $totalPrice, "Réservation de Ticket", $user->telephone);

         $urlPaiement = $transaction['url'];
         Paiement::create([
          'identifier' => $identifier,
          'tx_reference' => "",
          'amount' => $totalPrice,
          'reservation_id' => $reservation->id,
          'type'=>2,
          'token'=>$transaction['token']
        ]);
       }else{
          $user->indicatif="+229";
          $user->save();
          $transaction = payFedapayMobile(getUserEmail($user->id), getUserFirstName($user->id), getUserLastName($user->id), $totalPrice, "Réservation de Ticket", $user->telephone);

         $urlPaiement = $transaction['url'];
         Paiement::create([
          'identifier' => $identifier,
          'tx_reference' => "",
          'amount' => $totalPrice,
          'reservation_id' => $reservation->id,
          'type'=>2,
          'token'=>$transaction['token']
        ]);
       }
       $args['status'] = true;
       $args['url_paiement'] = $urlPaiement;
       $args['result'] = 0;
     }

     
   }
 } catch (\Exception $e) {
  $args['error'] = true;
  $args['status'] = false;
  $args['error_message'] = $e->getMessage();
  $args['message'] = "Erreur lors de l'enregistrement de vos informations";
}

return response()->json($args, 200);
}
}
