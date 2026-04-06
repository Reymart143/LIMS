<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
  public function login_user(Request $request){
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {

        $user = DB::table('users')
            ->where('username', $request->get('username'))
            ->first();

        Session()->put([
            'isLogin' => 1,
            'username' => $request->get('username'),
            'pass' => $request->get('password'),
            'id' => $user->id
        ]);

        return redirect()->route('Dashboard')
            ->with('success', 'Login successful!');
    }

    $user = \App\Models\User::where('username', $request->username)->first();

    if ($user) {
        return redirect()->back()->with('error', 'Incorrect Password');
    } else {
        return redirect()->back()->with('error', 'User Not Found');
    }
}
public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();

        Session()->forget('isLogin');
		Session()->forget('username');
		Session()->forget('userPhoto');
		Session()->forget('region');
		Session()->forget('province');
		Session()->forget('municipality');
		Session()->forget('department');


		Session()->flush();

		Session()->put(['user'=>0,'islogin'=>0,'username'=>0,'id'=>0,'activeaccount'=>0]);

        return redirect()->route('login')->with('success', 'Logout Successfully');

    }

}
