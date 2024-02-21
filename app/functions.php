<?php

use App\Models\User;
use App\Models\Voyageur;
use App\Models\Chauffeur;
use App\Models\Destination;
use App\Models\DestinationCompagnie;
use App\Models\Compagnie;
use App\Models\Admin;
use App\Models\News;
use App\Models\Reservation;
use App\Models\ReservationSiege;
use App\Models\ClientSubscribeCompagnie;
use App\Models\Client;
use App\Models\LigneDestination;
use App\Models\Souscription;
use Illuminate\Support\Facades\DB;
use \Mailjet\Resources;

if (!function_exists('getAdminAuth')) {
  function getAdminAuth()
  {
    $id = session('id');
    $user = Admin::where(['id' => $id])->first();
    return $user;
    
  }
}
if (!function_exists('getUserIsLogged')) {
  function getUserIsLogged()
  {
    $id = session('id');
    $isUser = session('is_user');
    if($id > 0 && $isUser > 0){
      return 1;
    }
    return 0;
    
  }
}

if (!function_exists('notifyAdministrator')) {
  function notifyAdministrator($message) {
   $values = '{"email_user": "Komarf28@gmail.com","operation_link": "https://cryptocorner-tg.com/admin"}';
                 //dd($values);
   $mj = new \Mailjet\Client('47dc514730e8a017675d211f607f18c5','b5ab92059cf19da5e2d9e6cbb3b841b1',true,['version' => 'v3.1']);
   $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "no-reply@cryptocorner-tg.com",
          'Name' => "CryptoCorner"
        ],
        'To' => [
          [
            'Email' => "Komarf28@gmail.com",
            'Name' => "Administrateur"
          ]
        ],
        'TemplateID' => 1474277,
        'TemplateLanguage' => true,
        'Subject' => $message,
        'Variables' => json_decode($values, true)
      ]
    ]
  ];

  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());
}
}
if (!function_exists('getUserAuth')) {
  function getUserAuth()
  {
    $id = session('id');
    $user = User::where(['id' => $id])->first();
    return $user;
  }
}
if (!function_exists('getUserAuthName')) {
  function getUserAuthName()
  {
    $id = session('id');
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->prenoms . " " . $voyageur->nom;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->prenoms . " " . $chauffeur->nom;
   }else{
    $compagnie = Compagnie::where(['user_id' => $user->id])->first();
    return $compagnie->denomination;
  }
}
}

if (!function_exists('getUserAuthLastName')) {
  function getUserAuthLastName()
  {
    $id = session('id');
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->nom;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->nom;
   }
 }
}

if (!function_exists('getUserAuthFirstName')) {
  function getUserAuthFirstName()
  {
    $id = session('id');
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->prenoms;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->prenoms;
   }
 }
}

if (!function_exists('getUserAuthEmail')) {
  function getUserAuthEmail()
  {
    $id = session('id');
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->email;
   }elseif($user->type_user == 2){
     return $user->pseudo . "@gmail.com";
   }
 }
}

if (!function_exists('getUserAuthTelephone')) {
  function getUserAuthTelephone()
  {
    $id = session('id');
    $user = User::where(['id' => $id])->first();
    return $user->telephone;
  }
}

if (!function_exists('getUserNameById')) {
  function getUserNameById($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->prenoms . " " . $voyageur->nom;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->prenoms . " " . $chauffeur->nom;
   }else{
    $compagnie = Compagnie::where(['user_id' => $user->id])->first();
    return $compagnie->denomination;
  }
}
}
if (!function_exists('getClientNameById')) {
  function getClientNameById($id)
  {
    $client = Client::where(['id' => $id])->first();
    return $client->prenoms . " " . $client->nom;
  }
}

if (!function_exists('getLigneById')) {
  function getLigneById($id)
  {
    $ligneDestination = LigneDestination::where(['id' => $id])->first();
    return $ligneDestination;
  }
}
if (!function_exists('getChauffeurStatusById')) {
  function getChauffeurStatusById($id)
  {
    $user = User::where(['id' => $id])->first();
    $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
    return $chauffeur->status;
  }
}


if (!function_exists('getCompagnieById')) {
  function getCompagnieById($id)
  {
    $compagnie = Compagnie::where(['user_id' => $id])->first();
    return $compagnie;
  }
}
if (!function_exists('getUserFirstName')) {
  function getUserFirstName($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->prenoms;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->prenoms;
   }
 }
}

if (!function_exists('getUserLastName')) {
  function getUserLastName($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->nom;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->nom;
   }
 }
}
if (!function_exists('getUserEmail')) {
  function getUserEmail($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->email;
   }elseif($user->type_user == 2){
     return $user->pseudo . "@gmail.com";
   }
 }
}
if (!function_exists('getUserImmatriculation')) {
  function getUserImmatriculation($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->nom;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->immatriculation;
   }
 }
}
if (!function_exists('getUserTypeVehicule')) {
  function getUserTypeVehicule($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur->nom;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur->type_vehicule;
   }
 }
}

if (!function_exists('getNbreStats')) {
  function getNbreStats($type)
  {
    if ($type <= 3) {
      $users = User::where(['type_user'=>$type,'status'=>1])->get();
      return $users->count();
    }elseif ($type == 4){
      $countSouscription = 0;
      $souscriptions = Souscription::where(['type' => 2])->get();
      foreach ($souscriptions as $souscription) {
        if ($souscription->paiements->count() > 0) {
         if ($souscription->paiements[0]->type ==1) {
          if (checkPayment($souscription->paiements[0]->identifier) == 0) {
           $countSouscription += 1;
         }
       }else if($souscription->paiements[0]->type ==2){
        if (checkPaymentFedapay($souscription->paiements[0]->identifier) == 0) {
         $countSouscription += 1;
       }elseif ($souscription->paiements[0]->status == 1) {
        $countSouscription += 1;
      }
    }
  }
}
return $countSouscription;
}elseif ($type == 5){
  $data=  DB::table('reservations')
  ->select(DB::raw('DATE(date_depart) as date'))
  ->orderBy('date','DESC')
  ->groupBy('date')
  ->get()
  ->count();
  return $data;

}elseif ($type == 6){
 $data=  DB::table('reservations')
 ->select(DB::raw('DATE(date_depart) as date'))
 ->whereMonth('date_depart', '=', date('m'))
 ->orderBy('date','DESC')
 ->groupBy('date')
 ->get()
 ->count();
 return $data;
}elseif ($type == 7){
  $data=  DB::table('reservations')
  ->select(DB::raw('DATE(date_depart) as date'))
  ->where('type_destination', '=', 1)
  ->orderBy('date','DESC')
  ->groupBy('date')
  ->get()
  ->count();
  return $data;

}elseif ($type == 8){
 $data=  DB::table('reservations')
 ->select(DB::raw('DATE(date_depart) as date'))
 ->whereMonth('date_depart', '=', date('m'))
 ->where('type_destination', '=', 1)
 ->orderBy('date','DESC')
 ->groupBy('date')
 ->get()
 ->count();
 return $data;
}
elseif ($type == 9){
  $data=  DB::table('reservations')
  ->select(DB::raw('DATE(date_depart) as date'))
  ->where('type_destination', '=', 2)
  ->orderBy('date','DESC')
  ->groupBy('date')
  ->get()
  ->count();
  return $data;

}elseif ($type == 10){
 $data=  DB::table('reservations')
 ->select(DB::raw('DATE(date_depart) as date'))
 ->whereMonth('date_depart', '=', date('m'))
 ->where('type_destination', '=', 2)
 ->orderBy('date','DESC')
 ->groupBy('date')
 ->get()
 ->count();
 return $data;
}
}
}

if (!function_exists('getNbreReservations')) {
  function getNbreReservations($destinationId,$dateDepart)
  {
    $id = session('id');
    $reservations = DB::TABLE('reservations')->distinct()
    ->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
    ->leftJoin('paiements','paiements.reservation_id','=','reservations.id')
    ->whereRaw(
      "(destinations_compagnie.user_id = ?)", 
      [$id]
    )->whereRaw(
      "(reservations.date_depart = ?)", 
      [$dateDepart]
    )->whereRaw(
      "(destinations_compagnie.id = ?)", 
      [$destinationId]
    )
    ->select('reservations.id as id','reservations.date_reservation  as date_reservation','reservations.nbre_places  as nbre_places','reservations.prix_total_commission  as prix_total_commission','reservations.status_reservation  as status_reservation','reservations.reference  as reference','reservations.facture  as facture','reservations.date_depart  as date_depart','reservations.user_id  as user_id','paiements.identifier  as identifier','paiements.status  as status','paiements.type  as type','reservations.status_siege  as status_siege')
    ->orderBy('reservations.date_reservation','DESC')
    ->get();
    $count = 0;
    foreach ($reservations as $reservation) {
     if($reservation->type == 1){
      if (checkPayment($reservation->identifier) == 0) {
        $count += 1;
      }
    }else{
      if ($reservation->status == 1) {
       $count += 1;
     }
   }
 }
 $reservationsClients = DB::TABLE('reservations_clients')->distinct()
 ->join('destinations_compagnie','destinations_compagnie.id','=','reservations_clients.destination_id')
 ->whereRaw(
  "(destinations_compagnie.user_id = ?)", 
  [$id]
)->whereRaw(
  "(reservations_clients.date_depart = ?)", 
  [$dateDepart]
)->whereRaw(
  "(destinations_compagnie.id = ?)", 
  [$destinationId]
)
->select('reservations_clients.id as id','reservations_clients.date_reservation  as date_reservation')
->orderBy('reservations_clients.date_reservation','DESC')
->get();
$count += $reservationsClients->count();
return $count;
}
}


if (!function_exists('getNbreReservationsAll')) {
  function getNbreReservationsAll($destinationId,$dateDepart)
  {
    $id = session('id');
    $reservations = DB::TABLE('reservations')->distinct()
    ->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
    ->leftJoin('paiements','paiements.reservation_id','=','reservations.id')->whereRaw(
      "(reservations.date_depart = ?)", 
      [$dateDepart]
    )->whereRaw(
      "(destinations_compagnie.id = ?)", 
      [$destinationId]
    )
    ->select('reservations.id as id','reservations.date_reservation  as date_reservation','reservations.nbre_places  as nbre_places','reservations.prix_total_commission  as prix_total_commission','reservations.status_reservation  as status_reservation','reservations.reference  as reference','reservations.facture  as facture','reservations.date_depart  as date_depart','reservations.user_id  as user_id','paiements.identifier  as identifier','paiements.status  as status','paiements.type  as type','reservations.status_siege  as status_siege')
    ->orderBy('reservations.date_reservation','DESC')
    ->get();
    $count = 0;
    foreach ($reservations as $reservation) {
     if($reservation->type == 1){
      if (checkPayment($reservation->identifier) == 0) {
        $count += 1;
      }
    }else{
      if ($reservation->status == 1) {
       $count += 1;
     }
   }
 }
/*
 $reservationsClients = DB::TABLE('reservations_clients')->distinct()
 ->join('destinations_compagnie','destinations_compagnie.id','=','reservations_clients.destination_id')
 ->whereRaw(
  "(destinations_compagnie.user_id = ?)", 
  [$id]
)->whereRaw(
  "(reservations_clients.date_depart = ?)", 
  [$dateDepart]
)->whereRaw(
  "(destinations_compagnie.id = ?)", 
  [$destinationId]
)
->select('reservations_clients.id as id','reservations_clients.date_reservation  as date_reservation')
->orderBy('reservations_clients.date_reservation','DESC')
->get();
$count += $reservationsClients->count();*/

return $count;
}
}

if (!function_exists('getDestination')) {
  function getDestination($idReservation)
  {
    $reservation = Reservation::where(['id' => $idReservation])->first();
    if($reservation->type_destination == 1){
     $destination = Destination::where(['id' => $reservation->destination_id])->first();
     return $destination;
   }else{
     $destination = DestinationCompagnie::where(['id' => $reservation->destination_id])->first();
     return $destination;
   }
 }
}
if (!function_exists('checkIfSubscribes')) {
  function checkIfSubscribes($idCompagnie)
  {
    $id = session('id');
    $search = ClientSubscribeCompagnie::where(['client_id' => $id,'compagnie_id' => $idCompagnie])->get();
    return $search->count();
  }
}
if (!function_exists('checkIfSubscribes2')) {
  function checkIfSubscribes2($idCompagnie)
  {
    $id = session('id');
    $search = ClientSubscribeCompagnie::where(['client_id' => $id,'compagnie_id' => $idCompagnie])->get();
    return $search->count();
  }
}
if (!function_exists('formatToPrice')) {
  function formatToPrice($montant)
  {
    return number_format($montant ,null,"",".");
  }
}
if (!function_exists('getNbreAbonnes')) {
  function getNbreAbonnes($idCompagnie)
  {
    $id = session('id');
    $search = ClientSubscribeCompagnie::where(['compagnie_id' => $idCompagnie])->get();
    return $search->count();
  }
}
if (!function_exists('getJour')) {
  function getJour($day)
  {
    $value ="";
    switch ($day) {
      case 'Mon':
      $value ="Lundi";
      break;
      case 'Tue':
      $value ="Mardi";
      break;
      case 'Wed':
      $value ="Mercredi";
      break;
      case 'Thu':
      $value ="Jeudi";
      break;
      case 'Fri':
      $value ="Vendredi";
      break;
      case 'Sat':
      $value ="Samedi";
      break;
      case 'Sun':
      $value ="Dimanche";
      break;
    }
    return $value;
  }
}
if (!function_exists('getUserById')) {
  function getUserById($id)
  {
    $user = User::where(['id' => $id])->first();
    return $user;

  }
}
if (!function_exists('getVoyageurById')) {
  function getVoyageurById($id)
  {
    $user = User::where(['id' => $id])->first();
    if($user->type_user == 1){
     $voyageur = Voyageur::where(['user_id' => $user->id])->first();
     return $voyageur;
   }elseif($user->type_user == 2){
     $chauffeur = Chauffeur::where(['user_id' => $user->id])->first();
     return $chauffeur;
   }

 }
}
if (!function_exists('getUserAuthChauffeur')) {
  function getUserAuthChauffeur()
  {
    $id = session('id');
    $chauffeur = Chauffeur::where(['user_id' => $id])->first();
    return $chauffeur;
  }
}

if (!function_exists('getUserAuthVoyageur')) {
  function getUserAuthVoyageur()
  {
    $id = session('id');
    $voyageur = Voyageur::where(['user_id' => $id])->first();
    return $voyageur;
  }
}
if (!function_exists('getUserAuthImmatriculation')) {
  function getUserAuthImmatriculation()
  {
    $id = session('id');
    $chauffeur = Chauffeur::where(['user_id' => $id])->first();
    return $chauffeur->immatriculation;
    
  }
}
if (!function_exists('getUserAuthTypeVehicule')) {
  function getUserAuthTypeVehicule()
  {
    $id = session('id');
    $chauffeur = Chauffeur::where(['user_id' => $id])->first();
    return $chauffeur->type_vehicule;
    
  }
}
if (!function_exists('getAllChauffeurSignalisation')) {
  function getAllChauffeurSignalisation($id)
  {
    $destinations = Destination::where(['user_id' => $id])->orderBy('created_at','DESC')->get();
    $count = 0;
    foreach ($destinations as $destination) {
      $reservations = Reservation::where(['destination_id' => $destination->id])->get();
      foreach ($reservations as $reservation) {
        if ($reservation->is_signal == 1) {
         $count += 1;
       }
     }
   }

   return $count;
 }
}
if (!function_exists('getAllChauffeurDepartCount')) {
  function getAllChauffeurDepartCount($id)
  {
    $count = Destination::where(['user_id' => $id])->get()->count();
    return $count;
  }
}
if (!function_exists('getAllVoyageurSignalisation')) {
  function getAllVoyageurSignalisation($id)
  {
    $count = 0;
    $reservations = Reservation::where(['user_id' => $id])->get();
    foreach ($reservations as $reservation) {
      if ($reservation->is_signal == 1) {
       $count += 1;
     }
   }

   return $count;
 }
}
if (!function_exists('getAllVoyageurDepartCount')) {
  function getAllVoyageurDepartCount($id)
  {
    $count = Reservation::where(['user_id' => $id])->get()->count();
    return $count;
  }
}
if (!function_exists('getAllVoyageurDepartCompagnieCount')) {
  function getAllVoyageurDepartCompagnieCount($idUser, $idCompagnie)
  {
    $count = 0; 
    $reservations = Reservation::where(['user_id' => $idUser,'type_destination'=>2])->get();
    foreach ($reservations as $reservation) {
      if ($reservation->destinationCompagnie->user->id == $idCompagnie) {
       $count += 1;
     }
   }
   return $count;
 }
}
if (!function_exists('getAllChauffeurSignalisationList')) {
  function getAllChauffeurSignalisationList($id)
  {
   $reservations = DB::TABLE('reservations')->distinct()
   ->join('destinations','destinations.id','=','reservations.destination_id')
   ->whereRaw(
    "(destinations.user_id = ?)", 
    [$id]
  )->whereRaw(
    "(reservations.is_signal = ?)", 
    [1]
  )->select('reservations.id as id','reservations.created_at  as created_at','reservations.motif  as motif')
  ->orderBy('reservations.created_at','DESC')
  ->get();
  return $reservations;
}
}
if (!function_exists('getAllVoyageurSignalisationList')) {
  function getAllVoyageurSignalisationList($id)
  {
   $reservations = DB::TABLE('reservations')->distinct()
   ->join('destinations','destinations.id','=','reservations.destination_id')
   ->whereRaw(
    "(reservations.user_id = ?)", 
    [$id]
  )->whereRaw(
    "(reservations.is_signal = ?)", 
    [1]
  )->select('reservations.id as id','reservations.created_at  as created_at','reservations.motif  as motif')
  ->orderBy('reservations.created_at','DESC')
  ->get();
  return $reservations;
}
}
if (!function_exists('getAllChauffeurDestination')) {
  function getAllChauffeurDestination()
  {
    $id = session('id');
    $destinations = Destination::where(['user_id' => $id])->orderBy('created_at','DESC')->get();
    return $destinations;
    
  }
}
if (!function_exists('getAllParticulierReservation')) {
  function getAllParticulierReservation()
  {
    $id = session('id');
    $reservations = Reservation::where(['user_id' => $id])->where('status_reservation', '!=', 99)->orderBy('created_at','DESC')->get();
    return $reservations;
    
  }
}
if (!function_exists('getRamdomText')) {
  function getRamdomText($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }
    return $randomString;
  }
}
if (!function_exists('getRamdomCode')) {
  function getRamdomCode($n) {
    $characters = '0123456789';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }
    return $randomString;
  }
}
if (!function_exists('getNbreReservationByIdSession')) {
  function getNbreReservationByIdSession()
  {
    $id = session('id');
    $reservations = Reservation::where(['user_id' =>$id  ])->get();
    return $reservations->count();
  }
}
if (!function_exists('getNbreReservationByIdSessionMonth')) {
  function getNbreReservationByIdSessionMonth()
  {
    $currentMonth = date('m');
    $id = session('id');
    $data = DB::table("reservations")
    ->where(['user_id' =>$id  ])
    ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
    ->get();
    return $data->count();
  }
}


if (!function_exists('getNbreVoyageByIdSession')) {
  function getNbreVoyageByIdSession()
  {
    $id = session('id');
    $destinations = Destination::where(['user_id' => $id ])->get();
    return $destinations->count();
  }
}
if (!function_exists('getNbreVoyageByIdSessionMonth')) {
  function getNbreVoyageByIdSessionMonth()
  {
    $currentMonth = date('m');
    $id = session('id');
    $data = DB::table("destinations")
    ->where(['user_id' =>$id  ])
    ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
    ->get();
    return $data->count();
  }
}
if (!function_exists('sendSms')) {
  function sendSms($telephone, $code)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http-api.d7networks.com/send?to=".$telephone."&from=HTW&coding=1&username=wwue1335&password=NzZ0dkmg&dlr=yes&dlr-url=https://4ba60af1.ngrok.io/receive&dlr-level=3&dlr-method=POST&content=Votre%20code%20de%20Confirmation%20HappyTravelWorld%20est:%20". $code,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }
}

if (!function_exists('sendSmsAmazon')) {
  function sendSmsAmazon($telephone, $code)
  {
    $params = array(
      'credentials' => array(
        'key' => 'AKIAZCEUNS6HT4U2LQAL',
        'secret' => 'Nbc7zIXX/ivyYR2XN4zC3louok/dxVjtcGYrs2S9',
      ),
    'region' => 'us-east-1', // < your aws from SNS Topic region
    'version' => 'latest'
  );
    $sns = new \Aws\Sns\SnsClient($params);

    $args = array(
      "MessageAttributes" => [
                // You can put your senderId here. but first you have to verify the senderid by customer support of AWS then you can use your senderId.
                // If you don't have senderId then you can comment senderId 
                // 'AWS.SNS.SMS.SenderID' => [
                //     'DataType' => 'String',
                //     'StringValue' => ''
                // ],
        'AWS.SNS.SMS.SMSType' => [
          'DataType' => 'String',
          'StringValue' => 'Transactional'
        ]
      ],
      "Message" => "Votre code de Confirmation HappyTravelWorld est: ". $code,
    "PhoneNumber" => $telephone   // Provide phone number with country code
  );


    $result = $sns->publish($args);
    return $result;
  }
}

if (!function_exists('sendSmsClickSend')) {
  function sendSmsClickSend($telephone, $code)
  {
        // Configure HTTP basic authorization: BasicAuth
    $config = \ClickSend\Configuration::getDefaultConfiguration()
    ->setUsername('farouk228')
    ->setPassword('FD7794A8-20E0-FA9F-D45D-0428AF3B0664');

    $apiInstance = new \ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);
    $msg = new \ClickSend\Model\SmsMessage();
    $msg->setBody("Votre code de Confirmation HappyTravelWorld est: ". $code); 
    $msg->setTo($telephone);
    $msg->setFrom("HTW");
    $msg->setSource("sdk");

// \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
    $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
    $sms_messages->setMessages([$msg]);

    try {
      $result = $apiInstance->smsSendPost($sms_messages);
      //print_r($result);
    } catch (Exception $e) {
      echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
    }


    return $result;
  }
}

if (!function_exists('sendSmsClickSendPassword')) {
  function sendSmsClickSendPassword($telephone, $code)
  {
        // Configure HTTP basic authorization: BasicAuth
    $config = \ClickSend\Configuration::getDefaultConfiguration()
    ->setUsername('farouk228')
    ->setPassword('FD7794A8-20E0-FA9F-D45D-0428AF3B0664');

    $apiInstance = new \ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);
    $msg = new \ClickSend\Model\SmsMessage();
    $msg->setBody("Votre nouveau mot de passe HappyTravelWorld est: ". $code); 
    $msg->setTo($telephone);
    $msg->setFrom("HTW");
    $msg->setSource("sdk");

// \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
    $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
    $sms_messages->setMessages([$msg]);

    try {
      $result = $apiInstance->smsSendPost($sms_messages);
      //print_r($result);
    } catch (Exception $e) {
      echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
    }


    return $result;
  }
}

if (!function_exists('checkStatusReservation')) {
  function checkStatusReservation($id)
  {
    $reservation = Reservation::where(['id' => $id])->first();
    if ($reservation->paiement->count() > 0) {
     if ($reservation->paiement[0]->type ==1) {
      if (checkPayment($reservation->paiement[0]->identifier) == 0) {
        return 1;
      }
    }else if($reservation->paiement[0]->type ==2){
      if (checkPaymentFedapay($reservation->paiement[0]->identifier) == 0) {
       return 1;
     }elseif ($reservation->paiement[0]->status == 1) {
      return 1;
    }
  }
}
return 0;
}
}
if (!function_exists('checkStatusSouscription')) {
  function checkStatusSouscription($id)
  {
    $souscription = Souscription::where(['id' => $id])->first();
    if ($souscription->paiements->count() > 0) {
     if ($souscription->paiements[0]->type ==1) {
      if (checkPayment($souscription->paiements[0]->identifier) == 0) {
        return 1;
      }
    }else if($souscription->paiements[0]->type ==2){
      if (checkPaymentFedapay($souscription->paiements[0]->identifier) == 0) {
       return 1;
     }elseif ($souscription->paiements[0]->status == 1) {
      return 1;
    }
  }
}
return 0;
}
}


if (!function_exists('formatDateSimple')) {
  function formatDateSimple($date)
  {
    $elements = explode("-", $date);
    $dateR = $elements[2] . "-" . $elements[1] . "-" . $elements[0];
    return $dateR;
  }
}
if (!function_exists('getFullDate')) {
  function getFullDate($date)
  {
    $day =  getDayOfWeek($date);
    $month =  getMonthOfYear($date);
    $elements = explode("-", $date);
    $dateR = $day .", Le " . $elements[2] . " " . $month . " " . $elements[0];
    return $dateR;
  }
}
if (!function_exists('getDayOfWeek')) {
  function getDayOfWeek($date)
  {
    $dayofweek = date('w', strtotime($date));
    $arrayDay = array(
     0 => "Dimanche",
     1 => "Lundi",
     2 => "Mardi",
     3 => "Mercredi",
     4 => "Jeudi",
     5 => "Vendredi",
     6 => "Samedi",
   );
    $day =  $arrayDay[$dayofweek];
    return $day;
  }
}
if (!function_exists('getMonthOfYear')) {
  function getMonthOfYear($date)
  {
    $monthOfYear = intval(date('m', strtotime($date)));
    $arrayMonth = array(
     1 => "Janvier",
     2 => "Février",
     3 => "Mars",
     4 => "Avril",
     5 => "Mai",
     6 => "Juin",
     7 => "Juillet",
     8 => "Aôut",
     9 => "Septembre",
     10 => "Octobre",
     11 => "Novembre",
     12 => "Décembre"
   );
    $month =  $arrayMonth[$monthOfYear];
    return $month;
  }
}

if (!function_exists('formatDate')) {
  function formatDate($date)
  {
    $formatDates = explode("T", $date);
    $elements = explode(" ", $formatDates[0]);
    $elements2 = explode("-", $elements[0]);
    $date = $elements2[2] . "-" . $elements2[1] . "-" . $elements2[0] . " " .$elements[1];
    return $date;
  }
}

if (!function_exists('formatDate2')) {
  function formatDate2($date)
  {
    $formatDates = explode("T", $date);
    $elements = explode(" ", $formatDates[0]);
    $elements2 = explode("-", $elements[0]);
    $date = $elements2[0] . "-" . $elements2[1] . "-" . $elements2[2] . " " .$elements[1];
    return $date;
  }
}

if (!function_exists('getAllClientsCompagnies')) {
  function getAllClientsCompagnies()
  {
    $id = session('id');
    $search = Client::where(['compagnie_id' => $id])->get();
    return $search->count();
  }
}
if (!function_exists('getAllAbonnesCompagnies')) {
  function getAllAbonnesCompagnies()
  {
    $id = session('id');
    $compagnie = Compagnie::where(['user_id' => $id])->first();
    $abonnes = ClientSubscribeCompagnie::where(['compagnie_id' =>$compagnie->id])->get();
    return $abonnes->count();
  }
}
if (!function_exists('getAllReservationsCompagnies')) {
  function getAllReservationsCompagnies()
  {
    $id = session('id');
    $compagnie = Compagnie::where(['user_id' => $id])->first();
    $count = 0;
    foreach ($compagnie->destinations as $destination) {
           //$count += $destination->reservations->count();
     foreach ($destination->reservations as $reservation) {
      if($reservation->paiement->count() > 0){
       if ($reservation->paiement[0]->type ==1) {
        if (checkPayment($reservation->paiement[0]->identifier) == 0) {
         $count += $reservation->nbre_places;
       }
     }else if($reservation->paiement[0]->type ==2){
      if (checkPaymentFedapay($reservation->paiement[0]->identifier) == 0) {
       $count += $reservation->nbre_places;
     }
   }
 }
}
}
return $count;
}
}
if (!function_exists('getPlacesDispoCompagnie')) {
  function getPlacesDispoCompagnie($destinationId)
  {
    $id = session('id');
    $destination = DestinationCompagnie::where(['id' => $destinationId])->first();
    $count = 0;
    foreach ($destination->reservations as $reservation) {
      if($reservation->paiement->count() > 0){
        if ($reservation->paiement[0]->type ==1) {
          if (checkPayment($reservation->paiement[0]->identifier) == 0) {
           $count += $reservation->nbre_places;
         }
       }else if($reservation->paiement[0]->type ==2){
        if (checkPaymentFedapay($reservation->paiement[0]->identifier) == 0) {
         $count += $reservation->nbre_places;
       }
     }

   }
 }
 foreach ($destination->reservationsClient as $reservation) {
   $count += $reservation->nbre_places;
 }
 return $destination->nbre_places - $count;
}
}
if (!function_exists('getPlacesDispoCompagnieNew')) {
  function getPlacesDispoCompagnieNew($destinationId,$dateReservation)
  {
    $id = session('id');
    $destination = DestinationCompagnie::where(['id' => $destinationId])->first();
    $count = 0;
    foreach ($destination->reservations as $reservation) {
      if ($reservation->date_depart == $dateReservation) {
        if($reservation->paiement->count() > 0){
          if ($reservation->paiement[0]->type ==1) {
            if (checkPayment($reservation->paiement[0]->identifier) == 0) {
             $count += $reservation->nbre_places;
           }
         }else if($reservation->paiement[0]->type ==2){
          if (checkPaymentFedapay($reservation->paiement[0]->identifier) == 0) {
           $count += $reservation->nbre_places;
         }
       }
     }
   }
 }
 foreach ($destination->reservationsClient as $reservation) {
  if ($reservation->date_depart == $dateReservation) {
   $count += $reservation->nbre_places;
 }
}
return $destination->nbre_places - $count;
}
}
if (!function_exists('getPlacesDispo')) {
  function getPlacesDispo($destinationId)
  {
    $id = session('id');
    $destination = Destination::where(['id' => $destinationId])->first();
    $count = 0;
    $reservations = Reservation::where(['destination_id' => $destinationId,'type_destination' => 1])->get();
    foreach ($reservations as $reservation) {
      if ($reservation->status_reservation == 1) {
       $count += $reservation->nbre_places;
     }
     if ($reservation->status_reservation == 0 && $reservation->nbre_places_annules < $reservation->nbre_places) {
       $count += ($reservation->nbre_places - $reservation->nbre_places_annules);
     }
   }
   return $destination->nbre_places - $count;
 }
}
if (!function_exists('getAllDepartsCompagnies')) {
  function getAllDepartsCompagnies()
  {
    $id = session('id');
    $search = DestinationCompagnie::where(['user_id' => $id,'status' => 1])->get();
    return $search->count();
  }
}
if (!function_exists('getAllNewsCompagnies')) {
  function getAllNewsCompagnies()
  {
    $id = session('id');
    $search = News::where(['user_id' => $id])->get();
    return $search->count();
  }
}
if (!function_exists('compareToCurrentTime')) {
  function compareToCurrentTime($date)
  {
    $timestamp1 = strtotime($date);
    $timestamp2 = strtotime(Date('Y-m-d H:i:s'));
    $diff = $timestamp2 - $timestamp1;
    return $diff;
  }
}
if (!function_exists('getFacturePrefix')) {
  function getFacturePrefix($indicatif)
  {
    $value ="";
    switch ($indicatif) {
      case '+228':
      $value ="TG";
      break;
      case '+229':
      $value ="BJ";
      break;
      case '+233':
      $value ="GH";
      case '+223':
      $value ="ML";
      break;
      case '+225':
      $value ="CIV";
      break;
      case '+227':
      $value ="NG";
      break;
      case '+234':
      $value ="NIG";
      break;
      case '+226':
      $value ="BF";
      break;
      case '+237':
      $value ="CMR";
      break;
      case '+241':
      $value ="GB";
      break;
    }
    return $value;
  }
}
if (!function_exists('getSieges')) {
  function getSieges($idReservation)
  {
    $sieges = ReservationSiege::where(['reservation_id' => $idReservation])->get();
    return $sieges;
    
  }
}
if (!function_exists('payFedapay')) {
  function payFedapay($email, $firstName, $lastName, $price, $description, $telephone)
  {
   \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

   /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');

    $transaction = \FedaPay\Transaction::create(array(
      "description" => $description,
      "amount" => $price,
      "currency" => ["iso" => "XOF"],
      "callback_url" => "https://happytravel-world.com/callback-fedapay",
      "customer" => [
        "firstname" => $firstName,
        "lastname" => $lastName,
        "email" => $email,
        "phone" => $telephone
      ]
    ));
    $token = $transaction->generateToken();
    return $token;   
  }
}

if (!function_exists('payFedapayMobile')) {
  function payFedapayMobile($email, $firstName, $lastName, $price, $description, $telephone)
  {
   \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

   /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');

    $transaction = \FedaPay\Transaction::create(array(
      "description" => $description,
      "amount" => $price,
      "currency" => ["iso" => "XOF"],
      "callback_url" => "https://happytravel-world.com/callback-fedapay-mobile",
      "customer" => [
        "firstname" => $firstName,
        "lastname" => $lastName,
        "email" => $email,
        "phone" => $telephone
      ]
    ));
    $token = $transaction->generateToken();
    return $token;   
  }
}
if (!function_exists('sendNotification')) {
  function sendNotification($title, $body,$token)
  {
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $notification = [
      'title' => $title,
      'body' => $body,
      'sound' => true
    ];

    $extraNotificationData = ["message" => $notification,
    "moredata" => 'dd',
    "title" => $title,
    "title" => $body,
    "imageUrl" => "https://www.happytravel-world.com/logo.png"
  ];

  $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => '/topics/alertes_' . $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
          ];

          $headers = [
            'Authorization: key=AAAADKqdDS4:APA91bGZ3eZHCWbngYyA-BD3vIErfAirS1k1j9y6Wb-DYobUMUrE0vMSZ7UyMWC4KDlKdkcO7hPz0R3FuSDO-67GGbSdJf9TMCcLYWFSNOmq0llrb1eWGBi_Hs9j--lgdtOR7QFSfupf',
            'Content-Type: application/json'
          ];


          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $fcmUrl);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
          $result = curl_exec($ch);
          curl_close($ch);

        //return true;
        }
      }

      if (!function_exists('payFedapaySouscription')) {
        function payFedapaySouscription($email, $firstName, $lastName, $price, $description, $telephone)
        {
         \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

         /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');

    $transaction = \FedaPay\Transaction::create(array(
      "description" => $description,
      "amount" => $price,
      "currency" => ["iso" => "XOF"],
      "callback_url" => "https://happytravel-world.com/callback-fedapay-souscription",
      "customer" => [
        "firstname" => $firstName,
        "lastname" => $lastName,
        "email" => $email,
        "phone" => $telephone
      ]
    ));
    $token = $transaction->generateToken();
    return $token;   
  }
}

if (!function_exists('payFedapaySouscriptionMobile')) {
        function payFedapaySouscriptionMobile($email, $firstName, $lastName, $price, $description, $telephone)
        {
         \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

         /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');

    $transaction = \FedaPay\Transaction::create(array(
      "description" => $description,
      "amount" => $price,
      "currency" => ["iso" => "XOF"],
      "callback_url" => "https://happytravel-world.com/callback-fedapay-souscription-mobile",
      "customer" => [
        "firstname" => $firstName,
        "lastname" => $lastName,
        "email" => $email,
        "phone" => $telephone
      ]
    ));
    $token = $transaction->generateToken();
    return $token;   
  }
}

function checkPaymentFedapay($identifier)
{
  \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

  /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');
    
    try {
      $transaction = \FedaPay\Transaction::retrieve($identifier);
    } catch (Exception $e) {
      return  -1;
    }
    
    if($transaction['status'] == 'transferred'){
      return  0;
    }else{
      return  -1;
    }
  }
  function checkPayment($identifier)
  {
  //The URL that we want to send a PUT request to.
    $url = 'https://paygateglobal.com/api/v2/status';
    $params = array(
      'auth_token' => '8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4',
      'identifier' => $identifier
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

  // This should be the default Content-type for POST requests
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));

    $result = curl_exec($ch);
    if(curl_errno($ch) !== 0) {
      error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
    }

    curl_close($ch);
    if($result == '{"error_code":403,"error_message":"Transaction non trouvée."}'){
      return -1;
    }
    else if($result == null){
      return -1;
    }else{
      $manage = json_decode($result, true);
      return $manage["status"];
    }
  }


  ?>
