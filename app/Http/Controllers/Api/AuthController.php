<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Chauffeur;
use App\Models\Voyageur;
use App\Http\Resources\User as UserResource;
use telesign\sdk\messaging\MessagingClient;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$args = array();
		$userID = 1;
		$args['error'] = false;
		$args['status'] = false;
		$user = User::where(['pseudo' => $request->pseudo])->first();
		if ($user != null) {
			if (!Hash::check($request->password, $user->password)) {
				$args['error'] = true;
				$args['status'] = false;
				$args['error_message'] = "Mot de passe incorrect!";
			}else{
				try {
					$args['message'] = "Informations recupérées avec success";
					$args['user'] = new UserResource($user);
					$args['status'] = true;
				} catch (\Exception $e) {
					echo $e->getMessage();
					$args['error'] = true;
					$args['error_message'] = $e->errorInfo;
					$args['message'] = "Erreur lors de la recupération de vos informations";
				}
			}
			
		} else {
			try {
				$args['error'] = true;
				$args['status'] = false;
				$args['error_message'] = "Pseudo non trouvé!";
			} catch (\Exception $e) {
				$args['error'] = true;
				$args['error_message'] = $e->errorInfo;
				$args['message'] = "Erreur lors de l'enregistrement de vos informations";
			}
		}
		return response()->json($args);
	}
	public function register(Request $request)
	{
		$args = array();
		$args['error'] = false;
		$user = User::where('pseudo', '=', $request->pseudo)->first();
		if ($user != null) {
			$args['error'] = true;
			$args['error_message'] = "Pseudo déjà utilisé!";
			return response()->json($args, 200);
		}
		$user = new User();
		$codeInscription = getRamdomCode(5);
		try {
			$user->pseudo = $request->pseudo;
			$user->password = bcrypt($request->password);	
			$user->token = getRamdomText(15);
			$user->avatar = "/avatars/default.png";
			$user->type_user = $request->type_user;
			$user->status = 1;
			$user->save();
			$currentUser = User::where(['pseudo' => $request->pseudo])->first();
			if($request->type_user==1){
				Voyageur::create([
					'nom' => $request->nom,
					'prenoms' => $request->prenoms,
					'email' => $request->email,
					'user_id' =>  $currentUser->id
				]);
			}else{
				Chauffeur::create([
					'nom' => $request->nom,
					'prenoms' => $request->prenoms,
					'user_id' =>  $currentUser->id
				]);
				
			}
			
			$args['user'] = new UserResource($currentUser);
			$args['message'] = "Compte Voyageur crée avec succès";
		} catch (\Exception $e) {
			$args['error'] = true;
			$args['error_message'] = $e->getMessage();
			$args['message'] = "Erreur lors de l'enregistrement de vos informations";
		}

		return response()->json($args, 200);
	}

	public function sendCodeAuth(Request $request)
	{
		$args = array();
		$args['status'] = false;
		try {
			$value = sendSmsClickSend($request->telephone, $request->code_verification);
			$args['status'] = true;
		} catch (\Exception $e) {
			$args['status'] = true;
			$args['error_message'] = $e->getMessage();;
			$args['message'] = "Erreur lors de la modification";
		}

		return response()->json($args, 200);
	}
	/**
	 * @group  Api SaveInfos
	 *
	 */
	public function saveInfos(Request $request)
	{
		$args = array();
		$args['error'] = false;
		$args['status'] = true;
		$user = User::where('id', '=', $request->id)->first();
		if ($user == null) {
			$args['error'] = true;
			$args['status'] = false;
			$args['error_message'] = "Numéro de téléphone introuvable";
			return response()->json($args, 200);
		}
		try {
			$user->telephone = $request->telephone;
			$user->indicatif = $request->indicatif;
			$user->code_inscription = $request->code_verification;
			$user->save();
			$user =  User::where('id', '=', $request->id)->first();
			$args['user'] = new UserResource($user);
			$args['message'] = "Compte mis à jour avec succès";
		} catch (\Exception $e) {
			$args['error'] = true;
			$args['status'] = false;
			$args['error_message'] = $e->errorInfo;
			$args['message'] = "Erreur lors de l'enregistrement de vos informations";
		}

		return response()->json($args, 200);
	}

	public function updateInfos(Request $request)
	{
		try {
			$user = User::where('id', $request->id)->first();
			$status = false;
			if (!is_null($user)) {
				if($user->type_user==1){
					$voyageur = Voyageur::where('user_id', $request->id)->first();
					$voyageur->nom = $request->nom;
					$voyageur->prenoms = $request->prenoms;
					$voyageur->email = $request->email;
					$voyageur->save();
				}else{
					$chauffeur = Chauffeur::where('user_id', $request->id)->first();
					$chauffeur->nom = $request->nom;
					$chauffeur->prenoms = $request->prenoms;
					$chauffeur->immatriculation = $request->immatriculation;
					$chauffeur->type_vehicule = $request->type_vehicule;
					$chauffeur->save();	
				}
				$user->telephone = $request->telephone;
				$user->indicatif = substr($request->telephone, 0,4);
				if ($request->is_photo == 1) {
					$ImageData = $request->image;
					$ImageName = $request->name;

					$ImagePath = public_path('/avatars') . "/" . $ImageName;

					file_put_contents($ImagePath,base64_decode($ImageData));

					$user->avatar = "/avatars/" . $ImageName;
					$user->save();

				}
				$user->save();

				
				$status = true;
			} else {
				$user = null;
			}
		} catch (\Throwable $th) {
			return response()->json([
				'status' => $status,
				'message' => $th->getMessage(),
				'data' => new UserResource($user)
			]);
		}
		return response()->json([
			'status' => $status,
			'data' => new UserResource($user)
		]);
	}
	public function updateAvatar(Request $request)
	{
		try {
			$user = User::where('id', $request->id)->first();
			$status = false;
			if (!is_null($user)) {
					$ImageData = $request->image;
					$ImageName = $request->name;

					$ImagePath = public_path('/avatars') . "/" . $ImageName;

					file_put_contents($ImagePath,base64_decode($ImageData));

					$user->avatar = '/avatars/' . $ImageName;
					$user->save();

				$user->save();

				
				$status = true;
			} else {
				$user = null;
			}
		} catch (\Throwable $th) {
			return response()->json([
				'status' => $status,
				'message' => $th->getMessage(),
				'data' => new UserResource($user)
			]);
		}
		return response()->json([
			'status' => $status,
			'data' => new UserResource($user)
		]);
	}
	public function updateChauffeur(Request $request)
	{
		try {
			$user = User::where('id', $request->id)->first();
			$status = false;
			if (!is_null($user)) {
				if($user->type_user==2){
				$chauffeur = Chauffeur::where('user_id', $request->id)->first();
					$chauffeur->immatriculation = $request->immatriculation;
					$chauffeur->type_vehicule = $request->type_vehicule;
					$chauffeur->save();	
				}
				$user->save();

				
				$status = true;
			} else {
				$user = null;
			}
		} catch (\Throwable $th) {
			return response()->json([
				'status' => $status,
				'message' => $th->getMessage(),
				'data' => new UserResource($user)
			]);
		}
		return response()->json([
			'status' => $status,
			'data' => new UserResource($user)
		]);
	}

	public function updatePassword(Request $request)
	{
		try {
			$user = User::where('id', $request->id)->first();
			$status = false;
			if (!is_null($user)) { 
				if (Hash::check($request->old_password, $user->password)) {
					$user->password = bcrypt($request->password);
					$user->save();
					$status = true;
				}
			} else {
				$user = null;
			}
		} catch (\Throwable $th) {
			return response()->json([
				'status' => $status,
				'message' => $th->getMessage(),
				'data' => new UserResource($user)
			]);
		}
		return response()->json([
			'status' => $status,
			'data' => new UserResource($user),
			'id' => $request->id,
		]);
	}
	public function reinitializePassword(Request $request)
	{
		try {
			$user = User::where(['telephone' => $request->telephone])->first();
			$status = false;
			$password  = "";
			if (!is_null($user)) { 
				$password = getRamdomText(10);
				$value = sendSmsClickSendPassword($user->telephone, $password);
				User::where(['id' => $user->id])->update([
					'password' => bcrypt($password)
				]);
				$status = true;
			} else {
				$user = null;
			}
		} catch (\Throwable $th) {
			return response()->json([
				'status' => $status,
				'message' => $th->getMessage(),
				'data' => new UserResource($user)
			]);
		}
		return response()->json([
			'status' => $status,
			'telephone' => $request->telephone,
			'password' => $password
		]);
	}
}
