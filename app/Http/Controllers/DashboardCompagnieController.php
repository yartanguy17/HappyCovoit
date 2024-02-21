<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\Compagnie;
use App\Models\ClientSubscribeCompagnie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class DashboardCompagnieController extends Controller
{
    public function index(Request $request)
    {
        $id = session('id');
        return view('pages.user.dashboard.compagnie.index');
    }

    public function logout(Request $request)
    {
        $id = session('id');
        Session::flush();
        return redirect('/login-compagnie');
    }


    public function changePassword(Request $request)
    {
        $id = session('id');
        if ($request->isMethod('post')) {
            $data = $request->all();
            $current_pwd = $data['c_password'];
            $user = User::where(['id' => $id])->first();
            if (Hash::check($current_pwd, $user->password)) {
                if ($data['n_password'] == $data['cn_password']) {
                    User::where(['id' => $id])->update([
                        'password' => bcrypt($data['n_password'])
                    ]);
                    return redirect()->back()->with('flash_message_success', 'Mot de passe mis à jour avec succès!');
                } else {
                    return redirect()->back()->with('flash_message_error', 'Mots de passe non identiques!');
                }
            } else {
                return redirect()->back()->with('flash_message_error', 'Mot de passe actuel invalide!');
            }

        }
        return view('pages.user.dashboard.compagnie.change_password');
    }

    public function messages()
    {
        $id = session('id');
        $messages = Notification::where(['user_id' => $id])->orderBy('created_at','DESC')->get();
        return view('pages.user.dashboard.compagnie.messages', compact('messages'));
    }

    public function allVoyageurs()
    {
        $id = session('id');
        $voyageurs = DB::TABLE('reservations')->distinct()
        ->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
        ->join('users','users.id','=','reservations.user_id')
        ->join('voyageurs','voyageurs.user_id','=','users.id')
        ->whereRaw(
          "(destinations_compagnie.user_id = ?)", 
          [$id]
      )
        ->select('voyageurs.nom as nom','voyageurs.prenoms  as prenoms','users.telephone  as telephone','users.id  as id')
        ->orderBy('voyageurs.nom','DESC')
        ->get();
        return view('pages.user.dashboard.compagnie.voyageurs', compact('voyageurs'));
    }

    public function sendMessageVoyageurs(Request $request)
    {
        $id = session('id');
        $compagnie = Compagnie::where(['user_id' => $id])->first();
        $users = DB::TABLE('reservations')->distinct()
        ->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
        ->join('users','users.id','=','reservations.user_id')
        ->join('voyageurs','voyageurs.user_id','=','users.id')
        ->whereRaw(
          "(destinations_compagnie.user_id = ?)", 
          [$id]
      )
        ->select('voyageurs.nom as nom','voyageurs.prenoms  as prenoms','users.telephone  as telephone','users.id  as id')
        ->orderBy('voyageurs.nom','DESC')
        ->get();
        if ($request->isMethod('post')) {
            $data = $request->all();
            $message = $data['message'];
            foreach ($users as $user) {
             Notification::create([
                'titre' => "Nouveau message " . $compagnie->denomination,
                'contenu' => $message,
                'user_id' => $user->id
            ]);
         }
         return redirect()->back()->with('flash_message_success', 'Message groupé envoyé avec succès!');
     }
 }

 public function sendMessageVoyageursDetails(Request $request,$idVoyageur)
 {
    $id = session('id');
    $compagnie = Compagnie::where(['user_id' => $id])->first();
    $user = DB::TABLE('reservations')->distinct()
    ->join('destinations_compagnie','destinations_compagnie.id','=','reservations.destination_id')
    ->join('users','users.id','=','reservations.user_id')
    ->join('voyageurs','voyageurs.user_id','=','users.id')
    ->whereRaw(
      "(destinations_compagnie.user_id = ?)", 
      [$id]
  )->whereRaw(
      "(users.id = ?)", 
      [$idVoyageur]
  )
  ->select('voyageurs.nom as nom','voyageurs.prenoms  as prenoms','users.telephone  as telephone','users.id  as id')
  ->first();
  if ($request->isMethod('post')) {
    $data = $request->all();
    $message = $data['message'];
    Notification::create([
        'titre' => "Nouveau message " . $compagnie->denomination,
        'contenu' => $message,
        'user_id' => $user->id
    ]);
    return redirect()->back()->with('flash_message_success', 'Message envoyé avec succès!');
}
}

 public function sendMessageAbonnes(Request $request)
    {
        $id = session('id');
        $compagnie = Compagnie::where(['user_id' => $id])->first();
        $abonnes = ClientSubscribeCompagnie::where(['compagnie_id' =>$compagnie->id])->get();
        if ($request->isMethod('post')) {
            $data = $request->all();
            $message = $data['message'];
            foreach ($abonnes as $abonne) {
             Notification::create([
                'titre' => "Nouveau message " . $compagnie->denomination,
                'contenu' => $message,
                'user_id' => $abonne->client->id
            ]);
         }
         return redirect()->back()->with('flash_message_success', 'Message groupé envoyé avec succès!');
     }
 }

 public function sendMessageAbonnesDetails(Request $request,$idAbonne)
 {
    $id = session('id');
    $compagnie = Compagnie::where(['user_id' => $id])->first();
    $abonne = ClientSubscribeCompagnie::where(['compagnie_id' =>$compagnie->id,'client_id' =>$idAbonne])->first();
  if ($request->isMethod('post')) {
    $data = $request->all();
    $message = $data['message'];
    Notification::create([
        'titre' => "Nouveau message " . $compagnie->denomination,
        'contenu' => $message,
        'user_id' => $abonne->client->id
    ]);
    return redirect()->back()->with('flash_message_success', 'Message envoyé avec succès!');
}
}

}
