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
        return view('compte.transaction.showDeposite');
    }

    // displaye the transfere view form
    public function transferCreate(Request $request){
        return view('compte.transaction.create_transfere');
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
        return view('user.index');
    }


//
    public function storDeposit(Request $request){


        $type = "depot";
        $amount = $request->input('amount');
        $this->newBalance = $amount;

        // conditions
        $maxAmount = 2000000;
        $minAmount = 100;

        // get the firs caaount to the user
        $compteId = Auth::user()->with('comptes')->find($this->getUserId())->comptes[0]->id;
        $sold  = Transaction::where('compte_source_id',$compteId)->sum('montant');



        if($amount > $maxAmount || $amount < $minAmount){
            return back()->with("depotRejected", "Montant Maximum Depot : ".$maxAmount."\n Montant Minimum Depot : ".$minAmount);

        }else {
            // store trasaction
            $transaction = new Transaction();

            $transaction -> type_transaction  = $type;
            $transaction -> montant =  $amount ;

            $compte = $this->getAccount(); // balance

            if ($compte) {
                $compte->solde = $amount + $sold;
                $compte->save();
            }

            $transaction -> compte_source_id = $this->getAccount()->value('id');
            $transaction -> save(); // save if true
            return redirect()->route('user.index')->with("depotPassed", "Transfere reusissi");
        }
    }


    // handle withdraw
    public function withdraw(){
        $this->compteId = Auth::user()->comptes->first()->id;
//        $balancer = Transaction::where('compte_source_id',$this->compteId)->sum('montant');
        return view('compte.transaction.showWithdraw');
    }

    // handle withdraw
    public function storeWithdraw(Request $request){
        $userAcccount = $this->getAccount();
        $currentSolde = $userAcccount->solde;

        $amountWithdraw = $request->input('withdraw'); // amount to retrieve
        $type = 'withdraw';
        $accountId = $this->getAccount()->value('id');


        // check the min allowed to retrieve
        if( $amountWithdraw < 1000 ){
            return back() -> with('erroreAmount', 'Minimum montant autriser : 5000');
        }

        // check if the balance is enough
        if( $amountWithdraw > $currentSolde ){
            return back() -> with('balanceNotEnought', 'Solde inssufisant');
        }


        // Perfomr Transaction
        $newSolde = $currentSolde - $amountWithdraw;
        $transaction = new Transaction();
        $transaction -> type_transaction = $type;
        $transaction -> montant = $amountWithdraw;
//        dd($userAcccount->solde = $newSolde);
         $this -> getAccount()->update(
             ['solde' => $newSolde]
         );

        if(!$userAcccount){
            $userAcccount -> solde = $newSolde;
        }

        $transaction -> compte_source_id = $this -> getAccount()->value('id');
        $transaction -> save();

        return redirect()->route('user.index')->with("withdrawPassed", "Transfere reusissi");
    }


    public function getUser(){
        return Auth::user();
    }


    public function getAccount(){
        return CompteBancaire::where('user_id',$this -> getUser() -> id)->first();
    }


    public function getUserId(){
        return Auth::user()->id;
    }
}
