<?php
//
//namespace App\Service;
//
//use App\Models\Compte\CompteBancaire;
//use App\Models\Demande;
//use Illuminate\Support\Facades\Auth;
//
//class CompteBancaireService
//{
//    // geet the cuirrent user bank account and personnal inforamtion
//    public static function userDatas()
//    {
//        $user = Auth::id();
//
//        // get user accounts depending on the user Id
//        $UserAccount = CompteBancaire::with('user')->where('user_id', $user)->get();
//        return $UserAccount;
//    }
//
//    // get one user account
//    public static function userData($UserId){
//        // get one  user accounts
//        $UserAccount = CompteBancaire::where( 'id', $UserId )->get();
//        return $UserAccount;
//    }
//
//
//    // create bansk account
//    public  function createBankAccount($UserId){
//        $demande  = new DemandeService();
//
//        $compte_bancaire = new CompteBancaire();
//        $compte_bancaire->numero_compte =  str_pad(rand(1,100), 5,'0',STR_PAD_LEFT ).str_pad( mt_rand(1,200), 4, '5', STR_PAD_LEFT ).str_pad(mt_rand(1,50), 2, '3', STR_PAD_LEFT);
//        $compte_bancaire->code_banque = str_pad( mt_rand(1,10000), 5, '2', STR_PAD_LEFT );
//        $compte_bancaire->code_guichet = str_pad( mt_rand(1,10), 5,  "4", STR_PAD_LEFT );
//        $compte_bancaire->RIB = str_pad(mt_rand(1,100), 2, "1", STR_PAD_LEFT);
//        $compte_bancaire->solde  =  00.0;
//        $compte_bancaire->type_de_compte = 'courant'; // enum
//        $compte_bancaire->status = 'en attente' ;
//        $compte_bancaire->user_id = $UserId;
//        if($compte_bancaire->save()){
//            $comptesId = Auth::user()->comptes->where('user_id', $UserId)->last()->id;
//
//            // create a validator request
//            $demande -> demandes('validation', $comptesId);
//
////            dd($comptesId);
//        }
////        $demande->demandes();
//
//        return;
//    }
//}


namespace App\Service;

use App\Models\Compte\CompteBancaire;
use App\Models\Demande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

// Pour le type hinting

class CompteBancaireService
{
    // user account infotmation
    public static function userDatas(): Collection
    {
        return Auth::user()->comptes;
    }


    public static function userData($compteId): ?CompteBancaire // On retourne un seul modèle ou null
    {
        // On cherche le compte par son ID ET on s'assure qu'il appartient à l'utilisateur connecté.
        return CompteBancaire::where('id', $compteId)
            ->where('user_id', Auth::id())
            ->first(); // first() retourne un seul objet ou null, c'est ce qu'on veut.
    }


    // createa account
    public function createBankAccount(int $userId, string $typeDeCompte): bool
    {
        $compte_bancaire = new CompteBancaire();
        $compte_bancaire->numero_compte = $this->generateNumeroCompte(); // On déplace la logique de génération
        $compte_bancaire->code_banque = str_pad(mt_rand(1, 10000), 5, '2', STR_PAD_LEFT);
        $compte_bancaire->code_guichet = str_pad(mt_rand(1, 10), 5, "4", STR_PAD_LEFT);
        $compte_bancaire->RIB = str_pad(mt_rand(1, 100), 2, "1", STR_PAD_LEFT);
        $compte_bancaire->solde = 0.0;
        $compte_bancaire->status = 'en attente';
        $compte_bancaire->user_id = $userId;

        // ***** DÉBUT DE LA MODIFICATION CLÉ *****
        // On utilise le paramètre reçu du contrôleur.
        $compte_bancaire->type_de_compte = $typeDeCompte;
        // ***** FIN DE LA MODIFICATION CLÉ *****

        if ($compte_bancaire->save()) {
            $demandeService = new DemandeService();
            $demandeService->demandes('validation', $compte_bancaire->id);

            event(new AccountStatusChanged($compte_bancaire, 'demande dou verture de compte bancaire', "l'utilsateur". Auth::user()->prenom . " " . Auth::user()->nom. " Demande une ouverture de compte bancaire"));


            return true;
        }

        return false;
    }

    /**
     * Méthode privée pour générer un numéro de compte unique.
     * C'est une bonne pratique de séparer la logique de génération.
     */
    private function generateNumeroCompte(): string
    {
        // Votre logique de génération existante.
        // On pourrait ajouter une vérification pour s'assurer de son unicité si nécessaire.
        return str_pad(rand(1, 100), 5, '0', STR_PAD_LEFT) .
            str_pad(mt_rand(1, 200), 4, '5', STR_PAD_LEFT) .
            str_pad(mt_rand(1, 50), 2, '3', STR_PAD_LEFT);
    }
}
