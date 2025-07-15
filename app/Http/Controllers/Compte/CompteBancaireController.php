<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Service\CompteBancaireService;
use App\Models\User;
use App\Models\Compte\CompteBancaire;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompteBancaireController extends Controller
{
    // display user compte bancarie info
    public function index(){
        $userDatas = CompteBancaireService::userDatas();
        return view('compte.index', compact('userDatas'));
    }

    public function switchAccount(Request $request){
        $switchAccount = $request -> input('active_account_id');
        // get the the selected account from the id
        session()->put('switchAccount', $switchAccount);
//        session()->put('active_account_id', $switchAccount);


        $selectedAccount = Auth::user() -> comptes  -> where("id", $switchAccount);
//        dd($selectedAccount->all());
        return view( 'user.index', compact('selectedAccount'));
    }


    public function indexCreateAccount(){
        $userDatas = CompteBancaireService::userDatas();
        return view('compte.createAccount', compact('userDatas'));
    }

    // show user bank account detaill
    public function show(Request $request){
            // one account
        $userData = CompteBancaireService::userData( $request->id );
        dd( $userData );
        return view('compte.show-user-detail');
    }

    // store bank information
    public function store (Request $request) {
        $userId = $request->input('id_user');
        $type_de_compte = $request->input('type_account');

        // store data
        $bankAccount  = new CompteBancaireService ();
        $bankAccount -> createBankAccount($userId);

        return redirect()->route('user.index')->with('success', 'Compte créé avec succès!');
    }

    public function storeAccount(Request $request){
        $userId = $request->input('id_user');
        // store data
        $bankAccount  = new CompteBancaireService ();
        $saved = $bankAccount -> createBankAccount($userId);
        if($saved){
            return redirect()->route('user.index')->with('accountCreated','Votre demande douverture de compte est en cour de validation');
        }
    }


    // Get All account status
    public static function UserAccounts(){
        $userAllInformation = CompteBancaire::with('user')->where( 'user_id',Auth::user()->id) ->get();
        return $userAllInformation;
    }



    function calculerRIB($codeBanque, $codeGuichet, $numeroCompte) {
        $rib = $codeBanque . $codeGuichet . $numeroCompte;
        $cle = 97 - ($rib % 97); // Clé de contrôle très simplifiée
        return str_pad($cle, 2, '0', STR_PAD_LEFT); // Ajoute 0 devant si nécessaire
    }



}

