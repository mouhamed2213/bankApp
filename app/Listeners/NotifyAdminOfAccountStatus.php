<?php

namespace App\Listeners;

use App\Events\AccountStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\GenericNotification;
use Illuminate\Support\Facades\Mail;


class NotifyAdminOfAccountStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }
    public function handle(AccountStatusChanged $event): void
    {
        $user = $event->user;
        $titre = "Mise à jour concernant votre compte";
        $message = $event->messagePourUser; // On utilise le message défini dans l'événement

        Mail::to($user->email)->send(new GenericNotification($user, $titre, $message));
    }

}

