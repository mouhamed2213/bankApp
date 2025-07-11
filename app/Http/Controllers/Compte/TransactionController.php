<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{


    public function index(){
        return view('compte.transaction.showDeposite');
    }
//
    public function storDeposit(Request $request){
        $amount = $request->input('amount');
        $type = "depot";
        $userId = Auth::user()->id ;
        $maxAmount = 2000000;
        $minAmount = 1000;

        // get the firs caaount to the user
        $compteId = Auth::user()->with('comptes')->find($userId)->comptes[0]->id;

        // store trasaction
        $transaction = new Transaction();
        $transaction -> type_transaction  = $type;
        $transaction -> montant = $amount;
        $transaction -> compte_source_id = $compteId;

        if(  $amount > $maxAmount || $amount < $minAmount){
            return back()->with("depotRejected", "Montant Maximum Depot : ".$maxAmount."\n Montant Minimum Depot : ".$minAmount);

        }else {

            $transaction -> save(); // save if true
            return redirect()->route('user.index')->with("depotPassed", "Transfere reusissi");
        }
    }


    // handle withdraw
    public function withdraw(){
        $compteId = Auth::user()->comptes->first()->id;
        $balancer = Transaction::where('compte_source_id',$compteId)->sum('montant');

        return view('compte.transaction.showWithdraw');
    }

    // handle with draw
    public function storeWithdraw(Request $request){
            $request->validate([]);

            $ammount = $request->input('amount');

            dd($ammount);

            $type = "withdraw";
            $minWithdraw = 10000;
            $maxWithdraw = 3000000;
            $message =  "Maximu retrait ".$ammount."\n Minimum retrait ".$minWithdraw;

            if( $ammount  > $maxWithdraw || $ammount < $minWithdraw){
                return back()->with('erroreAmount' , $message);
            }else{
                return back()->with('erroreAmount' , $message);
            }

    }
}
