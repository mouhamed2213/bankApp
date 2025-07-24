<?php
//
//namespace App\Http\Controllers\Auth;
//use app\Models\User;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Auth\Events\Verified;
//use Illuminate\Foundation\Auth\EmailVerificationRequest;
//use Illuminate\Http\RedirectResponse;
//
//class VerifyEmailController extends Controller
//{
//    /**
//     * Mark the authenticated user's email address as verified.
//     */
// public function __invoke(EmailVerificationRequest $request): RedirectResponse
//    {
//        // Si l'e-mail n'est pas encore vérifié, on le marque et on déclenche l'événement.
//        if (!$request->user()->hasVerifiedEmail()) {
//            if ($request->user()->markEmailAsVerified()) {
//                event(new Verified($request->user()));
//            }
//        }
//
//        // On redirige l'utilisateur dans tous les cas.
//        // Le paramètre 'verified=1' est utile pour afficher un message de succès sur la page de destination.
//        return redirect()->intended(route('user.index', absolute: false) . '?verified=1');
//    }
//
//
//}


namespace App\Http\Controllers\Auth;

// Assurez-vous que le chemin vers votre modèle User est correct.
// Si votre modèle est dans app/Models, le 'use' est correct.
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
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
            return redirect()->intended(route('admin.index') . '?verified=1');
        }

        // Pour tous les autres cas (par exemple, le rôle 'client'),
        // on redirige vers le tableau de bord utilisateur standard.
        return redirect()->intended(route('user.index') . '?verified=1');
    }
}
