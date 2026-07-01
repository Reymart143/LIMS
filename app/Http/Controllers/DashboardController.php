<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSetting;
use DB;
class DashboardController extends Controller
{
    public function Dashboard(Request $request){
        $settings = null;
        if(Auth::check()){
            $monthlyRla = DB::table('lf_06_02')
            ->selectRaw('MONTH(created_at) as month')
            ->selectRaw('COUNT(*) as total_rla')
            ->selectRaw('SUM(CASE WHEN status = 8 THEN 1 ELSE 0 END) as total_release')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

            $months = [];
            $totalRla = [];
            $totalRelease = [];

            foreach (range(1, 12) as $month) {
                $record = $monthlyRla->firstWhere('month', $month);

                $months[] = date('M', mktime(0, 0, 0, $month, 1));
                $totalRla[] = $record ? (int) $record->total_rla : 0;
                $totalRelease[] = $record ? (int) $record->total_release : 0;
            }

        $settings = UserSetting::where('user_id', Auth::id())->first();
        return view('dashboard.dashboard', compact(
                'months',
                'totalRla',
                'totalRelease'
            ));
    }else{
        Auth::logout();
            return redirect('/login')->with('error', 'End Session, Automatic Logout');
        }
    }
}
