<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
//// Fichier : app/Http/Controllers/VerifyEmailController.php
//
//        // 1. On vérifie si l'email n'est pas déjà vérifié
//        if (!$request->user()->hasVerifiedEmail()) {
//
//            // 2. On le marque comme vérifié. C'est ici que la magie opère !
//            if ($request->user()->markEmailAsVerified()) { // <--- Point clé n°1
//
//                // 3. On déclenche un nouvel événement !
//                event(new Verified($request->user())); // <--- Point clé n°2
//            }
//        }
//
//        // 4. On redirige l'utilisateur
//        return redirect()->intended(route('user.index', absolute: false) . '?verified=1');
//    }

        // Étape 1 : Marquer l'e-mail comme vérifié si ce n'est pas déjà fait.
        // Cette partie de votre code est déjà parfaite.
        if (!$request->user()->hasVerifiedEmail()) {
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
        }

        // Étape 2 : Logique de redirection basée sur le rôle de l'utilisateur.
        // C'est ici que nous ajoutons la nouvelle logique.

        $user = $request->user(); // On récupère l'utilisateur pour plus de clarté.

        // On vérifie si l'utilisateur a le rôle 'admin'.
        // Remplacez 'role' par le nom de votre colonne dans la table users si besoin.
        if ($user->role === 'admin') { // ou $user->hasRole('admin') avec un package
            // Si c'est un admin, on le redirige vers le tableau de bord admin.
            return redirect()->intended(route('admin.dashboard') . '?verified=1');
        }

        // Pour tous les autres cas (par exemple, le rôle 'client'),
        // on redirige vers le tableau de bord utilisateur standard.
        return redirect()->intended(route('user.index') . '?verified=1');
    }
}
