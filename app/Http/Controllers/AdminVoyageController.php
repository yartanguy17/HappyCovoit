<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use App\Models\Voyageur;
use App\Models\DestinationCompagnie;
use App\Models\Destination;
use App\Models\Chauffeur;
use App\Models\Compagnie;
use App\Models\Reservation;
use App\Models\LigneDestination;
use App\Models\Paiement;
use PDF;
use QrCode;

class AdminVoyageController extends Controller
{
	public function addDeparture(Request $request)
	{
		$id = session('id');
		
		//dd($compagnies);
		if ($request->isMethod('post')) {
			$data = $request->all();
			$currentUser = User::where(['id' => $id])->first();


			$lastSaved1 = DestinationCompagnie::where('id','>','0')->orderBy('id','DESC')->first();
			$nextIndex =  $lastSaved1->id + 1;

			$lastSaved2 = Destination::where(['id' => $nextIndex])->first();
			if ($lastSaved2 != null) {
				$lastSaved2 = Destination::where('id','>','0')->orderBy('id','DESC')->first();
				$nextIndex =  $lastSaved2->id + 1;
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
				'user_id' => $data['compagnie_id']
			]);
			return redirect()->back()->with('flash_message_success', 'Nouveau départ ajouté! Accéder au menu Voyages pour effectuer des modifications.');

		}
		$compagnies = Compagnie::orderBy('denomination','ASC')->get();
		//dd($compagnies->count());
		return view('pages.admin.dashboard.voyages.add',compact('compagnies'));
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
				'heure' => $data['heure_demarrage']
			]);
			return redirect()->back()->with('flash_message_success', 'Départ modifié!');

		}
		$compagnies = Compagnie::orderBy('denomination','ASC')->get();
		//dd($compagnies->count());
		return view('pages.admin.dashboard.voyages.edit',compact('compagnies','destination'));
	}
	
	public function deleteDeparture(Request $request, $idDestination)
	{
		$id = session('id');
		
		//dd($compagnies);
		$destination = DestinationCompagnie::where(['id' => $idDestination])->first();
		$destination->delete();
		return redirect()->back()->with('flash_message_success', 'Départ supprimé!');
	}

	public function lignesDeparture(Request $request,$idDepart)
	{
		$id = session('id');
		//dd($elements);

		$destination = DestinationCompagnie::where(['id' => $idDepart])->first();
		$lignes = LigneDestination::where(['destination_id' => $idDepart])->get();
		return view('pages.admin.dashboard.voyages.lignes_depart',compact('destination','lignes'));

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
		return view('pages.admin.dashboard.voyages.edit_ligne_depart',compact('ligneDepart'));

	}
	public function deleteLigneDepart(Request $request,$idLigneDepart)
	{
		$id = session('id');

		$ligne = LigneDestination::where(['id' => $idLigneDepart])->first();
		$ligne->delete();
		return redirect()->back()->with('flash_message_success', 'Ligne supprimée avec succès!');
	}

	

	public function showDeparture(Request $request)
	{
		$id = session('id');
		$destinations = DestinationCompagnie::where(['status' => 1])->orderBy('created_at','DESC')->get();
		return view('pages.admin.dashboard.voyages.show',compact('destinations'));

	}
	
}
