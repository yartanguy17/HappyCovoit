<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\News;
use App\Models\Souscription;
use App\Models\Notification;
use App\Models\MessageAdmin;
use Illuminate\Support\Facades\Hash;
use Session;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        $id = session('id');
        $news = News::where(['status' =>1])->get();
        $notifications = Notification::where(['user_id' =>$id])->get();
        $messages = MessageAdmin::where(['user_id' =>$id])->get();
        $souscriptions = Souscription::where(['user_id' => $id])->orderBy('date_souscription','DESC')->get();
        return view('pages.user.dashboard.index', compact('souscriptions','news','notifications','messages'));
    }

    public function logout(Request $request)
    {
        $id = session('id');
        Session::flush();
        return redirect('/login');
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
        return view('pages.user.dashboard.change_password');
    }

    public function profile(Request $request)
    {
        $id = session('id');
        $user = User::where(['id' => $id])->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            
        }
        return view('pages.user.dashboard.settings.profile',compact('user'));
    }

    public function changeCni(Request $request)
    {
        $id = session('id');
        $user = User::where(['id' => $id])->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            
        }
        return view('pages.user.dashboard.settings.cni',compact('user'));
    }
}
