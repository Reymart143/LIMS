<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StandardOperatingProcedureController extends Controller
{
    public function index(){
        return view('SOP.index');
    }
}
