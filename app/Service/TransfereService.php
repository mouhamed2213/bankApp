<?php

namespace App\Models\Service\TransfereService;
//app/Models/Service/TransfereService.php
use Illuminate\Http\Request;

class TransfereService
{
    // make virements
    public function transfere(Request $request){

        $recipientAccount = request("recipient");
        $transferAmount = $request->input('amount');

        dd($transferAmount);

        // max amount to transfere

    }

}
