<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            if (Admin::where(['email' => $data['email']])->first()) {
                $currentAdmin = Admin::where(['email' => $data['email']])->first();
                if (Hash::check($data['password'], $currentAdmin->password)) {
                    session(['id' => $currentAdmin->id,
                        'niveau' => $currentAdmin->niveau,
                        'is_admin' => 3,
                        'email' => $currentAdmin->email]);
                    Journal::create([
                        'action' => "Connexion de la plateforme",
                        'admin_id' => $currentAdmin->id,
                    ]);
                    return redirect('/admin/dashboard');
                    
                } else {
                    return redirect()->back()->with('flash_message_error', 'Votre mot de passe invalide');
                }
            } else {
                return redirect()->back()->with('flash_message_error', 'Email invalide! Veuillez réessayer');
            }
        }
        return view('pages.admin.index');
    }

}