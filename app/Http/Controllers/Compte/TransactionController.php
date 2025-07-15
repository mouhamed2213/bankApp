<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Service\TransfereService;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function index(){
        $userId = Auth::user()->id;
        $userAccount = CompteBancaire::where('user_id',$userId)->get();
        return view('compte.transaction.showDeposite', compact('userAccount'));
    }

    // displaye the transfere view form
    public function transferCreate(Request $request){
        $userId = Auth::user()->id;
        $userAccount = CompteBancaire::where('user_id',$userId)->get();
        return view('compte.transaction.create_transfere', compact("userAccount"));
    }
    // handle transfere
    public function transferStor(Request $request,  TransfereService $transaction){

        $transaction->store($request);
        $valide = false;
        if(session('balanceNotEnought') !== null){
            return back();
        }

        if(session('accountNotExist') !== null){
            return back();
        }

        // performa the transfere
        $transaction ->  transferToRecipient($request);
        return redirect()->route('user.index');
    }


    // Handle Deposite
    public function storDeposit(Request $request){
        $statut = CompteBancaireController::UserAccounts();

        // conditions max min
        $maxAmount = 2000000;
        $minAmount = 1000;

        $type = "depot";
        $amount = $request->input('amount');         // amount to deposit
        $choosedAccount = $request->choosedAccount; // choosed account to perform bank operations


        $accountDetail = CompteBancaire::where('numero_compte', $choosedAccount); // return current account balance
        $accountSold = CompteBancaire::where('numero_compte', $choosedAccount)->value('solde'); // return current account balance

        if($amount > $maxAmount || $amount < $minAmount){
            return back()->with("depotRejected", "Montant Maximum Depot : ".$maxAmount."\n Montant Minimum Depot : ".$minAmount);

        }else {
            // store trasaction
            $transaction = new Transaction();
            $transaction -> type_transaction  = $type;
            $transaction -> montant =  $amount ;
            $transaction -> compte_source_id = $this->getAccount()->value('id');

            if ($accountDetail) {
                $newAccountSold = $amount + $accountSold;
                $accountDetail->update(
                    [ 'solde' => $newAccountSold ],
                );
                $transaction -> save(); // save if true
            }

            return redirect()->route('user.index')
                ->with("depotPassed", "Depot reuissi  reusissi \n".
                    "Montant : ".$amount.' Fcfa'.
                    "Solde : ".$newAccountSold. ' Fcfa'.
                    "Depot effectuer sur : ".$accountDetail->value('numero_compte'));
        }
    }


    // handle withdraw
    public function createWithdraw(){
        $userAccount  = Auth::user()->comptes;
        return view('compte.transaction.createWithdraw', compact('userAccount'));
    }

    // handle withdraw
    public function storeWithdraw(Request $request){

        $choosedAccount = $request -> input('choosedAccount');
        $userAcccount = $this->getAccount($choosedAccount);
        $currentSolde = $this->getAccount($choosedAccount)->value('solde'); // get the user account balance

        $amountWithdraw = $request->input('withdraw'); // amount to retrieve
        $type = 'withdraw';

        // check the min allowed to retrieve
        if( $amountWithdraw < 1000 ){
            return back() -> with('erroreAmount', 'Minimum montant autriser : 5000');
        }

        // check if the balance is enough
        if( $amountWithdraw > $currentSolde ){
            return back() -> with('balanceNotEnought', 'Solde inssufisant');
        }        // check if the balance is enough

        if( $choosedAccount  == "Choisir un compte" ){
            return back() -> with('chooseAccount', 'Veuillez choisir un compte ');
        }

        // Perfomr Transaction
        $newSolde = $currentSolde - $amountWithdraw;
        $transaction = new Transaction();
        $transaction -> type_transaction = $type;
        $transaction -> montant = $amountWithdraw;
         $this -> getAccount($choosedAccount)->update(
             ['solde' => $newSolde]
         );

        if(!$userAcccount){
            $userAcccount -> solde = $newSolde;
        }

        $transaction -> compte_source_id = $this -> getAccount($choosedAccount)->value('id');
        $transaction -> save();

        return redirect()->route('user.index')
            ->with("withdrawPassed", "Vous avez retirer".
                $amountWithdraw . ' Fcfa.'.
                ' Dans votre compte : '.$choosedAccount.
                '. Solde : '.$newSolde);
    }


    public function getUser(){
        return Auth::user();
    }

    public function getAccount($choosedAccount){
        return  CompteBancaire::where('numero_compte',$choosedAccount);
    }


    public function getUserId(){
        return Auth::user()->id;
    }



}
