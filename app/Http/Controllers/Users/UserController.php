<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // return to view index
    public function index(){

        // check if the user has account but account is on pending
        if(! Auth::user()->comptes->isEmpty()){

            $user = Auth::user()->id; // recupere l'id de lutilsateur connectee
            $userAccount = CompteBancaire::where('user_id',$user)->first();
            $accountStatut = $userAccount->status;

                if($accountStatut == "en attente"){
                    Request()->session()->put('statut', true);
                }

        }

        return view('user.index');
    }


}
