<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Compte\CompteBancaire;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CompteBancaireController extends Controller
{
    public function index(){
        return view('compte.index');
    }


    // store bank information
    public function store (Request $request) {


        $id_user = $request->input('id_user');
        $type_de_compte = $request->input('type_account');

        // store data
        $compte_bancaire = new CompteBancaire();
        $compte_bancaire->numero_compte = str_pad( mt_rand(1,15), 11, '5', STR_PAD_LEFT );
        $compte_bancaire->code_banque = str_pad( mt_rand(1,10000), 5, '2', STR_PAD_LEFT );
        $compte_bancaire->code_guichet = str_pad( mt_rand(1,10000), 5,  "4", STR_PAD_LEFT );
        $compte_bancaire->RIB = str_pad(mt_rand(1,10), 2, "0", STR_PAD_LEFT);
        $compte_bancaire->solde  =  00.0;
        $compte_bancaire->type_de_compte = 'courant';
        $compte_bancaire->status = 'en attente' ;
        $compte_bancaire->user_id = $id_user;
//        $compte_bancaire->save();

//        return view('user.index');
        return redirect()->route('user.index')->with('success', 'Compte créé avec succès!');


    }

    function calculerRIB($codeBanque, $codeGuichet, $numeroCompte) {
        $rib = $codeBanque . $codeGuichet . $numeroCompte;
        $cle = 97 - ($rib % 97); // Clé de contrôle très simplifiée
        return str_pad($cle, 2, '0', STR_PAD_LEFT); // Ajoute 0 devant si nécessaire
    }

}

