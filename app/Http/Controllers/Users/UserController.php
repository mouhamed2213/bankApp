<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{        private int  $userID;


    // return to view index
    public function index(){
        $userID = Auth::user()->id;
        // check if the user has account but account is on pending
        if(! Auth::user()->comptes->isEmpty()){

            $user = Auth::user()->id; // recupere l'id de lutilsateur connectee

            $userAccount = CompteBancaire::where('user_id',$user)->first();
            $accountStatut = $userAccount->status;

                if($accountStatut == "en attente"){
                    Request()->session()->put('statut', true);
                }
        }

        return $this->balance();
    }

    // get user balances
    public function balance(){
        $compteId = Auth::user()->comptes->first()->id;
        $balancer = Transaction::where('compte_source_id',$compteId)
            -> orderByDesc('id') // order by the most biuger id to the less
            ->value('solde'); // get the firs value

        $solde = $balancer;
            return view('user.index',compact('solde'));
    }


}
