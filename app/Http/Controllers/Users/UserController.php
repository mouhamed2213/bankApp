<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Compte\CompteBancaireController;
use App\Models\Compte\CompteBancaire;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{        private int  $userID;


    // return to view index
    public function index(){
        $userId = Auth::user()->id;

        // this is sesstion is set for when the user want to change account
        // if the index is called this should be deleted

        return  view('user.index');
    }

    public function switchAccount(Request $request){
        $switchAccount = $request -> input('active_account_id');
        // get the the selected account from the id
        // this id is use to the ViewService Provider
        session()->put('switchAccount_id', $switchAccount);
//        session()->put('active_account_id', $switchAccount);
        return view( 'user.index');
    }
}
