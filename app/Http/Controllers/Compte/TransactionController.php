<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Models\Compte\CompteBancaire;
use App\Service\TransfereService;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $transaction -> compte_source_id =   CompteBancaire::where('numero_compte',$choosedAccount)->value('id');

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


// Dans votre TransactionController.php (ou équivalent)

    public function createWithdraw()
    {
        // les comptes actifs
        $userAccounts = Auth::user()->comptes()->where('status', 'active')->get();

        // On passe ces comptes à la vue
        return view('compte.transaction.createWithdraw', [
            'userAccounts' => $userAccounts
        ]);
    }


    public function storeWithdraw(Request $request)
    {
        // 1. VALIDATION
        $validated = $request->validate([
            'compte_id' => 'required|integer|exists:compte_bancaire,id',
        ], [
            'compte_id.required' => 'Veuillez choisir un compte.',
            'withdraw.min' => 'Le montant minimum pour un retrait est de 1000 FCFA.',
        ]);

        $compteId = $validated['compte_id'];
        $montant =(int) $request-> input('withdraw');

        $compte = CompteBancaire::where('id', $compteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 3. RÈGLES MÉTIER
        if ($compte->status !== 'active') {
            return back()->with('error', 'Les retraits ne sont pas autorisés sur ce compte car il n\'est pas actif.');
        }
        if ($compte->solde < $montant) {
            return back()->with('error', 'Votre solde est insuffisant pour effectuer ce retrait.');
        }

        if ($compte->type_de_compte === 'epargne') {
            if ($compte->date_dernier_reset_retrait === null || $compte->date_dernier_reset_retrait->month != now()->month) {
                $compte->retraits_mensuels = 0;
                $compte->date_dernier_reset_retrait = now();
            }

            if ($compte->retraits_mensuels >= 2) {
                return back()->with('error', 'Vous avez atteint la limite de 2 retraits par mois pour ce compte épargne.');
            }
        }

        try {
            DB::transaction(function () use ($compte, $montant) {

                $compte->solde = $compte->solde - $montant;

                if ($compte->type_de_compte === 'epargne') {
                    $compte->retraits_mensuels = $compte->retraits_mensuels + 1 ;
                }
                $compte->save();

                $transAction = new  Transaction();

                $transAction -> compte_source_id = $compte->id;
                $transAction -> type_transaction = 'retrait';
                $transAction -> montant = $montant;
                $transAction -> save();

            });
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Une erreur technique est survenue. Veuillez réessayer.');
        }

        // 5. REDIRECTION
        return redirect()->route('user.index')
            ->with('success', "Retrait de " . number_format($montant) . " FCFA effectué avec succès sur le compte N°" . $compte->numero_compte . ".");
    }


    public function getUser(){
        return Auth::user();
    }



    public function getUserId(){
        return Auth::user()->id;
    }



}
