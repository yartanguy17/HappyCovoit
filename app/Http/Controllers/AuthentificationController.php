<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Voyageur;
use App\Models\Chauffeur;

use telesign\sdk\messaging\MessagingClient;

class AuthentificationController extends Controller
{
  public function login(Request $request)
  {

    if ($request->isMethod('post')) {
      $data = $request->input();
      if (User::where(['pseudo' => $data['pseudo']])->first()) {
        $currentUser = User::where(['pseudo' => $data['pseudo']])->first();
        if (Hash::check($data['password'], $currentUser->password)) {
         session(['id' => $currentUser->id,
          'is_user' => 1,
          'is_compagnie' => 0,
          'pseudo' => $currentUser->pseudo,
          'type_user' => $currentUser->type_user]);
         if ($currentUser->status == 0) {
           return redirect('/user/confirm')->with('flash_message_error', 'Veuillez confirmer votre compte pour continuer!');
         }elseif ($currentUser->status == 99) {
           return redirect()->back()->with('flash_message_error', 'Désolé! Aucun compte relié à ses informartions!');
         }
         $process = session('process');
         if($process==1){
          session(['process' => 0]);
          $type_destination = session('type_destination');
          if($type_destination==1){
            session(['type_destination' => 0]);
            return redirect('/user/post-choice');
          }else{
            session(['type_destination' => 0]);
            return redirect('/user/post-choice-compagnie');
          }
        }
        return redirect('/user/dashboard');

      } else {
        return redirect()->back()->with('flash_message_error', 'Votre mot de passe invalide');
      }
    } else {
      return redirect()->back()->with('flash_message_error', 'Pseudo invalide! Veuillez réessayer');
    }
  }
  return view('pages.auth.login');
}
public function loginCompagnie(Request $request)
{
  if ($request->isMethod('post')) {
    $data = $request->input();
    if (User::where(['pseudo' => $data['pseudo']])->first()) {
      $currentUser = User::where(['pseudo' => $data['pseudo']])->first();
      if (Hash::check($data['password'], $currentUser->password)) {
       session(['id' => $currentUser->id,
        'is_user' => 0,
        'is_compagnie' => 1,
        'pseudo' => $currentUser->pseudo,
        'type_user' => $currentUser->type_user]);
       if ($currentUser->status == 99) {
         return redirect()->back()->with('flash_message_error', 'Désolé! Aucun compte relié à ses informations!');
       }

       return redirect('/user-compagnie/dashboard');

     } else {
      return redirect()->back()->with('flash_message_error', 'Votre mot de passe invalide');
    }
  } else {
    return redirect()->back()->with('flash_message_error', 'Pseudo invalide! Veuillez réessayer');
  }
}
return view('pages.auth.login_compagnie');
}
public function register(Request $request)
{
  if ($request->isMethod('post')) {
    $data = $request->input();
    if (!User::where(['pseudo' => $data['pseudo']])->first()) {
      if ($data['password'] == $data['confirm']) {
        $typeUser = $data['type_user'];
        $codeInscription = getRamdomCode(5);
        //dd($data['indicatif'] . $data['telephone']);
        $telephone = $data['telephone'];
        $indicatif = $data['indicatif'];
        if($indicatif == null or $indicatif == ""){
          $indicatif = substr($telephone, 0, 3);
        }
        User::create([
          'pseudo' => $data['pseudo'],
          'type_user' => $typeUser,
          'telephone' => $telephone,
          'avatar' => "default.png",
          'prenoms' => $data['prenoms'],
          'indicatif' => $data['indicatif'],
          'code_inscription' => $codeInscription,
          'token' => getRamdomText(15),
          'status' => 1,
          'password' => bcrypt($data['password'])
        ]);

        $customer_id = env('TELESIGN_ID');
        $api_key = env('TELESIGN_KEY');
        $phone_number = $telephone;
        sendSmsClickSend($phone_number, $codeInscription);
        //$message = 'Votre Code Confirmation Happy-Travel World est ' . $codeInscription;
        //$message_type = "ARN";
        //$messaging = new MessagingClient($customer_id, $api_key);
        //$response = $messaging->message($phone_number, $message, $message_type);
        //$response = sendSmsClickSend($phone_number, $codeInscription);
       // dd($response);

        /*$nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
          'to'   => $telephone,
          'from' => 'HTW',
          'text' => 'Votre Code Confirmation Happy-Travel World est ' . $codeInscription
        ]);*/
        $currentUser = User::where(['pseudo' => $data['pseudo']])->first();
        if($typeUser ==1){
          Voyageur::create([
            'email' => $data['email'],
            'nom' => $data['nom'],
            'prenoms' => $data['prenoms'],
            'user_id' =>  $currentUser->id
          ]);
        }else{
          Chauffeur::create([
            'nom' => $data['nom'],
            'prenoms' => $data['prenoms'],
            'user_id' =>  $currentUser->id
          ]);
        }
        session(['id' => $currentUser->id,
          'is_user' => 1,
          'pseudo' => $currentUser->pseudo,
          'type_user' => $currentUser->type_user]);
        
        return redirect('/user/confirm')->with('flash_message_success', 'Nous vous avons envoyé un code sur votre numéro de téléphone.Veuillez confirmer votre compte');
      } else {
        return redirect()->back()->with('flash_message_error', 'Mots de passes non valides');
      }
    } else {
      return redirect()->back()->with('flash_message_error', 'Pseudo déjà utilisé! Veuillez essayer un autre');
    }
  }
  return view('pages.auth.register');
}
public function forgetPassword(Request $request)
{
  if ($request->isMethod('post')) {
    $data = $request->input();
    if (User::where(['telephone' => $data['telephone']])->first()) {
      $currentUser = User::where(['telephone' => $data['telephone']])->first();
      $password = getRamdomText(10);
      sendSmsClickSendPassword($currentUser->telephone, $password);
      User::where(['id' => $currentUser->id])->update([
        'password' => bcrypt($password)
      ]);

      return redirect('/login')->with('flash_message_success', 'Mot de passe réinitialisé avec succès et envoyé sur votre téléphone mobile.');
    } else {
      return redirect()->back()->with('flash_message_error', 'Numéro de téléphone non enregistré! Veuillez réessayer');
    }
  }
  return view('pages.auth.forget');
}

public function confirm(Request $request)
{
 if ($request->isMethod('post')) {
  $data = $request->input();
  $id = session('id');
  $code = $data['code'];
  $currentUser = User::where(['id' => $id])->first();
  if ($currentUser->code_inscription == $code) {
    User::where(['id' => $id])->update([
      'status' => 1
    ]);
    $process = session('process');
         if($process==1){
          session(['process' => 0]);
          $type_destination = session('type_destination');
          if($type_destination==1){
            session(['type_destination' => 0]);
            return redirect('/user/post-choice')->with('flash_message_success', 'Votre compte a été crée et activé. Continuez votre opération');
          }else{
            session(['type_destination' => 0]);
            return redirect('/user/post-choice-compagnie')->with('flash_message_success', 'Votre compte a été crée et activé. Continuez votre opération');
          }
          
        }
    return redirect('/user/dashboard')->with('flash_message_success', 'Votre compte a été crée et activé.');
  } else {
    return redirect()->back()->with('flash_message_error', 'Code incorrect! Veuillez réessayer');
  }
}
return view('pages.auth.confirm');
}


public function sendCode(Request $request)
{
  $id = session('id');
  $codeInscription = getRamdomCode(5);
  $currentUser = User::where(['id' => $id])->first();
  $customer_id = env('TELESIGN_ID');
  $api_key = env('TELESIGN_KEY');
  $phone_number = $currentUser->telephone;
        //$message = 'Votre Code Confirmation Happy-Travel World est ' . $codeInscription;
        //$message_type = "ARN";
        //$messaging = new MessagingClient($customer_id, $api_key);
        //$response = $messaging->message($phone_number, $message, $message_type);
  sendSmsClickSend($phone_number, $codeInscription);

  User::where(['id' => $id])->update([
    'code_inscription' => $codeInscription
  ]);
  
  return redirect('/user/confirm')->with('flash_message_success', 'Nous vous avons envoyé un code sur votre numéro de téléphone.Veuillez confirmer votre compte');
}
}
