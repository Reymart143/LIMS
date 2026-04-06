<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSetting;

class DashboardController extends Controller
{
    public function Dashboard(Request $request){
        $settings = null;
    if(Auth::check()){
        $settings = UserSetting::where('user_id', Auth::id())->first();
        return view('dashboard.dashboard');
    }else{
        Auth::logout();
            return redirect('/login')->with('error', 'End Session, Automatic Logout');
        }
    }
}
