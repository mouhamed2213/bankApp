<?php

namespace App\Service;
//app/Models/Service/TransfereService.php
use App\Models\Compte\CompteBancaire;
use App\Models\compte\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransfereService
{
        private $store = true;
    public function store(Request $request){
        // Get inputs
        $recipientAccount = request("recipient");
        $transferAmount = $request->input('amount');
        $choosedAccount = $request->input("choosedAccount");



        // get the recipient account if exist
        $recipientAccountNumber = $this->currentRecipientAccount($recipientAccount);
        //  get the user  account balance
        $currentUserBalance = $this->currentAccount($choosedAccount)->value('solde');

        // Check Datas
        if( $currentUserBalance < $transferAmount ){
            $this->store = false;
            session()->flash('balanceNotEnought','Solde inssufisant pour effectuer se transfere');
        }

        if ($recipientAccountNumber == null) {
            $this->store = false;
            session()->flash('accountNotExist','Ce compte n\' existe pas');
        }

        if( $choosedAccount  == "Choisir un compte" ){
            return back() -> with('chooseAccount', 'Veuillez choisir un compte ');
        }
        return $this->store;
    }

    // send transfere to the recipient
    public function transferToRecipient(Request $request){

        // perfome the transfer
        if( $this->store($request) ){
            $type = 'virement';
            $recipientAccount = request("recipient");
            $choosedAccount = $request->input("choosedAccount");
            $recipientAccountId =  $this-> currentRecipientAccount($recipientAccount) -> value('id'); // recipient id

            $receiveAmount =  $request -> input('amount'); // amount to receive

            $currentUserBalance = $this->currentAccount($choosedAccount) -> value('solde')  ;
            // perform operations
            $newCurrentUserBalance = $currentUserBalance -  $receiveAmount; // decrease the current user balance

            $transaction = new Transaction();
            $transaction -> type_transaction = $type;
            $transaction -> montant  = $receiveAmount;
            $transaction -> compte_dest_id  =  $recipientAccountId;
            $transaction -> compte_source_id  =   $this->currentAccount( $choosedAccount )->value('id')  ;
            // update the source balanace
            $this->currentAccount($choosedAccount)->update
            (["solde"  =>  $newCurrentUserBalance]);

            // trasfere to recipient
            $oldRecipientAccountBalance = $this -> currentRecipientAccount($recipientAccount)-> value('solde') ;

            $recipientBalance =  $oldRecipientAccountBalance + $receiveAmount;
            $this -> currentRecipientAccount($recipientAccount)
                ->update(['solde' => $recipientBalance]);
//            dd($transaction);

            // save the transfere
            $transaction -> save();

            // flash message
            session()
                ->flash('transferesucced', 'Aveez transefer '.
                $recipientAccount.' Fcfa au compte.
                Numero De Compte :'.$choosedAccount.
                'Solde' .$newCurrentUserBalance.' : Fcfa');

        }else{
            dd("Transfere echoue");
        }
    }

    public function currentAccount($choosedAccount){
        // can do better just be addign him an value instead of create a method
        return CompteBancaire::where('numero_compte', $choosedAccount); // return current account balance
    }

    public function currentRecipientAccount($recipientAccountNumber){

        $recipientAccount =   CompteBancaire::where('numero_compte',$recipientAccountNumber);
//        dd($recipientAccount->value('id'));

        if(!$recipientAccount->value('status') == 'actif'){
//            dd($recipientAccount->value('status'));
             return back()->with('accountNotExist','Ce compte n\'existe pas');
        }

        return $recipientAccount;
//        return  CompteBancaire::where('numero_compte',$recipientAccount);

    }
}
