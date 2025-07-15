<?php

namespace App\Http\Controllers\virtualCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VirtualCardController extends Controller
{
    //-----------
    public function index(){
        return view('virtualCard.index');
    }
}
