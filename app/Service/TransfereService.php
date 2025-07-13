<?php

namespace App\Service;
//app/Models/Service/TransfereService.php
use App\Models\Compte\CompteBancaire;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransfereService
{
    // make virements
    public function store(Request $request){

        $store = false;
        $recipientAccount = request("recipient");
        $transferAmount = $request->input('amount');

        // 1 get the user  information
        $current_user = Auth::user();

        // 2 get the first account if the user has more account (first)
        $account = CompteBancaire::where('user_id', $current_user->id)->first();

        // 3 getr the the id of the user account
        $accountID = $account ? $account->id : null;

        // 4 get the user account bank transaction informations
        $currentUserTransfere = Transaction::where('compte_source_id', $accountID);

        // 5 get the user  account balance
        $currentUserBalance = $currentUserTransfere
            ->orderByDesc('id')
            ->value('solde');

        // check if balance is enought
        if( $currentUserBalance < $transferAmount ){
            session()->put('balanceNotEnought', 'Solde insuffisant pour effectuer ce transfert');
            dd(session('balanceNotEnought'));
        }




        // 2  get the currenct user total balence
    }

}
