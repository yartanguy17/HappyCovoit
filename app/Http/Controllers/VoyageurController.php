<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voyageur;
use App\Models\Destination;
use App\Models\Notification;
use App\Models\DestinationCompagnie;
use App\Models\ReservationSiege;
use App\Models\Chauffeur;
use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;
use PDF;
use QrCode;
use Redirect;
use App\Models\LigneDestination;
use Bmatovu\MtnMomo\Products\Collection;
use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;

class VoyageurController extends Controller
{
	public function searchDeparture(Request $request)
	{
		$id = session('id');
		$user = User::where(['id' => $id])->first();
		return view('pages.user.dashboard.search_departure',compact('user'));
	}
	public function postChoice(Request $request)
	{
		$id = session('id');
		$destinationId = session('destination_id');
		$user = User::where(['id' => $id])->first();
		//dd($destinationId);
		$destination = Destination::where(['id' => $destinationId])->first();
		if ($request->isMethod('post')) {
			$data = $request->input();
			if ($destination->user_id==$id ) {
				return redirect()->back()->with('flash_message_error', 'Vous ne pouvez pas choisir cette destination!');
			}
			$id = session('id');
			$totalPrice = $data['total_price'];
			$nbrePlaces = $data['nbre_places'];

			$reference = getRamdomText(15);
			$code = getRamdomCode(4);

			$searchReservation = Reservation::where(['user_id' => $id,'destination_id' => $data['destination_id'],'status_reservation' => 1])->get()->count();


			/*if ($searchReservation>=2 ) {
				return redirect()->back()->with('flash_message_error', 'Vous avez atteint le nombre de réservations pour cette destination!');
			}*/
			$nbrePlacesRestantes = $destination->nbre_places_dispo - $data['nbre_places'];
			
			Reservation::create([
				'date_reservation' => Date('Y-m-d'),
				'nbre_places' => $nbrePlaces,
				'prix_total' => $destination->prix_unitaire * $nbrePlaces,
				'prix_total_commission' => $totalPrice,
				'facture' => getFacturePrefix($user->indicatif) . $code,
				'reference' => $reference,
				'type_destination' => 1,
				'status_reservation' => 1,
				'destination_id' => $data['destination_id'],
				'user_id' => $id
			]);

			Notification::create([
				'titre' => "Nouvelle réservation",
				'contenu' => getUserNameById($id) . " a fait une réservation de ". $nbrePlaces ." places pour la destination " .$destination->ville_destination . " - " . $destination->pays_destination . ". Son numéro de Téléphone est " . $user->telephone,
				'user_id' => $destination->user->id
			]);

			Destination::where(['id' => $destinationId])->update([
				'nbre_places_dispo' => $nbrePlacesRestantes
			]);

			$reservation = Reservation::where(['reference' => $reference])->first();


			return redirect('/user/dashboard')->with('flash_message_success', 'Opération effectuée avec succès! Le paiement se fera en physique avec le chauffeur');
		}
		return view('pages.user.dashboard.post_choice',compact('user','destination'));
	}
	public function postChoiceCompagnie(Request $request)
	{
		$id = session('id');
		$destinationId = session('destination_id');
		$date_demarrage = session('date_demarrage');

		$ligne = null;
		$ligneId = session('ligne_id');
		if ($ligneId > 0) {
			$ligne = LigneDestination::where(['id' => $ligneId])->first();
		}

		$user = User::where(['id' => $id])->first();
		$destination = DestinationCompagnie::where(['id' => $destinationId])->first();
		$lignes = LigneDestination::where(['destination_id' => $destinationId])->get();
		return view('pages.user.dashboard.post_choice_compagnie',compact('user','destination','date_demarrage','lignes','ligne'));
	}

	public function saveVoyageurInfos(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->input();
			$id = session('id');
			$nom = $data['nom'];
			$prenoms = $data['prenoms'];
			$email = $data['email'];
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
			Voyageur::where(['user_id' => $id])->update([
				'nom' => $nom,
				'prenoms' => $prenoms,
				'email' => $email
			]);
			return redirect('/user/dashboard')->with('flash_message_success', 'Informations personnelles modifiées avec succès');
		}
	}


	public function validatePostChoiceCompagnie(Request $request)
	{
		if ($request->isMethod('post')) {
			try {
				$id = session('id');
				$destinationId = session('destination_id');
				$data = $request->input();
				$totalPrice = intval($data['total_price']);
				$nbrePlaces = $data['nbre_places'];
				$dateDepart = $data['date_depart'];
				$ligneId = $data['ligne_id'];
				$user = User::where(['id' => $id])->first();
				$destination = DestinationCompagnie::where(['id' => $destinationId])->first();
				
				if (getPlacesDispoCompagnieNew($destination->id,$dateDepart) < intval($nbrePlaces)) {
					return 99;
				}
				$nbrePlacesRestantes = $destination->nbre_places_dispo - $data['nbre_places'];

				
				if ($destination->user_id==$id ) {
				//return redirect()->back()->with('flash_message_error', 'Vous ne pouvez pas choisir cette destination!');
					return -1;
				}
				$id = session('id');

				

				$reference = getRamdomText(15);
				$code = getRamdomCode(4);
				$searchReservation = Reservation::where(['user_id' => $id,'destination_id' => $data['destination_id']])->get()->count();

				$prixUnitaire = 0;
				if ($ligneId>0) {
					$ligne = LigneDestination::where(['id' => $ligneId])->first();
					$prixUnitaire = $ligne->prix_unitaire;
				}else{
					$prixUnitaire = $destination->prix_unitaire;
				}

				/*if ($searchReservation>=2) {
				//return redirect()->back()->with('flash_message_error', 'Vous avez atteint le nombre de réservations pour cette destination!');
					return -2;
				}*/

				Reservation::create([
					'date_reservation' => Date('Y-m-d'),
					'nbre_places' => $nbrePlaces,
					'date_depart' => $dateDepart,
					'ligne_destination_id' => $ligneId,
					'prix_total' => $prixUnitaire * $nbrePlaces,
					'type_destination' => 2,
					'prix_total_commission' => $totalPrice,
					'facture' => getFacturePrefix($user->indicatif) . $code,
					'reference' => $reference,
					'status_reservation' => 1,
					'destination_id' => $data['destination_id'],
					'user_id' => $id
				]);



				DestinationCompagnie::where(['id' => $destinationId])->update([
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
					$urlPaiement = 'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=' . $totalPrice  . '&description=Reservation de Ticket&identifier='. $identifier;
					
				}elseif ($user->indicatif=="+229") {

					$transaction = payFedapay(getUserAuthEmail(), getUserAuthFirstName(), getUserAuthLastName(), $totalPrice, "Réservation de Ticket", getUserAuthTelephone());

					session(['identifier' => $identifier]);
					session(['type_paiement' => 1]);

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
					$transaction = payFedapay(getUserAuthEmail(), getUserAuthFirstName(), getUserAuthLastName(), $totalPrice, "Réservation de Ticket", getUserAuthTelephone());

					session(['identifier' => $identifier]);
					session(['type_paiement' => 1]);

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
				return $urlPaiement;

			} catch (Exception $e) {
				return $e->getMessage();
			}


		}
	}
	public function signalChauffeur(Request $request, $idReservation)
	{
		$id = session('id');
		$data = $request->all();
		$motif = $data['motif'];
		Reservation::where(['id' => $idReservation])->update([
			'is_signal' => 1,
			'motif' => $motif
		]);
		return redirect()->back()->with('flash_message_success', 'Chauffeur signalé avec succès');
	}
	public function annulerVoyage(Request $request, $idReservation)
	{
		$id = session('id');
		$reservation = Reservation::where(['id' => $idReservation])->first();
		Reservation::where(['id' => $idReservation])->update([
			'status_reservation' => 99,
			'nbre_places_annules' => $reservation->nbre_places
		]);
		$user = User::where(['id' => $id])->first();
		Notification::create([
			'titre' => "Annulation de réservation",
			'contenu' => getUserNameById($id) . " a annulé ". $reservation->nbre_places ." places de sa réservation pour la destination " .$reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . ". Son numéro de Téléphone est " . $user->telephone,
			'user_id' => $reservation->destination->user->id
		]);


		return redirect()->back()->with('flash_message_success', 'Voyage annulé avec succès!');
	}

	public function annulerVoyagePlaces(Request $request, $idReservation)
	{
		$id = session('id');
		$data = $request->all();
		$nbrePlaces = $data['nbre_places'];
		$reservation = Reservation::where(['id' => $idReservation])->first();
		if ($nbrePlaces<1) {
			return redirect()->back()->with('flash_message_error', 'le nombre de places doit être supérieur à 0.');
		}
		if ($nbrePlaces>$reservation->nbre_places) {
			return redirect()->back()->with('flash_message_error', 'Nombre de places reservé est inférieur.');
		}
		if ($reservation->nbre_places_annules > 0) {
			$nbrePlaces += $reservation->nbre_places_annules;
		}
		$placesR = $reservation->nbre_places - $nbrePlaces;
		$prixTotalNew = $reservation->destination->prix_unitaire * $placesR;
		Reservation::where(['id' => $idReservation])->update([
			'status_reservation' => 0,
			'prix_total_commission' => $prixTotalNew,
			'nbre_places_annules' => $nbrePlaces
		]);

		$user = User::where(['id' => $id])->first();
		Notification::create([
			'titre' => "Annulation de réservation",
			'contenu' => getUserNameById($id) . " a annulé sur sa réservation " . $nbrePlaces ." places pour la destination " . $reservation->destination->ville_destination . " - " . $reservation->destination->pays_destination . ". Son numéro de Téléphone est " . $user->telephone,
			'user_id' => $reservation->destination->user->id
		]);


		return redirect()->back()->with('flash_message_success', 'Voyage annulé avec succès!');
	}
	public function noteChauffeur(Request $request, $idReservation)
	{
		$id = session('id');
		if ($request->isMethod('post')) {
			$data = $request->all();
			Reservation::where(['id' => $idReservation])->update([
				'note' =>$data['note'.$idReservation]
			]);
			return redirect()->back()->with('flash_message_success', 'Note attribuée avec succès');

		}
	}
	public function testReservation(Request $request)
	{
		$id = session('id');
		$places = getPlacesDispoCompagnieNew(1,date('Y-m-d'));
		return $places;
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
