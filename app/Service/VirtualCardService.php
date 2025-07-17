<?php

namespace App\Service;


use App\Models\Compte\CompteBancaire;
use App\Models\VirtualCard\VirtualCard;
use Illuminate\Support\Facades\Auth;

class VirtualCardService
{
    // generate vitual bank card
     public static function generateVirtualCard($accountNumer) {
        // get the id of the bank accout used

         $selectedAccountId = CompteBancaire::where('numero_compte', $accountNumer)->value('id');
        $virtualCard = new VirtualCard();

        $virtualCard  -> numero_carte ='4000 1134 ' . str_pad($selectedAccountId, 4, '0', STR_PAD_LEFT) . ' ' . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);
        $virtualCard  -> date_creation = now();
        $virtualCard  -> date_expiration = now()->addyears(4);
        $virtualCard  -> CVV = rand(100,999);
         $virtualCard  -> status = 'active';
         $virtualCard  -> compte_id = $selectedAccountId ;
         $virtualCard  -> save();
//         ('en attente', 'active','bloquer','rejeter')
         return $virtualCard ;
    }

}
