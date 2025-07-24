<?php

namespace App\Service;

use App\Models\Demande;

class DemandeService
{
    public function demandes($typeDemande, $accountId){
        Demande::create([
            'compte_id' => $accountId,
            'type' => $typeDemande,
            'date_demande' => now(),
        ]);
    }
}
