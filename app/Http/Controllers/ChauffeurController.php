<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voyageur;
use App\Models\Destination;
use App\Models\DestinationCompagnie;
use App\Models\Chauffeur;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Souscription;
use App\Models\PaiementSouscription;
use Illuminate\Support\Facades\DB;

class ChauffeurController extends Controller
{
	public function addDeparture(Request $request)
	{
		$id = session('id');
		$user = User::where(['id' => $id])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$currentUser = User::where(['id' => $id])->first();
			$surcharge = 0;
			if (isset($data['surcharge'])) {
				$surcharge = 1;
			}else{
				$surcharge = 0;
			}
			$searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $id,'type' => 1])->get()->count();
			//dd($searchSouscription);
			if ($searchSouscription == 0) {
				return redirect()->back()->with('flash_message_error', 'Désolé, Souscrivez avant de continuer!');
			}
			$searchSouscriptionLast = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $id,'type' => 1])->orderBy('id','DESC')->first();
			if($searchSouscriptionLast->paiements->count() > 0){
				if ($searchSouscriptionLast->paiements[0]->type == 1) {
					if (checkPayment($searchSouscriptionLast->paiements[0]->identifier) != 0) {
						return redirect()->back()->with('flash_message_error', 'Désolé, Veuillez payer votre souscription avant de continuer!');
					}
				}else if($searchSouscriptionLast->paiements[0]->type ==2){
					if($searchSouscriptionLast->paiements[0]->status == 0){
						if (checkPaymentFedapay($searchSouscriptionLast->paiements[0]->identifier) != 0) {
							return redirect()->back()->with('flash_message_error', 'Désolé, Veuillez payer votre souscription avant de continuer!');
						}
					}	
				}
			}else{
				return redirect()->back()->with('flash_message_error', 'Désolé, Veuillez payer votre souscription avant de continuer!');
			}



			$lastSaved1 = Destination::where('id','>','0')->orderBy('id','DESC')->first();
			if ($lastSaved1 == null) {
				$nextIndex = 1;
			}else{
				$nextIndex =  $lastSaved1->id + 1;
			}
			

			$lastSaved2 = DestinationCompagnie::where(['id' => $nextIndex])->first();
			if ($lastSaved2 != null) {
				$lastSaved2 = DestinationCompagnie::where('id','>','0')->orderBy('id','DESC')->first();
				$nextIndex =  $lastSaved2->id + 1;
			}
			
			
			
			Destination::create([
				'id' => $nextIndex,
				'pays_destination' => $data['pays_destination'],
				'ville_destination' => $data['ville_destination'],
				'nbre_places' => $data['nbre_places'],
				'nbre_places_dispo' => $data['nbre_places'],
				'prix_unitaire' => $data['prix_unitaire'],
				'pays_demarrage' => $data['pays_demarrage'],
				'ville_demarrage' => $data['ville_demarrage'],
				'date_demarrage' => $data['date_demarrage'],
				'surcharge' => $surcharge,
				'heure' => $data['heure_demarrage'],
				'user_id' => $id,
				'status' => 1
			]);
			return redirect('/user/dashboard')->with('flash_message_success', 'Nouveau départ ajouté! Accéder à l onglet Voyages pour effectuer des modifications.');

		}
		return view('pages.user.dashboard.add_departure',compact('user'));
	}

	public function confirmDeparture(Request $request,$idDestination)
	{
		$destination = Destination::where('id', '=', $idDestination)->first();
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
		return redirect()->back()->with('flash_message_success', 'Départ confirmé avec succès!');
	}

	public function editDeparture(Request $request, $idDestination)
	{
		$id = session('id');
		$user = User::where(['id' => $id])->first();
		$destination = Destination::where(['id' => $idDestination])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$surcharge = 0;
			if (isset($data['surcharge'])) {
				$surcharge = 1;
			}else{
				$surcharge = 0;
			}
			$currentUser = User::where(['id' => $id])->first();
			$searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $id])->get()->count();
			//dd($searchSouscription);
			if ($searchSouscription == 0) {
				return redirect()->back()->with('flash_message_error', 'Désolé, Souscrivez avant de continuer!');
			}
			Destination::where(['id' => $idDestination])->update([
				'pays_destination' => $data['pays_destination'],
				'ville_destination' => $data['ville_destination'],
				'nbre_places' => $data['nbre_places'],
				'nbre_places_dispo' => $data['nbre_places'],
				'prix_unitaire' => $data['prix_unitaire'],
				'pays_demarrage' => $data['pays_demarrage'],
				'ville_demarrage' => $data['ville_demarrage'],
				'date_demarrage' => $data['date_demarrage'],
				'heure' => $data['heure_demarrage'],
				'surcharge' => $surcharge,
				'user_id' => $id
			]);
			return redirect('/user/dashboard')->with('flash_message_success', 'Départ modifié avec succès');

		}
		return view('pages.user.dashboard.edit_departure',compact('user','destination'));
	}
	public function saveVehiculeInfos(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->input();
			$id = session('id');
			$immatriculation = $data['immatriculation'];
			$typeVehicule = $data['type_vehicule'];
			Chauffeur::where(['user_id' => $id])->update([
				'immatriculation' => $immatriculation,
				'type_vehicule' => $typeVehicule
			]);
			return redirect('/user/dashboard')->with('flash_message_success', 'Informations du véhicule modifiées avec succès');
		}
	}
	public function saveChauffeurInfos(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->input();
			$id = session('id');
			$nom = $data['nom'];
			$prenoms = $data['prenoms'];
			$pseudo = $data['pseudo'];
			$telephone = $data['telephone'];
			//$indicatif = $data['indicatif'];
			$indicatif = substr($telephone, 0,4);
			$user = User::where('id', $id)->first();
			$avatar = $user->avatar;
			if ($request->hasfile('avatar')) {
				$imageIcon = $request->file('avatar');
				$exten = $imageIcon->getClientOriginalExtension();
				$imageIconName = $request->nom . uniqid() . '.' . $exten;
				$destinationPath = public_path('/avatars');
				$ulpoadImageSuccess = $imageIcon->move($destinationPath, $imageIconName);
				$avatar = "/avatars/" . $imageIconName;
			}
			User::where(['id' => $id])->update([
				'pseudo' => $pseudo,
				'telephone' => $telephone,
				'avatar' => $avatar,
				'indicatif' => $indicatif
			]);
			Chauffeur::where(['user_id' => $id])->update([
				'nom' => $nom,
				'prenoms' => $prenoms
			]);
			return redirect('/user/dashboard')->with('flash_message_success', 'Informations du véhicule modifiées avec succès');
		}
	}
	public function subscribe(Request $request)
	{
		$id = session('id');
		$user = User::where(['id' => $id])->first();
		if ($request->isMethod('post')) {
			try {
				$data = $request->input();
				$validite = $data['validite'];
				$dateCurrent = date('Y-m-d');
				$searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $id,'type'=>1])->get()->count();
			//dd($searchSouscription);
				if ($searchSouscription > 0) {
					return -1;
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
					'user_id' => $id
				]);

				$souscription = Souscription::where(['reference' => $reference])->first();



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

					$transaction = payFedapaySouscription(getUserAuthEmail(), getUserAuthFirstName(), getUserAuthLastName(), 5000, "Souscription Compte Chauffeur", getUserAuthTelephone());

					session(['identifier' => $identifier]);

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
				return $urlPaiement;
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}
		return view('pages.user.dashboard.add_subscribe',compact('user'));
		
	}

	public function subscribeAssurance(Request $request)
	{
		$id = session('id');
		$user = User::where(['id' => $id])->first();
		if ($request->isMethod('post')) {
			try {
				$data = $request->input();
				$validite = $data['validite'];
				$dateCurrent = date('Y-m-d');
				$searchSouscription = Souscription::whereDate('expiration', '>=', date('Y-m-d'))->where(['user_id' => $id,'type'=>2])->get()->count();
				if ($searchSouscription > 0) {
					return -1;
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
					'user_id' => $id,
					'type' => 2
				]);

				$souscription = Souscription::where(['reference' => $reference])->first();


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

					$transaction = payFedapaySouscription(getUserAuthEmail(), getUserAuthFirstName(), getUserAuthLastName(), 15000, "Souscription Compte Chauffeur", getUserAuthTelephone());

					session(['identifier' => $identifier]);
					session(['type_paiement' => 2]);

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
				return $urlPaiement;
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}
		return view('pages.user.dashboard.add_subscribe_assurance',compact('user'));
	}

	public function paySubscribe(Request $request,$idSouscription)
	{
		try {
			
			$id = session('id');
			$user = User::where(['id' => $id])->first();
			$souscription = Souscription::where(['id' => $idSouscription])->first();

			if ($request->isMethod('post')) {

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

						$transaction = payFedapaySouscription(getUserAuthEmail(), getUserAuthFirstName(), getUserAuthLastName(), $paiementSouscription->amount, "Souscription Compte Chauffeur", getUserAuthTelephone());

						session(['identifier' => $identifier]);

						$urlPaiement = $transaction['url'];

						$paiementSouscription->identifier = $identifier;
						$paiementSouscription->type = 2;
						$paiementSouscription->token = $transaction['token'];
						$paiementSouscription->save();
					}
					return $urlPaiement;
				}else{
					if ($user->indicatif=="+228") {
						$paiementSouscription->identifier = $identifier;
						$paiementSouscription->save();

						$urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount='.$paiementSouscription->amount.'&description=Souscription Compte Chauffeur&identifier='. $identifier;

					}elseif ($user->indicatif=="+229") {

						$transaction = payFedapaySouscription(getUserAuthEmail(), getUserAuthFirstName(), getUserAuthLastName(), $paiementSouscription->amount, "Souscription Compte Chauffeur", getUserAuthTelephone());

						session(['identifier' => $identifier]);

						$urlPaiement = $transaction['url'];

						$paiementSouscription->identifier = $identifier;
						$paiementSouscription->token = $transaction['token'];
						$paiementSouscription->save();
					}
					return $urlPaiement;
				}

				

			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}

