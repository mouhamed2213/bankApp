<?php

namespace App\Events;

// Fichier: app/Events/AccountStatusChanged.php
namespace App\Events;

use App\Models\User;
use App\Models\Compte\CompteBancaire;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccountStatusChanged
{
    use Dispatchable, SerializesModels;

    public CompteBancaire $compte;
    public User $user;
    public string $action; // ex: 'validé', 'rejeté', 'demande_cloture'
    public string $messagePourUser; // Un message clair décrivant l'action

    /**
     * Create a new event instance.
     */
    public function __construct(CompteBancaire $compte, string $action, string $messagePourUser)
    {
        $this->compte = $compte;
        $this->user = $compte->user; // On récupère l'utilisateur depuis le compte
        $this->action = $action;
        $this->messagePourUser = $messagePourUser;
    }
}

