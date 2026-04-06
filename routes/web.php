<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QualityManualController;
use App\Http\Controllers\StandardOperatingProcedureController;
use App\Http\Controllers\LogFormController;
use App\Http\Controllers\WorkInstructionController;
use App\Http\Controllers\LaboratoryRecordController;


 Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('Dashboard');
        }
        return view('auth.login');
        // return redirect('/homepage');
    })->name('login'); 
    Route::post('login-user',[LoginController::class,'login_user'])->name('login-user');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/Dashboard',[DashboardController::class,'Dashboard'])->name('Dashboard');
    Route::middleware('auth')->group(function () {
    Route::post('/save-settings', [UserController::class, 'UserSettings']);
    Route::get('/get-user-settings', [UserController::class, 'getSettings']);
    //System Users Information
    Route::get('/profile',[UserController::class,'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'userUpdate'])->name('profile/update');
    Route::put('user/upload/update', [UserController::class, 'imageUpdate'])->name('user/upload/update');
    Route::get('/users/index', [UserController::class, 'index'])->name('users/index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users/create');
    Route::post('users.store', [UserController::class, 'store'])->name('users.store');
    Route::get('users.edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users.details/{id}', [UserController::class, 'show'])->name('users.details');
    Route::put('/users.update', [UserController::class, 'update'])->name('users.update');
    Route::delete('user.delete/{id}', [UserController::class, 'hardDelete'])->name('users.delete');
    //Clients Information
    Route::get('/clients',[ClientController::class,'index'])->name('clients');
    Route::get('/create/clients', [ClientController::class, 'create'])->name('create/clients');
    Route::post('clients.store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('clients.edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients.update', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients.delete/{id}', [ClientController::class, 'hardDelete'])->name('clients.delete');
    Route::get('/kiosk-form',[ClientController::class,'kiosk_forms'])->name('kiosk-form');
    // Quality Manual
    Route::get('/QM/index',[QualityManualController::class,'index'])->name('QM/index');
    Route::get('/QM/QM1-00',[QualityManualController::class,'QM1-00'])->name('QM/QM1-00');
    //SOP
    Route::get('/SOP/index',[StandardOperatingProcedureController::class,'index'])->name('SOP/index');
     //Log Form
    Route::get('/LF/index',[LogFormController::class,'index'])->name('LF/index');
     //Laboratory Record
    Route::get('/LR/index',[LaboratoryRecordController::class,'index'])->name('LR/index');
     //Work Instruction
    Route::get('/WI/index',[WorkInstructionController::class,'index'])->name('WI/index');
});
