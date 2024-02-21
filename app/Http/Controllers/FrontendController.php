<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Voyageur;
use App\Models\Destination;
use App\Models\DestinationCompagnie;
use App\Models\LigneDestination;
use App\Models\Compagnie;
use App\Models\ClientSubscribeCompagnie;
use App\Models\Reservation;
use App\Models\Chauffeur;
use App\Models\Notification;
use App\Models\Paiement;
use App\Models\PaiementSouscription;
use PDF;
use \Mailjet\Resources;
use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;
//use \Fedapay;

class FrontendController extends Controller
{
  public function index(Request $request)
  {
    return view('index');
  }
  public function testMail(Request $request)
  {
    return notifyAdministrator('Hello'); 
  }
  public function testNotification(Request $request)
  {
    return sendNotification('Hello','Premier test de Notification','1234567890ABCD'); 
  }
  public function testPaygate(Request $request)
  {

    //$value = payFedapay("omarharden228@gmail.com", "Omar Farouk", "KOUGBADA", 2000, "Achat de Crédit", "+22893554740");
    return checkPayment('6sZV7xS8WYN2Urn');
  }
  public function testSms(Request $request)
  {
    var_dump(sendSmsAmazon("+22893554740","0912")); // You can check the response
  }
  public function testFedapay(Request $request)
  {

    //$value = payFedapay("omarharden228@gmail.com", "Omar Farouk", "KOUGBADA", 2000, "Achat de Crédit", "+22893554740");
    $status = checkPaymentFedapay('306162');

    //return redirect($value['url']);
    return $status;
  }
  public function testClickSend(Request $request)
  {

    var_dump(sendSmsClickSend("+22899179270","0912")); // You can check the response
  }
  public function callbackFedapay(Request $request)
  { 
    $id = request('id');
    //$id = 454478;
    //$status = request('status');

    \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

    /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');
    
    $transaction = \FedaPay\Transaction::retrieve($id);

   // $id = session('id');
    //$type_paiement = session('type_paiement');
    $amount = $transaction['amount'];

    //dd($transaction);

    $paiement = Paiement::where(['amount' => $amount])->orderBy('id','DESC')->first();
    
    if ($transaction['status'] == 'transferred' or ($transaction['status'] == 'approved')) {
      $paiement->status = 1;
    }

    $paiement->identifier = $transaction['id'];
    $paiement->tx_reference = $transaction['reference'];
    $paiement->save();
    
    return redirect('/user/dashboard');
  }
  public function callbackFedapaySouscription(Request $request)
  { 
    $id = request('id');
    //$id = 454478;
    //$status = request('status');

    \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

    /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');
    
    $transaction = \FedaPay\Transaction::retrieve($id);

   // $id = session('id');
    //$type_paiement = session('type_paiement');
    $amount = $transaction['amount'];

    //dd($transaction);

    $paiement = PaiementSouscription::where(['amount' => $amount])->orderBy('id','DESC')->first();
    
    if ($transaction['status'] == 'transferred' or ($transaction['status'] == 'approved')) {
      $paiement->status = 1;
    }

    $paiement->identifier = $transaction['id'];
    $paiement->tx_reference = $transaction['reference'];
    $paiement->save();
    
    return redirect('/user/dashboard');
  }
  public function callbackFedapayMobile(Request $request)
  { 
    $id = request('id');
    //$id = 454478;
    //$status = request('status');

    \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

    // Précisez si vous souhaitez exécuter votre requête en mode test ou live
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');
    
    $transaction = \FedaPay\Transaction::retrieve($id);

   // $id = session('id');
    //$type_paiement = session('type_paiement');
    $amount = $transaction['amount'];

    //dd($transaction);

    $paiement = Paiement::where(['amount' => $amount])->orderBy('id','DESC')->first();
    
    $status = 0;

    if ($transaction['status'] == 'transferred' or ($transaction['status'] == 'approved')) {
      $paiement->status = 1;
       $status = 1;
    }

    $paiement->identifier = $transaction['id'];
    $paiement->tx_reference = $transaction['reference'];
    $paiement->save();
    
    return view('payments.success',compact('status'));
  }
  public function callbackFedapaySouscriptionMobile(Request $request)
  { 
    $id = request('id');
    //$id = 454478;
    //$status = request('status');

    \FedaPay\FedaPay::setApiKey("sk_live_vPjQYz2hVd0eyOwPCoQ-s7mC");

    /* Précisez si vous souhaitez exécuter votre requête en mode test ou live */
    \FedaPay\FedaPay::setEnvironment('live'); //ou setEnvironment('live');
    
    $transaction = \FedaPay\Transaction::retrieve($id);

   // $id = session('id');
    //$type_paiement = session('type_paiement');
    $amount = $transaction['amount'];

    //dd($transaction);

    $paiement = PaiementSouscription::where(['amount' => $amount])->orderBy('id','DESC')->first();
    
    $status = 0;
    if ($transaction['status'] == 'transferred' or ($transaction['status'] == 'approved')) {
      $paiement->status = 1;
      $status = 1;
    }

    $paiement->identifier = $transaction['id'];
    $paiement->tx_reference = $transaction['reference'];
    $paiement->save();
    
    return view('payments.success',compact('status'));
  }
  public function callbackPaygate(Request $request)
  { 
    return view('test_paygate');
  }
  public function payWithMomo(Request $request)
  {
    try {
      $collection = new Collection();

      $momoTransactionId = $collection->requestToPay('transactionId', '22973123454', 100);
      return $collection->getTransactionStatus($momoTransactionId);
    } catch(CollectionRequestException $e) {
      do {
        printf("\n\r%s:%d %s (%d) [%s]\n\r", 
          $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
      } while($e = $e->getPrevious());
    }
  }
  public function contact(Request $request)
  {
    if ($request->isMethod('post')) {
      $data = $request->input();
      $email = $data['email'];
      $name = $data['name'];
      $telephone = $data['telephone'];
      $subject = $data['subject'];
      $contenu = $data['message'];
      $values = '{"name":"'.$name.'","email":"'.$email.'","telephone":"'.$telephone.'","objet":"'.$subject.'","message":"'.$contenu.'"}';
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
      $response->success() && var_dump($response->getData());
      return redirect('/contact')->with('flash_message_success', 'Votre mail a été envoyé avec succès! Nous vous répondrons très vite.Merci');
    }
    return view('pages.contact');
  }
  public function quiSommesNous(Request $request)
  {
    return view('pages.about');
  }
  public function packages(Request $request)
  {
    return view('pages.packages');
  }
  public function faq(Request $request)
  {
    return view('pages.faq');
  }
  public function cgu(Request $request)
  {
    return view('pages.cgu');
  }
  public function contratAssurance(Request $request)
  {
    return view('pages.contrat_assurance');
  }
  public function policy(Request $request)
  {
    return view('pages.policy');
  }
  public function choice(Request $request)
  {
    return view('pages.choice');
  }
  public function validateChoice(Request $request)
  {
    if ($request->isMethod('post')) {
      $data = $request->input();
      $pays_destination = $data['pays_destination'];
      $ville_destination = $data['ville_destination'];
      $pays_demarrage = $data['pays_demarrage'];
      $ville_demarrage = $data['ville_demarrage'];
      $date_demarrage = $data['date_demarrage'];
      $heure_demarrage = $data['heure_demarrage'];
      $type = $data['type'];
      session(['date_demarrage' => $date_demarrage]);
      if ($date_demarrage < date('Y-m-d')) {
        return redirect()->back()->with('flash_message_error', 'Date de démarrage inférieure à la date du jour');
      }
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
        )->where('date_demarrage','>=',date('Y-m-d'))->orderBy('created_at','DESC')->get();
        $result = $destinations->count();
        if ($result == 0) {
          $destinations = Destination::where(
            [
              'pays_destination' => $pays_destination,
              'ville_destination' => $ville_destination,
              'pays_demarrage' => $pays_demarrage,
            'ville_demarrage' => $ville_demarrage,
              'status' => 1
            ]
          )->where('date_demarrage','>=',date('Y-m-d'))->orderBy('created_at','DESC')->get();
        }
        return view('pages.choice_results',compact('destinations','result','type'));
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
          )->orderBy('created_at','DESC')->get();
          $result2 = $destinations->count();
          if ($result2 == 0) {
            $lignes = LigneDestination::where(
              [
               // 'jour' => getJour($day),
                'pays_destination' => $pays_destination,
                'ville_destination' => $ville_destination,
                'status' => 1
              ]
            )->orderBy('created_at','DESC')->get();

          }
        }
        //dd($lignes);
        return view('pages.choice_results_compagnies',compact('destinations','result','result2','type','date_demarrage','lignes'));
      }

      
    }
  }
  public function compagniesTransport(Request $request)
  {
    $compagnies = Compagnie::orderBy('denomination','ASC')->get();
    return view('pages.compagnies_transport',compact('compagnies'));
  }
  public function choiceSuggestion(Request $request,$idDestination)
  {
    $id = session('id');
    if ($id > 0) {
            //dd($data);
      session(['destination_id' => $idDestination]);
      session(['type_destination' => 1]);
      return redirect('/user/post-choice');
    } else {
      session(['process' => 1,'destination_id' => $idDestination,'type_destination' => 1]);
      return redirect('/login')->with('flash_message_error', 'Veuillez vous connecter à votre compte pour continuer');
    }
  }
  public function choiceSuggestionCompagnie(Request $request,$idDestination)
  {
    $id = session('id');
    if ($id > 0) {
            //dd($data);
      session(['destination_id' => $idDestination]);
      session(['type_destination' => 2]);
      return redirect('/user/post-choice-compagnie');
    } else {
      session(['process' => 1,'destination_id' => $idDestination,'type_destination' => 2]);
      return redirect('/login')->with('flash_message_error', 'Veuillez vous connecter à votre compte pour continuer');
    }
  }

  public function choiceSuggestionCompagnieLigne(Request $request,$idLigne)
  {
    $id = session('id');
    $ligne = LigneDestination::where(['id' => $idLigne])->first();
    if ($id > 0) {
            //dd($data);
      session(['destination_id' => $ligne->destination_id]);
      session(['ligne_id' => $idLigne]);
      session(['type_destination' => 2]);
      return redirect('/user/post-choice-compagnie');
    } else {
      session(['process' => 1,'destination_id' => $ligne->destination_id,'type_destination' => 2,'ligne_id' => $idLigne]);
      return redirect('/login')->with('flash_message_error', 'Veuillez vous connecter à votre compte pour continuer');
    }
  }

  public function subscribeCompagnie(Request $request,$idCompagnie)
  {
    $id = session('id');
     //$compagnie = Compagnie::where(['id' =>$idCompagnie])->first();
    ClientSubscribeCompagnie::create([
      'client_id' => $id,
      'compagnie_id' => $idCompagnie
    ]);
    return redirect()->back()->with('flash_message_success', 'Abonnement effectué avec succès');
  }

  public function desubscribeCompagnie(Request $request,$idCompagnie)
  {
    $id = session('id');
    //$compagnie = Compagnie::where(['id' =>$idCompagnie])->first();
    $desubscribe = ClientSubscribeCompagnie::where(['compagnie_id' => $idCompagnie,'client_id' => $id])->first();
    $desubscribe->delete();
    return redirect()->back()->with('flash_message_success', 'Désabonnement effectué avec succès');
  }

  public function getCurrenciesValues(Request $request)
  {
    $stonUrl = 'https://api.latoken.com/v2/ticker/STON/USDT';
    $ethUrl = 'https://api.latoken.com/v2/ticker/ETH/USDT';
    $btcUrl = 'https://api.latoken.com/v2/ticker/BTC/USDT';
    $method = 'GET';

    $options = array(
      'http' => array(
        'ignore_errors'=> TRUE,
        'method' => $method
      )
    );
    $context = stream_context_create($options);
    $response1 = json_decode(file_get_contents($stonUrl, FALSE, $context), true);
    $response2 = json_decode(file_get_contents($ethUrl, FALSE, $context), true);
    $response3 = json_decode(file_get_contents($btcUrl, FALSE, $context), true);
    $btcUsd = $response3['lastPrice'];
    $ethUsd = $response2['lastPrice'];
    $stonUsd = $response1['lastPrice'];

    $args = array();
    $args['btc'] = $btcUsd;
    $args['eth'] = $ethUsd;
    $args['ston'] = $stonUsd;
    return response()->json($args, 200);
  }


  public function analyseReservation(Request $request)
  {
    $reservations = Reservation::where('status_reservation','!=',99)->where('type_destination','=',1)->orderBy('created_at','DESC')->get();
    foreach ($reservations as $reservation) {
      if ($reservation->destination->is_confirmed == 0) {
        $timestamp1 = strtotime($reservation->destination->date_demarrage . " " . $reservation->destination->heure);
        $today = date('Y-m-d H:i:s');
        $timestamp2 = strtotime($today);
        $user = User::where('id', $reservation->user_id)->first();
        $diff = intval($timestamp1 - $timestamp2);
        if ($diff >= 850 && $diff <= 950) {
          Notification::create([
            'titre' => "Alerte Voyage",
            'contenu' => "Votre voyage pour " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . " est dans 15 minutes. Merci",
            'user_id' => $reservation->user->id
          ]);
          Notification::create([
            'titre' => "Alerte Voyage",
            'contenu' => "Votre départ pour " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . " est dans 15 minutes. Merci",
            'user_id' => $reservation->destination->user->id
          ]);
        }elseif ($diff >= 1750 && $diff <= 1850) {
          Notification::create([
            'titre' => "Alerte Voyage",
            'contenu' => "Votre voyage pour " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . " est dans 30 minutes. Merci",
            'user_id' => $reservation->destination->user->id
          ]);
          Notification::create([
            'titre' => "Alerte Voyage",
            'contenu' => "Votre départ pour " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . " est dans 30 minutes. Merci",
            'user_id' => $reservation->user->id
          ]);
        }elseif ($diff >= 3550 && $diff <= 3650) {
          Notification::create([
            'titre' => "Alerte Voyage",
            'contenu' => "Votre voyage pour " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . " est dans une heure. Merci",
            'user_id' => $reservation->user->id
          ]);
          Notification::create([
            'titre' => "Alerte Voyage",
            'contenu' => "Votre départ pour " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . " est dans une heure. Merci",
            'user_id' => $reservation->destination->user->id
          ]);
        }
      }
    }

    $reservationsCompagnie = Reservation::where('status_reservation','!=',99)->where('type_destination','=',2)->orderBy('created_at','DESC')->get();
    foreach ($reservationsCompagnie as $reservation) {
      $timestamp1 = strtotime($reservation->date_depart . " " . $reservation->destinationCompagnie->heure);
      $today = date('Y-m-d H:i:s');
      $timestamp2 = strtotime($today);
      $user = User::where('id', $reservation->user_id)->first();
      $diff = intval($timestamp1 - $timestamp2);

      //echo $diff . "<br>";

      if ($diff >= 850 && $diff <= 950) {
        Notification::create([
          'titre' => "Alerte Voyage",
          'contenu' => "Votre voyage pour " .$reservation->destinationCompagnie->ville_destination . " - " . $reservation->destinationCompagnie->pays_destination . " est dans 15 minutes. Merci",
          'user_id' => $reservation->user->id
        ]);
      }elseif ($diff >= 1750 && $diff <= 1850) {
        Notification::create([
          'titre' => "Alerte Voyage",
          'contenu' => "Votre voyage pour " .$reservation->destinationCompagnie->ville_destination . " - " . $reservation->destinationCompagnie->pays_destination . " est dans 30 minutes. Merci",
          'user_id' => $reservation->user->id
        ]);
      }elseif ($diff >= 3550 && $diff <= 3650) {
        Notification::create([
          'titre' => "Alerte Voyage",
          'contenu' => "Votre voyage pour " .$reservation->destinationCompagnie->ville_destination . " - " . $reservation->destinationCompagnie->pays_destination . " est dans une heure. Merci",
          'user_id' => $reservation->user->id
        ]);
      }
    }

    /*$notifications= Notification::where('status', 0)->orderBy('created_at','DESC')->get();
    foreach ($notifications as $notification) {
        $notification->status = 1;
        $notification->save();
        sendNotification($notification->titre, $notification->contenu,$notification->user->token);
      }*/
      return 1;
    }
 }
