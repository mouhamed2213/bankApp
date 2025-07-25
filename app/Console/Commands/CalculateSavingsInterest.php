<?php

namespace App\Console\Commands;

use App\Models\Compte\CompteBancaire;
use App\Models\Transaction; // Assurez-vous d'importer le modèle Transaction
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log; // Pour logger le résultat

class CalculateSavingsInterest extends Command
{
    // La "signature" est le nom de votre commande
    protected $signature = 'interest:calculate';

    protected $description = 'Calcule et ajoute les intérêts annuels pour tous les comptes épargne actifs';

    public function handle()
    {
        $this->info('Début du calcul des intérêts annuels...');
        Log::info('Début du calcul des intérêts annuels...');

        // 1. On récupère tous les comptes épargne qui sont actifs
        $comptesEpargne = CompteBancaire::where('type_de_compte', 'epargne')
            ->where('status', 'active')
            ->get();

        if ($comptesEpargne->isEmpty()) {
            $this->info('Aucun compte épargne actif trouvé. Tâche terminée.');
            Log::info('Aucun compte épargne actif trouvé.');
            return 0;
        }

        // 2. On boucle sur chaque compte pour calculer et ajouter les intérêts
        foreach ($comptesEpargne as $compte) {
            // Taux d'intérêt de 3%
            $interet = $compte->solde * 0.03;

            // On ne fait rien si l'intérêt est nul ou négatif
            if ($interet <= 0) {
                continue;
            }

            // 3. On ajoute l'intérêt au solde du compte
            $compte->solde += $interet;
            $compte->save();

            // 4. On enregistre cette opération comme une transaction pour l'historique
            Transaction::create([
                'compte_source_id' => $compte->id,
                'type' => 'interet', // Un nouveau type de transaction
                'montant' => $interet,
                'date' => now(),
            ]);

            $message = "Intérêt de " . number_format($interet, 2) . " FCFA ajouté au compte N°{$compte->numero_compte}.";
            $this->info($message);
            Log::info($message);
        }

        $this->info('Calcul des intérêts terminé avec succès.');
        Log::info('Calcul des intérêts terminé avec succès.');
        return 0;
    }
}
