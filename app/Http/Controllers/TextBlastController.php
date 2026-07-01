<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextBlastController extends Controller
{
    public function index(){
        return view('textblast.index');
    }
}
