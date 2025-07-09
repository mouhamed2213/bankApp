<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Compte\CompteBancaire;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CompteBancaireController extends Controller
{

    // store bank information
    public function store (Request $request) {


        $id_user = $request->input('id_user');
        $type_de_compte = $request->input('type_account');

        // store data
        $compte_bancaire = new CompteBancaire();
        $compte_bancaire->numero_compte = str_pad( mt_rand(1,15), 11, '0', STR_PAD_LEFT );
        $compte_bancaire->code_banque = str_pad( mt_rand(1,10000), 5, '0', STR_PAD_LEFT );
        $compte_bancaire->code_guichet = str_pad( mt_rand(1,10000), 5,  "0", STR_PAD_LEFT );
        $compte_bancaire->RIB = str_pad(mt_rand(1,10), 2, "0", STR_PAD_LEFT);
        $compte_bancaire->solde  =  00.0;
        $compte_bancaire->type_de_compte = 'courant';
        $compte_bancaire->status = 'en attente' ;
        $compte_bancaire->user_id = $id_user;
//        $compte_bancaire->save();

        $this->setSessionAccountState($request, $compte_bancaire->status );

    }

    public function setSessionAccountState (Request $request, string $state) {
        if($state !== "actif"){
            $request->session()->put('session_account_state', true);   // use this this cession to dispay a wiatng message
            return redirect()->route('user.index');
        }
    }
}
