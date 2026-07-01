<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::composer('*', function ($view) {
            $analystWorksheetCount = 0;

            if (Auth::check()) {
                $user = Auth::user();
                $userRole = $user->role;

                $query = DB::table('lf_06_02')
                    ->where('status', 3);

                if ($userRole == 2 || $userRole == 4) {
                  
                    $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"FIS\"')");
                } elseif ($userRole == 3) {
                    
                    $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"MIC\"')");
                } elseif ($userRole == 7) {
                 
                    $query->whereRaw("JSON_CONTAINS(lf_06_02.lab_unit, '\"CHEM\"')");
                } elseif ($userRole == 0) {
                   
                } else {
                    $query->whereRaw('1 = 0');
                }

                $analystWorksheetCount = $query->count();
            }

            $view->with('analystWorksheetCount', $analystWorksheetCount);
        });
    }
}
