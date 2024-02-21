<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voyageur;
use App\Models\Destination;
use App\Models\Chauffeur;
use Illuminate\Support\Facades\DB;

class ApiVoyageurController extends Controller
{
	public function searchPaysDestinationChauffeur(Request $request)
	{
		$key = $request->input('term');
		$data = DB::TABLE('destinations')->distinct()
		->leftJoin('users','users.id','=','destinations.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [2]
                  )
		->select('destinations.pays_destination  as value')
		->groupBy('destinations.pays_destination')
		->orderBy('pays_destination')
		->get();
		return $data;
	}
	public function searchPaysDemarrageChauffeur(Request $request)
	{
		$key = $request->input('term');
		$data = DB::TABLE('destinations')->distinct()
		->leftJoin('users','users.id','=','destinations.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [2]
                  )
		->select('destinations.pays_demarrage  as value')
		->groupBy('destinations.pays_demarrage')
		->orderBy('pays_demarrage')
		->get();
		return $data;
	}
	public function searchVilleDestinationChauffeur(Request $request)
	{
		$key = $request->input('term');
		$data = DB::TABLE('destinations')->distinct()
		->leftJoin('users','users.id','=','destinations.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [2]
                  )
		->select('destinations.ville_destination  as value')
		->groupBy('destinations.ville_destination')
		->orderBy('ville_destination')
		->get();
		return $data;
	}
	public function searchVilleDemarrageChauffeur(Request $request)
	{
		$key = $request->input('term');
		$data = DB::TABLE('destinations')->distinct()
		->leftJoin('users','users.id','=','destinations.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [2]
                  )
		->select('destinations.ville_demarrage  as value')
		->groupBy('destinations.ville_demarrage')
		->orderBy('ville_demarrage')
		->get();
		return $data;
	}
	public function searchPaysDestinationCompagnie(Request $request)
	{
		$key = $request->input('term');
		$data = array();
		$data1 = DB::TABLE('destinations_compagnie')->distinct()
		->leftJoin('users','users.id','=','destinations_compagnie.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [3]
                  )
		->select('destinations_compagnie.pays_destination  as value')
		->groupBy('destinations_compagnie.pays_destination')
		->orderBy('pays_destination')
		->get();
		$data2 = DB::TABLE('lignes_destinations')->distinct()
		->select('lignes_destinations.pays_destination  as value')
		->orderBy('pays_destination')
		->get();

		foreach ($data1 as $item) {
			array_push($data,array("value"=>$item->value));
		}
		foreach ($data2 as $item) {
			$found = 0;
			foreach ($data as $element) {
				if ($element["value"] == $item->value ) {
					$found = 1;
				}
			}
			if ($found == 0) {
				array_push($data,array("value"=>$item->value));
			}
			
		}
		sort($data);
		return $data;
	}
	public function searchPaysDemarrageCompagnie(Request $request)
	{
		$key = $request->input('term');
		$data = DB::TABLE('destinations_compagnie')->distinct()
		->leftJoin('users','users.id','=','destinations_compagnie.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [3]
                  )
		->select('destinations_compagnie.pays_demarrage  as value')
		->groupBy('destinations_compagnie.pays_demarrage')
		->orderBy('pays_demarrage')
		->get();
		return $data;
	}
	public function searchVilleDestinationCompagnie(Request $request)
	{
		$key = $request->input('term');
		$data = array();
		$data1 = DB::TABLE('destinations_compagnie')->distinct()
		->leftJoin('users','users.id','=','destinations_compagnie.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [3]
                  )
		->select('destinations_compagnie.ville_destination  as value')
		->groupBy('destinations_compagnie.ville_destination')
		->orderBy('ville_destination')
		->get();
		$data2 = DB::TABLE('lignes_destinations')->distinct()
		->select('lignes_destinations.ville_destination  as value')
		->orderBy('ville_destination')
		->get();

		foreach ($data1 as $item) {
			array_push($data,array("value"=>$item->value));
		}
		foreach ($data2 as $item) {
			$found = 0;
			foreach ($data as $element) {
				if ($element["value"] == $item->value ) {
					$found = 1;
				}
			}
			if ($found == 0) {
				array_push($data,array("value"=>$item->value));
			}
			
		}
		sort($data);
		return $data;
	}
	public function searchVilleDemarrageCompagnie(Request $request)
	{
		$key = $request->input('term');
		$data = DB::TABLE('destinations_compagnie')->distinct()
		->leftJoin('users','users.id','=','destinations_compagnie.user_id')
		->whereRaw(
                    "(users.type_user = ?)", 
                    [3]
                  )
		->select('destinations_compagnie.ville_demarrage  as value')
		->groupBy('destinations_compagnie.ville_demarrage')
		->orderBy('ville_demarrage')
		->get();
		return $data;
	}
}
