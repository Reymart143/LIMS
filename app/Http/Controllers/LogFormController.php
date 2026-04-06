<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogFormController extends Controller
{
    public function index(){
        return view('LogForm.index');
    }
}
