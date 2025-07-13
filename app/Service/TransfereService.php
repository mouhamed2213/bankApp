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
    // make virements
    public function store(Request $request){
        // Get inputs
        $recipientAccount = request("recipient");
        $transferAmount = $request->input('amount');

        $request->validate([
            "recipient" => 'required | digits:11 ',
            "amount" => 'required',
        ]);


        // 1 get the user  information
//        $current_user = Auth::user();

        // 2 get the first account if the user has more account (first)
//        $account = CompteBancaire::where('user_id', $this->current_user()->id)->first();

        // 3 getr the the id of the user account
        $accountID = $this->currentAccount()  ? $this->currentAccount()->id : null;

        // 4 get the user account bank transaction informations
        $currentUserTransfere = Transaction::where('compte_source_id', $accountID);

        // get the current account number
        $currentAccountNumber = $this->currentAccount() ? $this->currentAccount() -> numero_compte : null;

        // get the recipient account if exist
        $recipientAccountNumber = $this->currentRecipientAccount($recipientAccount);


        // 6 get the user  account balance
        $currentUserBalance = $this->currentAccount()->solde;


        // VERIFICATION

        // 7 check if balance is enought
        if( $currentUserBalance < $transferAmount ){
            $this->store = false;
            session()->flash('balanceNotEnought','Solde inssufisant pour effectuer se transfere');

        }

        // 8 check if account number exist pefor trans action
        if ($recipientAccountNumber == null) {
            $this->store = false;
            session()->flash('accountNotExist','Ce compte n\' existe pas');
        }

// account nmber for test 11111111112
        return $this->store;
    }

    public function current_user(){
        return Auth::user();
    }

    public function currentAccount(){
        return  CompteBancaire::where('user_id', $this->current_user()->id)->first();
    }


    public function currentRecipientAccount($recipientAccount){

        return  CompteBancaire::where('numero_compte',$recipientAccount)->first();
    }



    // send transfere to the recipient
    public function transferToRecipient(Request $request){

        // perfome the transfer
        if( $this->store($request) ){
            $type = 'virement';
            $recipientAccount = request("recipient");

            $recipientAccountId =  $this-> currentRecipientAccount($recipientAccount)->id; // recipient id

            $RecipientAccountNumber = $request -> input('recipient'); // recipient account number
            $receiveAmount =  $request -> input('amount'); // amount to receive

            $currentUserAccountId = $this->currentAccount()->id; // user perform transfere id

            $currentUserBalance = $this->currentAccount() -> solde ;
            // perform operations
            $newCurrentUserBalance = $currentUserBalance -  $receiveAmount; // decrease the current user balance

            $transaction = new Transaction();
            $transaction -> type_transaction = $type;
            $transaction -> montant  = $receiveAmount;
            $transaction -> compte_dest_id  =  $recipientAccountId;
            $transaction -> compte_source_id  =   $this->currentAccount()->id  ;

            $transaction -> save();


            // update the source balanace
            $this->currentAccount()->update
            (["solde"  =>  $newCurrentUserBalance]);

            // trasfere to recipient
            $oldRecipientAccountBalance = $this -> currentRecipientAccount($recipientAccount)-> solde ;
            $recipientBalance =  $oldRecipientAccountBalance + $receiveAmount;

            $this -> currentRecipientAccount($recipientAccount)
                ->update(['solde' => $recipientBalance]);


            // send the amount to the receiver



//            dd(
//                "Recipient Account Number : ". $request -> input('recipient').
//                "\nTransfere Amount received  : ". $request -> input('amount').
//                "\n Type : ".$type.
//                "\nTransfere account source ID :".$this->currentAccount()->id.
//                "\nTransfere account source ID : ".$recipientAccountId  );


        }else{
            dd("Transfere echoue");
        }
    }


}
