<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

// <-- C'est bien elle qu'on veut utiliser
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    //                  ICI, on remplace 'Request' par 'LoginRequest'
    public function store(LoginRequest $request): RedirectResponse
    {
        // Maintenant, cette ligne fonctionnera sans erreur !
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->role == "client") {
            session(['connectedUserID' => $user->id]);
            session(['default_accounts_id' => $user->comptes->first()?->id]);
            session(['hasBankCard' => true]); // Simplification de la syntaxe

            return redirect()->route('user.index');
        } elseif ($user->role == "admin") {
            return redirect()->route('admin.dashboard');
        } else {
            abort(404, 'Page not found');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
