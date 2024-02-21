<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Admin;
use App\Models\User;
use App\Models\Voyageur;
use App\Models\Notification;
use App\Models\Compagnie;
use App\Models\MessageAdmin;
use App\Models\Souscription;
use App\Models\Chauffeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = session('id');
        $nbreUsers= User::all()->count();
        $nbreAchats = User::all()->count();
        $nbreVentes = User::all()->count();
        $users = Admin::all();
        return view('pages.admin.dashboard.index', compact('nbreUsers', 'nbreVentes', 'nbreAchats','users'));
    }

    public function logout(Request $request)
    {
        $id = session('id');
        if ($id != null) {
            Journal::create([
                'action' => "Déconnexion de la plateforme",
                'admin_id' => $id,
            ]);
        }
        Session::flush();
        return redirect('/admin');
    }


    public function changePassword(Request $request)
    {
        $id = session('id');
        if ($request->isMethod('post')) {
            $data = $request->all();
            $current_pwd = $data['c_password'];
            $admin = Admin::where(['id' => $id])->first();
            if (Hash::check($current_pwd, $admin->password)) {
                if ($data['n_password'] == $data['cn_password']) {
                    Admin::where(['id' => $id])->update([
                        'password' => bcrypt($data['n_password'])
                    ]);
                    Journal::create([
                        'action' => "Mise à jour du mot de passe",
                        'admin_id' => $id,
                    ]);
                    return redirect('/admin/change-password')->with('flash_message_success', 'Mot de passe mis à jour avec succès!');
                } else {
                    return redirect('/admin/change-password')->with('flash_message_error', 'Mots de passe non identiques!');
                }
            } else {
                return redirect('/admin/change-password')->with('flash_message_error', 'Mot de passe actuel invalide!');
            }

        }
        return view('pages.admin.dashboard.settings.change_password');
    }
    public function changePasswordCompagnie(Request $request, $idCompagnie)
    {
        $id = session('id');
        if ($request->isMethod('post')) {
            $data = $request->all();
            $compagnie = Compagnie::where(['id' => $idCompagnie])->first();
            if ($data['n_password'] == $data['cn_password']) {
                User::where(['id' => $compagnie->user->id])->update([
                    'password' => bcrypt($data['n_password'])
                ]);
                Journal::create([
                    'action' => "Mise à jour du mot de passe de la compagnie " . $compagnie->user->pseudo,
                    'admin_id' => $id,
                ]);
                return redirect()->back()->with('flash_message_success', 'Mot de passe mis à jour avec succès!');
            } else {
                return redirect()->back()->with('flash_message_error', 'Mots de passe non identiques!');
            }

        }
    }


    public function allChauffeurs()
    {
        $id = session('id');
        $chauffeurs = Chauffeur::all();
        return view('pages.admin.dashboard.chauffeurs.show', compact('chauffeurs'));
    }

    public function allVoyageurs()
    {
        $id = session('id');
        $voyageurs = Voyageur::all();
        return view('pages.admin.dashboard.voyageurs.show', compact('voyageurs'));
    }

    public function allMessagesVoyageurs()
    {
        $id = session('id');
        $messages = MessageAdmin::orderBy('created_at','DESC')->get();
        return view('pages.admin.dashboard.voyageurs.messages', compact('messages'));
    }

    public function allMessagesChauffeurs()
    {
        $id = session('id');
        $messages = MessageAdmin::orderBy('created_at','DESC')->get();
        return view('pages.admin.dashboard.chauffeurs.messages', compact('messages'));
    }

    public function markMessage(Request $request,$idMessage)
    {
        $id = session('id');

        $message = MessageAdmin::where(['id' => $idMessage])->first();
        $message->status = 1;
        $message->save();
        return redirect()->back()->with('flash_message_success', 'Message marqué comme lu avec succès!');
    }

    public function journaux()
    {
        $id = session('id');
        $journaux = Journal::orderBy('created_at','DESC')->get();
        return view('pages.admin.dashboard.others.journaux', compact('journaux'));
    }
    public function deleteUser(Request $request, $idUser)
    {
        $id = session('id');
        $user = User::where(['id' => $idUser])->first();
        Journal::create([
            'action' => "Suppression de l'utilisateur " . " " . $user->pseudo,
            'admin_id' => $id,
        ]);
        User::where(['id' => $idUser])->update([
            'status' => 99
        ]);
        foreach ($user->destinations as $destination) {
           $destination->status = 0;
           $destination->save();
       }

       return redirect()->back()->with('flash_message_success', 'Utilisateur supprimé avec succès!');
   }
   public function sendMessageVoyageursDetails(Request $request,$idVoyageur)
   {
    $id = session('id');
    $user = User::where(['id' => $idVoyageur])->first();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $message = $data['message'];
        Notification::create([
            'titre' => "Nouveau message Admin",
            'contenu' => $message,
            'user_id' => $user->id
        ]);
        return redirect()->back()->with('flash_message_success', 'Message envoyé avec succès!');
    }
}
public function sendMessageChauffeursDetails(Request $request,$idChauffeur)
{
    $id = session('id');
    $user = User::where(['id' => $idChauffeur])->first();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $message = $data['message'];
        Notification::create([
            'titre' => "Nouveau message Admin",
            'contenu' => $message,
            'user_id' => $user->id
        ]);
        return redirect()->back()->with('flash_message_success', 'Message envoyé avec succès!');
    }
}
public function sendMessageCompagniesDetails(Request $request,$idCompagnie)
{
    $id = session('id');
    $user = User::where(['id' => $idCompagnie])->first();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $message = $data['message'];
        Notification::create([
            'titre' => "Nouveau message Admin",
            'contenu' => $message,
            'user_id' => $user->id
        ]);
        return redirect()->back()->with('flash_message_success', 'Message envoyé avec succès!');
    }
}
public function verifyChauffeur(Request $request,$idChauffeur)
{
    $id = session('id');
    $chauffeur = Chauffeur::where(['id' => $idChauffeur])->first();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $cni = "";
        if ($request->hasfile('cni')) {
            $imageIcon = $request->file('cni');
            $exten = $imageIcon->getClientOriginalExtension();
            $imageIconName = $chauffeur->nom . uniqid() . '.' . $exten;
            $destinationPath = public_path('/cnis');
            $ulpoadImageSuccess = $imageIcon->move($destinationPath, $imageIconName);
            $cni = '/cnis/' . $imageIconName;
            Chauffeur::where(['id' => $idChauffeur])->update([
                'cni' => $cni,
                'status' => 1
            ]);
            return redirect()->back()->with('flash_message_success', 'Chauffeur vérifié avec succès!');
        }

    }
}
public function sendMessageVoyageurs(Request $request)
{
    $id = session('id');
    $users = User::where(['type_user' => 1,'status' => 1])->get();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $message = $data['message'];
        foreach ($users as $user) {
           Notification::create([
            'titre' => "Nouveau message Admin",
            'contenu' => $message,
            'user_id' => $user->id
        ]);
       }
       return redirect()->back()->with('flash_message_success', 'Message groupé envoyé avec succès!');
   }
}
public function sendMessageChauffeurs(Request $request)
{
    $id = session('id');
    $users = User::where(['type_user' => 2,'status' => 1])->get();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $message = $data['message'];
        foreach ($users as $user) {
           Notification::create([
            'titre' => "Nouveau message Admin",
            'contenu' => $message,
            'user_id' => $user->id
        ]);
       }
       return redirect()->back()->with('flash_message_success', 'Message groupé envoyé avec succès!');
   }
}
public function sendMessageCompagnies(Request $request)
{
    $id = session('id');
    $users = User::where(['type_user' => 3,'status' => 1])->get();
    if ($request->isMethod('post')) {
        $data = $request->all();
        $message = $data['message'];
        foreach ($users as $user) {
           Notification::create([
            'titre' => "Nouveau message Admin",
            'contenu' => $message,
            'user_id' => $user->id
        ]);
       }
       return redirect()->back()->with('flash_message_success', 'Message groupé envoyé avec succès!');
   }
}
public function allSouscriptionsAssurances()
{
    $id = session('id');
    $souscriptions = Souscription::where(['type' => 2])->get();
    return view('pages.admin.dashboard.souscriptions.assurances', compact('souscriptions'));
}
}
