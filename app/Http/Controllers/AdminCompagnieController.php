<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Compagnie;
use App\Models\DestinationCompagnie;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class AdminCompagnieController extends Controller
{
  public function add(Request $request)
  {
    $id = session('id');
    if ($request->isMethod('post')) {
      $data = $request->all();
      $denomination = $data['denomination'];
      $pseudo = $data['pseudo'];
      $telephone = $data['telephone'];
      $password = $data['password'];
      $codeInscription = getRamdomCode(5);
      if(User::where('pseudo','=',$pseudo)->get()->count() > 0){
        return redirect()->back()->with('flash_message_error', 'Ce pseudo est déjà utilisé par un autre utilisateur!');
      }
      $avatar = "/avatars/default.png";
      if ($request->hasfile('avatar')) {
        $imageIcon = $request->file('avatar');
        $exten = $imageIcon->getClientOriginalExtension();
        $imageIconName = $request->nom . uniqid() . '.' . $exten;
        $destinationPath = public_path('/avatars');
        $ulpoadImageSuccess = $imageIcon->move($destinationPath, $imageIconName);
        $avatar = "/avatars/" . $imageIconName;
      }
      User::create([
        'pseudo' => $pseudo,
        'type_user' => 3,
        'telephone' => $telephone,
        'avatar' => $avatar,
        'code_inscription' => $codeInscription,
        'token' => getRamdomText(15),
        'status' => 1,
        'password' => bcrypt($data['password'])
      ]);
      $currentUser = User::where(['pseudo' => $data['pseudo']])->first();
      Compagnie::create([
        'denomination' => $denomination,
        'user_id' =>  $currentUser->id
      ]);
      Journal::create([
        'action' => "Création de la Compagnie " . $denomination,
        'admin_id' => $id,
      ]);
      return redirect('/admin/add-compagnie')->with('flash_message_success', 'Nouvelle compagnie ajoutée avec succès!');
    }
    return view('pages.admin.dashboard.compagnies.add');
  }
  public function edit(Request $request,$idCompagnie)
  {
    $id = session('id');
    $compagnie = Compagnie::where(['id' => $idCompagnie])->first();
    if ($request->isMethod('post')) {
      $data = $request->all();
      $denomination = $data['denomination'];
      $pseudo = $data['pseudo'];
      $telephone = $data['telephone'];
      if(User::where('pseudo','=', $pseudo)->get()->count() > 0){
        $user = User::where('pseudo','=', $pseudo)->first();
        if($user->id != $compagnie->user->id){
          return redirect()->back()->with('flash_message_error', 'Ce pseudo est déjà utilisé par un autre utilisateur!');
        }
      }
      $avatar = $user->avatar;
      if ($request->hasfile('avatar')) {
        $imageIcon = $request->file('avatar');
        $exten = $imageIcon->getClientOriginalExtension();
        $imageIconName = $denomination . uniqid() . '.' . $exten;
        $destinationPath = public_path('/avatars');
        $ulpoadImageSuccess = $imageIcon->move($destinationPath, $imageIconName);
        $avatar = "/avatars/" .$imageIconName;
      }
      User::where(['id' => $compagnie->user->id])->update([
        'pseudo' => $pseudo,
        'avatar' => $avatar,
        'telephone' => $telephone,
      ]);
      Compagnie::where(['id' => $idCompagnie])->update([
        'denomination' => $denomination,
      ]);
      Journal::create([
        'action' => "Modification des infos de la Compagnie " . $denomination,
        'admin_id' => $id,
      ]);
      return redirect('/admin/edit-compagnie/'.$idCompagnie)->with('flash_message_success', 'Compagnie modifié avec succès!');
    }
    return view('pages.admin.dashboard.compagnies.edit')->with(compact('compagnie'));;
  }
  public function details(Request $request,$idCompagnie)
  {
    $id = session('id');
    $compagnie = Compagnie::where(['id' => $idCompagnie])->first();
    $destinations = DestinationCompagnie::where(['user_id' => $compagnie->user_id,'status'=>1])->orderBy('created_at','ASC')->get();
    return view('pages.admin.dashboard.compagnies.details')->with(compact('compagnie','destinations'));
  }
  public function statsDeparts(Request $request,$idDestination)
  {
   /* $id = session('id');
    $destination = DestinationCompagnie::where(['id' => $idDestination])->first();
    $recettes=  DB::table('reservations')
    ->select(DB::raw('DATE(date_reservation) as date'), DB::raw('SUM(prix_total_commission) as prix_total'), DB::raw('SUM(nbre_places) as nbre_places_total'))
    ->where('destination_id', '=', $idDestination)
    ->orderBy('date','DESC')
    ->groupBy('date')
    ->get();
    return view('pages.admin.dashboard.compagnies.stats_departs')->with(compact('destination','recettes'));
*/

    $id = session('id');
    $elements = array();
    $reservations = DB::TABLE('reservations')->distinct()
    ->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
    ->leftJoin('paiements','paiements.reservation_id','=','reservations.id')
    //->where('paiements.status', '=', 1)
    ->whereRaw(
      "(destinations_compagnie.id = ?)", 
      [$idDestination]
    )
    ->select(DB::raw('DATE(reservations.date_depart) as date_depart'),DB::raw('COUNT(reservations.id) as nbre_reservations'))
    ->orderBy('date_depart','DESC')
    ->groupBy('date_depart')
    ->get();

    foreach ($reservations as $reservation) {
      array_push($elements,array("date_depart"=>$reservation->date_depart,"nbre_reservations" => $reservation->nbre_reservations));
    }

    //dd($elements);

    $destination = DestinationCompagnie::where(['id' => $idDestination])->first();
    return view('pages.admin.dashboard.compagnies.stats_departs',compact('elements','destination'));

  }

  public function statsDepartsDetails(Request $request)
  {
    $id = session('id');
    if ($request->isMethod('post')) {
      $data = $request->all();
      $dateDepart = $data['date_depart'];
      $idDestination = $data['destination_id'];
      $elements = array();

      $destination = DestinationCompagnie::where(['id' => $idDestination])->first();
      $recettes=  DB::table('reservations')
      ->leftJoin('paiements','paiements.reservation_id','=','reservations.id')
      ->select(DB::raw('DATE(date_reservation) as date'), DB::raw('SUM(prix_total_commission) as prix_total'), DB::raw('SUM(nbre_places) as nbre_places_total'),DB::raw('ligne_destination_id as ligne_id'))
      ->where('destination_id', '=', $idDestination)
      ->where('reservations.date_depart', '=', $dateDepart)
      //->where('paiements.status', '=', 1)
      ->orderBy('date','DESC')
      ->groupBy('date','ligne_id')
      ->get();


      /*$recettesClients=  DB::table('reservations_clients')
      ->select(DB::raw('DATE(date_reservation) as date'), DB::raw('SUM(prix_total) as prix_total'), DB::raw('SUM(nbre_places) as nbre_places_total'))
      ->where('destination_id', '=', $idDestination)
      ->where('reservations_clients.date_depart', '=', $dateDepart)
      ->orderBy('date','DESC')
      ->groupBy('date')
      ->get();*/


      foreach ($recettes as $reservation) {
        array_push($elements,array("date"=>$reservation->date,"prix_total" => $reservation->prix_total,"ligne_id" => $reservation->ligne_id
      ,"nbre_places_total" => $reservation->nbre_places_total,"type_reservation" => 1));
      }
      /*foreach ($recettesClients as $reservation) {
        array_push($elements,array("date"=>$reservation->date,"prix_total" => $reservation->prix_total
      ,"nbre_places_total" => $reservation->nbre_places_total,"type_reservation" => 2));
      }*/

      return view('pages.admin.dashboard.compagnies.stats_departs_details')->with(compact('destination','elements','dateDepart'));

    }

  }
  public function show()
  {
    $id = session('id');
    $compagnies = Compagnie::all();
    return view('pages.admin.dashboard.compagnies.show', compact('compagnies'));
  }
  public function delete(Request $request, $idCompagnie)
  {
    $id = session('id');
    $compagnie = Compagnie::where(['id' => $idCompagnie])->first();
    Journal::create([
      'action' => "Suppression de la Compagnie" . " " . $compagnie->denomination,
      'admin_id' => $id,
    ]);
    User::where(['id' => $compagnie->user->id])->update([
      'status' => 99
    ]);
    foreach ($compagnie->user->destinationsCompagnie as $destination) {
     $destination->status = 0;
     $destination->save();
   }

   return redirect()->back()->with('flash_message_success', 'Compagnie supprimé avec succès!');
 }
}
