<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Models\Demande;
use Illuminate\Http\Request;

class HandleRequest extends Controller
{

    public function requestsPending(){

        // get all user with account statut = en attente
        $userAccounstRequester = CompteBancaire::with('user')->where('status', 'en attente')->get();
        $demandes = Demande::with('comptes')->where('statut', 'en attente')->get();

        return view('admin.requests',[
            'userAccounstRequester' => $userAccounstRequester,
            'demandes' => $demandes
        ]);
    }

    //    Show one infomation acccount
    public function show($id){
        $userRequestInfo = CompteBancaire::with('user')->where('id', $id)->findOrFail($id);
        $demande = Demande::with('comptes')->get();

        return view('compte.show', [
            'userRequestInfo' => $userRequestInfo,
            'demande' => $demande
        ]);
    }



    // the user account is accepted
    public function validated($id){
        // UPDATE DIRECTLY UPDATE BY INITILISINGF
        // update on request table
        $updateDemandeTable  =  Demande :: where('compte_id',$id)
            ->update([
                'statut' => 'active',
                'date_traitement' => now()
                ]);

        if($updateDemandeTable){

            // update the state of the account state UPDATE BY INITILISINGF
            $update = CompteBancaire::findOrFail($id);
            $update -> status ="active";
            $update -> save();
        }

        return redirect()->route('requests.requestsPending')->with('accountValidated', 'ok');
    }

    // rejected account
    public function rejected($id){

        // update the state of the account state
        $update = CompteBancaire::findOrFail($id);
        $update -> status ="rejected";
//            $update -> save();
        return redirect()->route('requests.requestsPending')
            ->with('rejected_accoute', 'la demande d\'ouvertur de compte n a pas ete accepter');
    }



}
