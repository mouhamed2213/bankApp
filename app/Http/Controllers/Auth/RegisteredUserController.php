<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    // randone identiant generataed
    public function randomIdentifiant(Request $request){
        return $request->prenom;
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prenom' => ['required', 'string', 'max:25'],
            'nom' => ['required', 'string', 'max:15'],
            'telephone' => ['required', 'string', 'min:9', 'max:11', 'regex:/^\+?[0-9]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class], // 'unique:'.User::class mail value should be unique
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // active deafault rules
        ]);


//        $user = User::create([ // fonction to create fille data in the table User
//            'prenom'=> $request -> prenom,
//            'nom' => $request -> nom,
//            'telephone' => $request ->telephone,
//            'email' => $request -> email,
//            'identifiant' => $this -> randomIdentifiant($request),
//            'password' => Hash::make($request->password),
//        ]);

        $user = new User();
        $user->prenom = $request->prenom;
        $user-> nom = $request -> nom;
        $user-> telephone = $request ->telephone;
        $user-> email = $request -> email;
        $user -> identifiant = $this -> randomIdentifiant($request);
        $user -> password = Hash::make($request->password);
        dd($user);
        $user -> save();


        event(new Registered($user));

        Auth::login($user);

        return redirect(route('user.index', absolute: false));
    }
}
