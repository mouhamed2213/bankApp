<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{


    public function index(){
        return view('compte.transaction.showDeposite');
    }
//
    public function storDeposit(Request $request){
        $amount = $request->input('amount');
        dd($amount);
    }

}
