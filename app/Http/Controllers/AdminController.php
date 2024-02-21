<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Admin;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
	public function add(Request $request)
	{
		$id = session('id');
		if ($request->isMethod('post')) {
			$data = $request->all();
			$email = $data['email'];
			if ($data['password'] == $data['c_password']) {
				Admin::create([
					'password' => bcrypt($data['password']),
					'email' => $email,
					'niveau' => $data['niveau']
				]);
				Journal::create([
					'action' => "Création de l'Administrateur " . $email,
					'admin_id' => $id,
				]);
				return redirect('/admin/add-admin')->with('flash_message_success', 'Nouvel administrateur ajouté avec succès!');
			} else {
				return redirect('/admin/add-admin')->with('flash_message_error', 'Mots de passe non identiques!');
			}
		}
		return view('pages.admin.dashboard.administrateurs.add');
	}
	public function edit(Request $request,$idAdmin)
	{
		$id = session('id');
		$admin = Admin::where(['id' => $idAdmin])->first();
		if ($request->isMethod('post')) {
			$data = $request->all();
			$email = $data['email'];
			Admin::where(['id' => $idAdmin])->update([
				'email' => $email,
				'niveau' => $data['niveau']
			]);

			if (isset($data['password']) && isset($data['c_password'])) {
				if ($data['password'] == $data['c_password']) {
					Admin::where(['id' => $idAdmin])->update([
                        'password' => bcrypt($data['password'])
                    ]);
				}else {
					return redirect()->back()->with('flash_message_error', 'Mots de passe non identiques!');
				}
			}

			Journal::create([
				'action' => "Modification des infos de l'Administrateur " . $email,
				'admin_id' => $id
			]);
			return redirect('/admin/edit-admin/'.$idAdmin)->with('flash_message_success', 'Administrateur modifié avec succès!');
		}
		return view('pages.admin.dashboard.administrateurs.edit')->with(compact('admin'));;
	}
	public function show()
	{
		$id = session('id');
		$admins = Admin::where(['status' =>1])->where('niveau','!=', 4)->get();
		return view('pages.admin.dashboard.administrateurs.show', compact('admins'));
	}
	public function delete(Request $request, $idAdmin)
	{
		$id = session('id');
		$admin = Admin::where(['id' => $idAdmin])->first();
		Journal::create([
			'action' => "Suppression de l'administrateur" . " " . $admin->email,
			'admin_id' => $id,
		]);
		$admin->delete();
		return redirect()->back()->with('flash_message_success', 'Administrateur supprimé avec succès!');
	}
}
