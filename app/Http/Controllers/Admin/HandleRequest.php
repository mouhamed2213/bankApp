<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleRequest extends Controller
{



    public function requestsPending(){

        // get all user with account statut = en attente
        $userAccounstRequester =  Demande::with('comptes')

            ->where('statut', 'en attente')->get();
        return view('admin.requests',[
            'userAccounstRequester' => $userAccounstRequester,
        ]);
    }

    public function show($DemandeId)
    {
//        dd($DemandeId);

        $demande = Demande::with(['comptes.user'])->findOrFail($DemandeId);
        session(['typeDemande' => $demande->type]);

        $userRequestInfo = CompteBancaire::with(['user', 'demandes'])->findOrFail($demande->compte_id);
//        dd($userRequestInfo);

        return view('compte.show', [
            'demande' => $demande,
            'userRequestInfo' => $userRequestInfo,
        ]);
    }


    // the user account is accepted
    public function demande($DemandeId){
        $demande = Demande::with(['comptes.user'])->findOrFail($DemandeId);

        $typeDemande = session('typeDemande');
        $compte =  CompteBancaire::find($demande->compte_id);
        $solde = (int) $compte->value('solde');

        // check the demande is a clouser demande if true (check solde before validing it  )
        if($typeDemande === 'closure' && $solde <= 10){

            //            dd($typeDemande);
            $updateStatus = CompteBancaire::find($demande->compte_id);
            $updateStatus->status = 'fermer';
            $updateStatus->save();
            return redirect()->route('admin.dashboard')->with("demandeDeFermetureValider", 'Damande de fermeture valider ');
        }

        if($typeDemande == 'closure' && $solde > 10){
            // send mail
            dd($solde  . "   " . $demande->comptes->numero_compte ); ;

        }

        if($typeDemande == 'validation'){
            // update on request table
            $updateDemandeTable  =  Demande :: where('compte_id',$demande->compte_id)
                ->update([
                    'statut' => 'active',
                    'date_traitement' => now()
                ]);
            // update the state of the account state UPDATE BY INITILISINGF
            $update = CompteBancaire::findOrFail($demande->compte_id);
            $update -> status ="active";
            $update -> save();
            return redirect()->route('requests.requestsPending')->with('accountValidated', 'ok');
        }

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

    public function closure($id){

        $user = Auth::user()->role;

        if($user == 'client'){
            // store request on the demandes tables
            Demande::create([
                'compte_id' => $id,
                'date_demande' => now(),
                'type' => 'closure',
                'statut' => 'C_en attente',
            ]);
            return redirect()->route('user.index')->with('accountclosur', 'Votre demande de fermeture est en cours ');
        }
    }
}
