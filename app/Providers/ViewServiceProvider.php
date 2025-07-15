<?php

namespace App\Providers;

use App\Models\Compte\CompteBancaire;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user && $user->comptes->isNotEmpty()) {
                $activeCompte = session('active_accounts_id')
                    ? $user->comptes->where('id', session('active_account_id'))->first()
                    : $user->comptes->first();

                $solde = $activeCompte?->solde ?? 0;
                $numeroCompte = $activeCompte?->numero_compte ?? 0;
                $codeBanque = $activeCompte?->code_banque ?? 0;
                $codeGuichet = $activeCompte?->code_guichet ?? 0;
                $typeCompte = $activeCompte?->type_de_compte ?? 'not type';
                $statuscompte = $activeCompte?->status ?? 'not status';
                $dateCreation = $activeCompte?-> created_at ?? 'not date creation';

                $view->with([
                    'solde_user'=> $solde,
                    'numero_compte'=> $numeroCompte,
                    'type_compte'=> $typeCompte,

                ]);
            }
        });


        // get account information

        View::composer('compte.index', function ($view) {
            $user = Auth::user();
            if ($user && $user->comptes->isNotEmpty()) {

                $activeAccount = CompteBancaire::where('user_id', $user->id)->
                    where('status', 'active')->get();

//                dd($activeAccount);
                return $view->with(compact('activeAccount'));
            }
        });


    }
}
