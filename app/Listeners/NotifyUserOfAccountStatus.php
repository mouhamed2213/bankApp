<?php

namespace App\Listeners;

use App\Events\AccountStatusChanged;
use App\Mail\GenericNotification;
use App\Models\User; // Pour trouver l'admin
use Illuminate\Support\Facades\Mail;
class NotifyUserOfAccountStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AccountStatusChanged  $event): void
    {

        $admin = User::where('role', 'admin')->first(); // Adaptez cette logique si besoin

        if ($admin) {
            $userConcerne = $event->user;
            $compte = $event->compte;
            $action = $event->action;

            $titre = "Notification Admin : Action sur un compte";
            $message = "Une action a été effectuée sur un compte :
" .
                " - <strong>Utilisateur :</strong> " . $userConcerne->prenom . " " . $userConcerne->nom . "
" .
                " - <strong>Compte N° :</strong> " . $compte->numero_compte . "
" .
                " - <strong>Action :</strong> " . ucfirst(str_replace('_', ' ', $action));

            Mail::to($admin->email)->send(new GenericNotification($admin, $titre, $message));

    }

    }
}
