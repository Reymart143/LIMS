<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaboratoryRecordController extends Controller
{
    public function index(){
        return view('LaboratoryRecord.index');
    }
}
