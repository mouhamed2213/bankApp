<?php

namespace App\Service;

use App\Models\Compte\CompteBancaire;
use Illuminate\Support\Facades\Auth;

class CompteBancaireService
{
    // geet the cuirrent user bank account and personnal inforamtion
    public static function userDatas()
    {
        $user = Auth::id();

        // get user accounts depending on the user Id
        $UserAccount = CompteBancaire::with('user')->where('user_id', $user)->get();
        return $UserAccount;
    }

    // get one user account
    public static function userData($UserId){
        // get one  user accounts
        $UserAccount = CompteBancaire::where( 'id', $UserId )->get();
        return $UserAccount;
    }


    // create bansk account
    public  function createBankAccount($UserId){

        $compte_bancaire = new CompteBancaire();
        $compte_bancaire->numero_compte = str_pad( mt_rand(1,15), 11, '5', STR_PAD_LEFT );
        $compte_bancaire->code_banque = str_pad( mt_rand(1,10000), 5, '2', STR_PAD_LEFT );
        $compte_bancaire->code_guichet = str_pad( mt_rand(1,10000), 5,  "4", STR_PAD_LEFT );
        $compte_bancaire->RIB = str_pad(mt_rand(1,10), 2, "0", STR_PAD_LEFT);
        $compte_bancaire->solde  =  00.0;
        $compte_bancaire->type_de_compte = 'courant';
        $compte_bancaire->status = 'en attente' ;
        $compte_bancaire->user_id = $UserId;

        return $compte_bancaire->save();
    }
}
