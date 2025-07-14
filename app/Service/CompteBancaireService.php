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
//        dd("CURENT USER ID " . $user);

        // get user accounts depending on the user Id
        $UserAccount = CompteBancaire::with('user')->where('user_id', $user)->get();
//        $userI = Auth::user()-> with('comptes')->whereId(Auth::id())->first();
        return $UserAccount;
    }

    // get one user account
    public static function userData($UserId){
        // get one  user accounts
        $UserAccount = CompteBancaire::where( 'id', $UserId )->get();
        return $UserAccount;
    }


}
