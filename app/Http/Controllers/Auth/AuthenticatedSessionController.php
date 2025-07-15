<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Compte\CompteBancaire;
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
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if($user-> role == "client"){

            session()->put([ 'connectedUserID' => $user->id]); //
//            session()->put(['accountStatus', $user]);
            session()->put([ 'active_account_id' => $user->comptes->first()?->id ]); // default accout

            return redirect()->route('user.index');
        }else if($user->role == "admin"){
            return redirect()->route('admin.dashboard');
        }else{
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
