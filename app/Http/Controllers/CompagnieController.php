<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\News;
use App\Models\Voyageur;
use App\Models\Destination;
use App\Models\Notification;
use App\Models\DestinationCompagnie;
use App\Models\DestinationAnnule;
use App\Models\Chauffeur;
use App\Models\LigneDestination;
use App\Models\Compagnie;
use App\Models\ReservationClient;
use App\Models\ReservationSiege;
use App\Models\ClientSubscribeCompagnie;
use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;
use PDF;
use QrCode;

class CompagnieController extends Controller
{
	public function addDeparture(Request $request)
	{
		$id = session('id');
		$user = User::where(['id' => $id])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$currentUser = User::where(['id' => $id])->first();

			$lastSaved1 = DestinationCompagnie::where('id','>','0')->orderBy('id','DESC')->first();
			

			if ($lastSaved1 != null) {
				$nextIndex =  $lastSaved1->id + 1;
				$lastSaved2 = Destination::where(['id' => $nextIndex])->first();
				if ($lastSaved2 != null) {
					$lastSaved2 = Destination::where('id','>','0')->orderBy('id','DESC')->first();
					$nextIndex =  $lastSaved2->id + 1;
				}
			}else{
				$nextIndex =  1;
			}
			
			

			DestinationCompagnie::create([
				'id' => $nextIndex,
				'pays_destination' => $data['pays_destination'],
				'ville_destination' => $data['ville_destination'],
				'nbre_places' => $data['nbre_places'],
				'nbre_places_dispo' => $data['nbre_places'],
				'prix_unitaire' => $data['prix_unitaire'],
				'pays_demarrage' => $data['pays_demarrage'],
				'ville_demarrage' => $data['ville_demarrage'],
				'jour' => $data['jour'],
				'heure' => $data['heure_demarrage'],
				'user_id' => $id
			]);
			return redirect()->back()->with('flash_message_success', 'Nouveau départ ajouté! Accéder au menu Voyages pour effectuer des modifications.');

		}
		return view('pages.user.dashboard.compagnie.add_departure',compact('user'));
	}
	public function editDeparture(Request $request, $idDestination)
	{
		$id = session('id');
		
		//dd($compagnies);
		$destination = DestinationCompagnie::where(['id' => $idDestination])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			//$currentUser = User::where(['id' => $id])->first();
			DestinationCompagnie::where(['id' => $idDestination])->update([
				'pays_destination' => $data['pays_destination'],
				'ville_destination' => $data['ville_destination'],
				'nbre_places' => $data['nbre_places'],
				'nbre_places_dispo' => $data['nbre_places'],
				'prix_unitaire' => $data['prix_unitaire'],
				'pays_demarrage' => $data['pays_demarrage'],
				'ville_demarrage' => $data['ville_demarrage'],
				'jour' => $data['jour'],
				'heure' => $data['heure_demarrage'],
				'user_id' => $id
			]);
			return redirect()->back()->with('flash_message_success', 'Départ modifié!');

		}
		$compagnies = Compagnie::orderBy('denomination','ASC')->get();
		//dd($compagnies->count());
		return view('pages.user.dashboard.compagnie.edit_departure',compact('compagnies','destination'));
	}
	public function annulerDeparture(Request $request, $idDestination)
	{
		$id = session('id');
		
		if ($request->isMethod('post')) {
			$data = $request->all();
			//$currentUser = User::where(['id' => $id])->first();

			if (DestinationAnnule::where(['date_annulation' => $data['date_annulation'],'destination_id' => $idDestination])->get()->count() > 0) {
				return redirect()->back()->with('flash_message_error', 'Date déjà annulée pour cette destination!');
			}
			DestinationAnnule::create([
				'date_annulation' => $data['date_annulation'],
				'destination_id' => $idDestination
			]);
			//dd($compagnies);
			$destination = DestinationCompagnie::where(['id' => $idDestination])->first();
		//dd($compagnies->count());
			return redirect()->back()->with('flash_message_success', 'Le voyage prévu à cette date a été annulé!');

		}
	}
	public function showDeparture(Request $request)
	{
		$id = session('id');
		$destinations = DestinationCompagnie::where(['user_id' => $id,'status' => 1])->orderBy('created_at','DESC')->get();
		return view('pages.user.dashboard.compagnie.all_departures',compact('destinations'));

	}
	public function showDeparture2(Request $request)
	{
		$id = session('id');
		$destinations = DestinationCompagnie::where(['user_id' => $id,'status' => 1])->orderBy('created_at','DESC')->get();
		return view('pages.user.dashboard.compagnie.show_departures',compact('destinations'));

	}

	public function deleteDeparture(Request $request, $idDestination)
	{
		$id = session('id');
		
		//dd($compagnies);
		$destination = DestinationCompagnie::where(['id' => $idDestination])->first();
		$destination->status = 0;
		$destination->save();
		foreach ($destination->ligne as $ligne) {
			$ligne->status = 0;
			$ligne->save();
		}
		return redirect()->back()->with('flash_message_success', 'Départ supprimé!');
	}

	
	public function allReservations(Request $request)
	{
		$id = session('id');
		if ($request->isMethod('post')) {
			$data = $request->all();
			$elements = array();
			$dateDepart = $data['date_depart'];
			$destinationId = $data['destination_id'];
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
			->select('reservations.id as id','reservations.date_reservation  as date_reservation','reservations.nbre_places  as nbre_places','reservations.prix_total_commission  as prix_total','reservations.status_reservation  as status_reservation','reservations.reference  as reference','reservations.facture  as facture','reservations.date_depart  as date_depart','reservations.user_id  as user_id','paiements.identifier  as identifier','paiements.status  as status','paiements.type  as type','reservations.status_siege  as status_siege','reservations.ligne_destination_id  as ligne_destination_id')
			->orderBy('reservations.date_reservation','DESC')
			->get();


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
			->select('reservations_clients.id as id','reservations_clients.date_reservation  as date_reservation','reservations_clients.nbre_places  as nbre_places','reservations_clients.prix_total  as prix_total','reservations_clients.status_reservation  as status_reservation','reservations_clients.reference  as reference','reservations_clients.facture  as facture','reservations_clients.date_depart  as date_depart','reservations_clients.client_id  as user_id','reservations_clients.status_siege  as status_siege','reservations_clients.ligne_destination_id  as ligne_destination_id')
			->orderBy('reservations_clients.date_reservation','DESC')
			->get();


			foreach ($reservations as $reservation) {
				array_push($elements,array("id"=>$reservation->id,"date_reservation" => $reservation->date_reservation
					,"nbre_places" => $reservation->nbre_places,"prix_total" => $reservation->prix_total,"status_reservation" => $reservation->status_reservation,"reference" => $reservation->reference,"facture" => $reservation->facture,"date_depart" => $reservation->date_depart,"user_id" => $reservation->user_id,"status_siege" => $reservation->status_siege,"identifier" => $reservation->identifier,"status" => $reservation->status,"ligne_destination_id" => $reservation->ligne_destination_id,"type" => $reservation->type,"type_reservation" => 1));
			}
			foreach ($reservationsClients as $reservation2) {
				array_push($elements,array("id"=>$reservation2->id,"date_reservation" => $reservation2->date_reservation
					,"nbre_places" => $reservation2->nbre_places,"prix_total" => $reservation2->prix_total,"status_reservation" => $reservation2->status_reservation,"reference" => $reservation2->reference,"facture" => $reservation2->facture,"date_depart" => $reservation2->date_depart,"user_id" => $reservation2->user_id,"status_siege" => $reservation2->status_siege,"type_reservation" => 2,"ligne_destination_id" => $reservation2->ligne_destination_id));
			}

			$destination = DestinationCompagnie::where(['id' => $destinationId])->first();
			return view('pages.user.dashboard.compagnie.all_reservations',compact('elements','destination','dateDepart'));
		}
	}
	
	public function detailsDeparture(Request $request,$idDepart)
	{
		$id = session('id');
		$elements = array();
		$reservations = DB::TABLE('reservations')->distinct()
		->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
		->leftJoin('paiements','paiements.reservation_id','=','reservations.id')
		->whereRaw(
			"(destinations_compagnie.user_id = ?)", 
			[$id]
		)->whereRaw(
			"(destinations_compagnie.id = ?)", 
			[$idDepart]
		)
		->select(DB::raw('DATE(reservations.date_depart) as date_depart'),DB::raw('COUNT(reservations.id) as nbre_reservations'))
		->orderBy('date_depart','DESC')
		->groupBy('date_depart')
		->get();

		$reservationsClients = DB::TABLE('reservations_clients')->distinct()
		->join('destinations_compagnie','destinations_compagnie.id','=','reservations_clients.destination_id')
		->whereRaw(
			"(destinations_compagnie.user_id = ?)", 
			[$id]
		)->whereRaw(
			"(destinations_compagnie.id = ?)", 
			[$idDepart]
		)
		->select(DB::raw('DATE(reservations_clients.date_depart) as date_depart'),DB::raw('COUNT(reservations_clients.id) as nbre_reservations'))
		->orderBy('date_depart','DESC')
		->groupBy('date_depart')
		->get();

		foreach ($reservations as $reservation) {
			array_push($elements,array("date_depart"=>$reservation->date_depart,"nbre_reservations" => $reservation->nbre_reservations));
		}
		foreach ($reservationsClients as $reservation) {
			$found = 0;
			foreach ($elements as $element) {
				if ($element["date_depart"] ==$reservation->date_depart ) {
					$found = 1;
				}
			}
			if ($found == 0) {
				array_push($elements,array("date_depart"=>$reservation->date_depart,"nbre_reservations" => $reservation->nbre_reservations));
			}
			
		}

		//dd($elements);

		$destination = DestinationCompagnie::where(['id' => $idDepart])->first();
		return view('pages.user.dashboard.compagnie.details_departure',compact('elements','destination'));

	}

	public function lignesDeparture(Request $request,$idDepart)
	{
		$id = session('id');
		//dd($elements);

		$destination = DestinationCompagnie::where(['id' => $idDepart])->first();
		$lignes = LigneDestination::where(['destination_id' => $idDepart,'status'=> 1])->get();
		return view('pages.user.dashboard.compagnie.lignes_depart',compact('destination','lignes'));

	}
	public function addLigneDepart(Request $request,$idDepart)
	{
		$id = session('id');
		if ($request->isMethod('post')) {
			$data = $request->all();
			$destination = DestinationCompagnie::where(['id' => $idDepart])->first();
			LigneDestination::create([
				'pays_destination' => $data['pays_destination'],
				'ville_destination' => $data['ville_destination'],
				'prix_unitaire' => $data['prix_unitaire'],
				'destination_id' => $idDepart
			]);
			
			return redirect()->back()->with('flash_message_success', 'Nouvelle ligne ajoutée au départ avec succès!');
		}
	}
	public function editLigneDepart(Request $request,$idLigneDepart)
	{
		$id = session('id');
		$ligneDepart = LigneDestination::where(['id' => $idLigneDepart])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();

			LigneDestination::where(['id' => $idLigneDepart])->update([
				'pays_destination' => $data['pays_destination'],
				'ville_destination' => $data['ville_destination'],
				'prix_unitaire' => $data['prix_unitaire']
			]);
			
			return redirect()->back()->with('flash_message_success', 'Ligne modifiée au départ avec succès!');
		}
		return view('pages.user.dashboard.compagnie.edit_ligne_depart',compact('ligneDepart'));

	}
	public function deleteLigneDepart(Request $request,$idLigneDepart)
	{
		$id = session('id');

		$ligne = LigneDestination::where(['id' => $idLigneDepart])->first();
		$ligne->status = 0;
		$ligne->save();
		return redirect()->back()->with('flash_message_success', 'Ligne supprimée avec succès!');
	}
	/*public function saveVehiculeInfos(Request $request)
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
	}*/
	public function addNew(Request $request)
	{
		$id = session('id');
		if ($request->isMethod('post')) {
			$data = $request->all();
			$titre = $data['titre'];
			$contenu = $data['contenu'];
			News::create([
				'titre' => $titre,
				'contenu' => $contenu,
				'user_id' => $id,
				'status' => 1
			]);
			$compagnie = Compagnie::where(['user_id' => $id])->first();
			$abonnes = ClientSubscribeCompagnie::where(['compagnie_id' =>$compagnie->id])->get();
			foreach ($abonnes as $abonne) {
				Notification::create([
					'titre' => $compagnie->denomination . " :: " . $titre,
					'contenu' => $contenu,
					'user_id' => $abonne->client_id
				]);
			}

			return redirect('/user-compagnie/add-new')->with('flash_message_success', 'Nouveau new ajouté avec succès!');
		}
		return view('pages.user.dashboard.compagnie.add_new');
	}
	public function editNew(Request $request,$idNew)
	{
		$id = session('id');
		$new = News::where(['id' => $idNew])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$titre = $data['titre'];
			$contenu = $data['contenu'];
			News::where(['id' => $idNew])->update([
				'titre' => $titre,
				'contenu' => $contenu,
				'user_id' => $id
			]);
			return redirect('/user-compagnie/edit-new/'.$idNew)->with('flash_message_success', 'New modifié avec succès!');
		}
		return view('pages.user.dashboard.compagnie.edit_new')->with(compact('new'));
	}
	public function showNew()
	{
		$id = session('id');
		$news = News::where(['status' =>1,'user_id' =>$id])->get();
		return view('pages.user.dashboard.compagnie.show_new', compact('news'));
	}
	public function showAbonnes()
	{
		$id = session('id');
		$compagnie = Compagnie::where(['user_id' => $id])->first();
		$abonnes = ClientSubscribeCompagnie::where(['compagnie_id' =>$compagnie->id])->get();
		return view('pages.user.dashboard.compagnie.show_abonnes', compact('abonnes'));
	}
	public function deleteNew(Request $request, $idNew)
	{
		$id = session('id');
		$new = News::where(['id' => $idNew])->first();
		News::where(['id' => $idNew])->update([
			'status' => 0
		]);
		return redirect()->back()->with('flash_message_success', 'New supprimé avec succès!');
	}

	public function addClient(Request $request)
	{
		$id = session('id');
		if ($request->isMethod('post')) {
			$data = $request->all();
			$nom = $data['nom'];
			$prenoms = $data['prenoms'];
			$telephone = $data['telephone'];
			$indicatif = $data['indicatif'];
			$sexe = $data['sexe'];
			Client::create([
				'nom' => $nom,
				'prenoms' => $prenoms,
				'telephone' => $telephone,
				'indicatif' => $indicatif,
				'sexe' => $sexe,
				'compagnie_id' => $id
			]);
			return redirect('/user-compagnie/all-clients')->with('flash_message_success', 'Nouveau client ajouté avec succès!');
		}
		return view('pages.user.dashboard.compagnie.add_client');
	}
	public function editClient(Request $request,$idClient)
	{
		$id = session('id');
		$client = Client::where(['id' => $idClient])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$nom = $data['nom'];
			$prenoms = $data['prenoms'];
			$telephone = $data['telephone'];
			//$indicatif = $data['indicatif'];
			$sexe = $data['sexe'];
			Client::where(['id' => $idClient])->update([
				'nom' => $nom,
				'prenoms' => $prenoms,
				//'indicatif' => $indicatif,
				'telephone' => $telephone,
				'sexe' => $sexe
			]);
			return redirect()->back()->with('flash_message_success', 'Client modifié avec succès!');
		}
		return view('pages.user.dashboard.compagnie.edit_client')->with(compact('client'));
	}
	public function addClientReservation(Request $request,$idClient)
	{
		$id = session('id');
		$client = Client::where(['id' => $idClient])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$destinationId = $data['destination_id'];
			$datas = explode("-", $destinationId);
			$ligneId = 0;
			$prixUnitaire = 0;
			if ($datas[0] == "L") {
				$ligne = LigneDestination::where(['id' => $datas[1]])->first();
				$ligneId = $ligne->id;
				$destination = DestinationCompagnie::where(['id' => $ligne->destination_id])->first();
				$prixUnitaire = $ligne->prix_unitaire;
			}else{
				$destination = DestinationCompagnie::where(['id' => $destinationId])->first();
				$prixUnitaire = $destination->prix_unitaire;
			}
			//dd(getPlacesDispoCompagnieNew($destinationId,$data['date_depart']));
			//dd(intval($data['nbre_places']));
			$nbrePlacesRestants = getPlacesDispoCompagnieNew($destination->id,$data['date_depart']);
			if($nbrePlacesRestants <= $data['nbre_places']) {
				return redirect()->back()->with('flash_message_error', 'Nombre de places indisponible.');
			}
			$prixTotal = $data['nbre_places']*$prixUnitaire;
			$reference = getRamdomText(15);
			$code = getRamdomCode(4);
			$nbrePlacesRestantes = $destination->nbre_places_dispo - $data['nbre_places'];
			ReservationClient::create([
				'ligne_destination_id' => $ligneId ,
				'destination_id' =>$destination->id,
				'date_reservation' => Date('Y-m-d'),
				'nbre_places' => $data['nbre_places'],
				'prix_total' => $prixTotal,
				'facture' => getFacturePrefix($client->indicatif) . $code,
				'reference' => $reference,
				'date_depart' => $data['date_depart'],
				'client_id' => $idClient
			]);
			DestinationCompagnie::where(['id' => $destination->id])->update([
				'nbre_places_dispo' => $nbrePlacesRestantes
			]);
			return redirect()->back()->with('flash_message_success', 'Nouvelle reservation ajoutée pour le client '. $client->nom .' '.$client->prenoms .' avec succès!');
		}
	}
	public function showClient()
	{
		$id = session('id');
		$clients = Client::where(['compagnie_id' =>$id])->get();
		$destinations = DestinationCompagnie::where(['user_id' => $id])->orderBy('created_at','DESC')->get();
		return view('pages.user.dashboard.compagnie.show_clients', compact('clients','destinations'));
	}
	public function showClientReservations($idClient)
	{
		$id = session('id');
		$reservations = ReservationClient::where(['client_id' => $idClient])->get();
		$client = Client::where(['id' =>$idClient])->first();
		return view('pages.user.dashboard.compagnie.show_clients_reservations', compact('reservations','client'));
	}
	public function checkDestinationPlaces(Request $request)
	{
		$id = session('id');
		$input = $request->all();
		$nbrePlaces = $input['nbre_places'];
		$destinationId = $input['destination'];
		$dateDepart = $input['date_depart'];

		$datas = explode("-", $destinationId);
		if ($datas[0] == "L") {
			$ligne = LigneDestination::where(['id' => $datas[1]])->first();
			$destination = DestinationCompagnie::where(['id' => $ligne->destination_id])->first();
		}else{
			$destination = DestinationCompagnie::where(['id' => $destinationId])->first();
		}

		$count = 0;
		foreach ($destination->reservations as $reservation) {
			if ($reservation->date_depart == $dateDepart) {
				if($reservation->paiement->count() > 0){
					if ($reservation->paiement[0]->type ==1) {
						if (checkPayment($reservation->paiement[0]->identifier) == 0 or $reservation->paiement[0]->status==1) {
							$count += $reservation->nbre_places;
						}
					}else if($reservation->paiement[0]->type ==2){
						if (checkPaymentFedapay($reservation->paiement[0]->identifier) == 0 or $reservation->paiement[0]->status==1) {
							$count += $reservation->nbre_places;
						}
					}
				}
			}
		}
		foreach ($destination->reservationsClient as $reservation) {
			if ($reservation->date_depart == $dateDepart) {
				$count += $reservation->nbre_places;
			}
		}
		return $destination->nbre_places - $count;
	}
	

	public function attributeSiegeClient(Request $request,$idReservation)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();
			
			$reservation = ReservationClient::where(['id' => $idReservation])->first();
			for ($i=1; $i <= $reservation->nbre_places; $i++) { 
				$siege = $data['numero_siege'.$i];
				ReservationSiege::create([
					'numero' => $siege,
					'type_reservation' => 2,
					'reservation_id' => $reservation->id
				]);
			}
			ReservationClient::where(['id' => $idReservation])->update([
				'status_siege' => 1
			]);

			return redirect('/user-compagnie/show-departs')->with('flash_message_success', 'Attribution de siège effectuée avec succès!');
		}
		
	}
	public function attributeSiege(Request $request,$idReservation)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();
			
			$reservation = Reservation::where(['id' => $idReservation])->first();
			for ($i=1; $i <= $reservation->nbre_places; $i++) { 
				$siege = $data['numero_siege'.$i];
				ReservationSiege::create([
					'numero' => $siege,
					'type_reservation' => 1,
					'reservation_id' => $reservation->id
				]);
			}
			Reservation::where(['id' => $idReservation])->update([
				'status_siege' => 1
			]);

			return redirect()->back()->with('flash_message_success', 'Attribution de siège effectuée avec succès!');
		}
		
	}
	public function deleteClient(Request $request, $idClient)
	{
		$id = session('id');
		$client = Clients::where(['id' => $idClient])->first();
		Clients::where(['id' => $idClient])->update([
			'status' => 0
		]);
		return redirect()->back()->with('flash_message_success', 'Client supprimé avec succès!');
	}

	public function printTicketPDF(Request $request,$idReservation)
	{

		/*$reservation = Reservation::where(['id' => $idReservation])->first();

        //$pdf = PDF::loadView('', $data);  
        //return $pdf->download('ticket.pdf');
        //$ordonnance = Ordonnance::where(['id' => $idOrdonnance])->first();


		$pdf = \PDF::loadView('factures.ticket_reservation', compact('reservation'));

		$pdf->save(storage_path().'_ticket.pdf');

		return $pdf->download('ticket'.$reservation->facture.'.pdf');*/

		//return view('factures.ticket_reservation')->with(compact('reservation'));


		$reservation = ReservationClient::where(['id' => $idReservation])->first();
		$sieges = ReservationSiege::where(['reservation_id' => $reservation->id])->get();
		$qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($reservation->facture));
		$pdf    = PDF::setOptions([
			'images' => true
		])->loadView('factures.ticket_reservation_compagnie', compact('reservation','qrcode','sieges'))->setPaper('a4', 'portrait');
		return $pdf->download('ticket'.$reservation->facture.'.pdf');
        //return view('factures.ticket_reservation')->with(compact('reservation'));
	}
	public function printTicketPDF2(Request $request,$idReservation)
	{

		/*$reservation = Reservation::where(['id' => $idReservation])->first();

        //$pdf = PDF::loadView('', $data);  
        //return $pdf->download('ticket.pdf');
        //$ordonnance = Ordonnance::where(['id' => $idOrdonnance])->first();


		$pdf = \PDF::loadView('factures.ticket_reservation', compact('reservation'));

		$pdf->save(storage_path().'_ticket.pdf');

		return $pdf->download('ticket'.$reservation->facture.'.pdf');*/

		//return view('factures.ticket_reservation')->with(compact('reservation'));


		$reservation = Reservation::where(['id' => $idReservation])->first();
		$sieges = ReservationSiege::where(['reservation_id' => $reservation->id])->get();
		$qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($reservation->facture));
		$pdf    = PDF::setOptions([
			'images' => true
		])->loadView('factures.ticket_reservation', compact('reservation','qrcode','sieges'))->setPaper('a4', 'portrait');
		return $pdf->download('ticket'.$reservation->facture.'.pdf');
        //return view('factures.ticket_reservation')->with(compact('reservation'));
	}
	
}
