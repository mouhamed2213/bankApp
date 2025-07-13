<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Service\TransfereService;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /*  TO STARE
        Whene the user make transfer we shoulf check if the balansce is enougn t=o perm that transfere
            if note we should send a messagge

            with "  dd(session('balanceNotEnought'));"  he's debug method is displayed
            but  the page is reditec even with the controle in $this->> controller

     *
     *
     * */

    public function index(){
        return view('compte.transaction.showDeposite');
    }

    // displaye the transfere view form
    public function transferCreate(Request $request){
        return view('compte.transaction.create_transfere');
    }

    // handle transfere
    public function transferStor(Request $request,  TransfereService $transaction){
        if(session('balanceNotEnought') !== null){
            return back()->with('balanceNotEnought', 'Sole inssufisant pour effecter se transfere');
        }

        $transaction->store($request);
    }


//
    public function storDeposit(Request $request){
        $userId = Auth::user()->id ;

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
            $transaction -> solde = $amount + $sold ;
            $transaction -> compte_source_id = $this->getAccountId();
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

        $amountWithdraw = $request->input('withdraw'); // amount to retrieve
        $type = 'withdraw';
        $accountId = $this->getAccountId();
        $currentSolde = Transaction::where('compte_source_id',$accountId)
            ->orderBy('id','desc')
            ->value('solde');

        // check the min allowed to retrieve
        if( $amountWithdraw < 1000 ){
            return back() -> with('erroreAmount', 'Minimum montant autriser : 5000');
        }

        // check if the balance is enough
        if( $amountWithdraw > $currentSolde ){
            return back() -> with('balanceNotEnought', 'Solde inssufisant');
        }


        // Perfomr Transaction
        $newSole = $currentSolde - $amountWithdraw;
        $transaction = new Transaction();
        $transaction -> type_transaction = $type;
        $transaction -> montant = $amountWithdraw;
        $transaction -> solde = $newSole;
        $transaction -> compte_source_id = $this -> getAccountId();
        $transaction -> save();

        return redirect()->route('user.index')->with("withdrawPassed", "Transfere reusissi");
    }



    public function getAccountId(){
        $userId = Auth::user()->id;
        return Auth::user()->with('comptes')->find($userId)->comptes[0]->id;
    }

    public function getUserId(){
        return Auth::user()->id;
    }
}
