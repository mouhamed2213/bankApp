<?php

namespace App\Providers;

use AllowDynamicProperties;
use App\Models\Compte\CompteBancaire;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

#[AllowDynamicProperties] class ViewServiceProvider extends ServiceProvider
{
    public
        $activeCompte = '';


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

        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user && $user->comptes->isNotEmpty()) {
                if(session('default_accounts_id')){
                    $this->activeCompte = $user->comptes->where('id', session('default_accounts_id'));

                    if(session('switchAccount_id')){
                        $this->activeCompte = $user->comptes->where('id', session('switchAccount_id'));
                    }
                } else{
                    $this->activeCompte = $user->comptes->where('id', 'default_accounts_id');

                }

//            dd($this->activeCompte->value('id'));


                $solde = $this->activeCompte ?->value('solde') ?? 0;
                $numeroCompte = $this->activeCompte ?->value('numero_compte') ?? 00;
                $codeBanque = $this->activeCompte?->value('code_banque') ?? 0;
                $codeGuichet = $this->activeCompte?->value('code_guichet') ?? 0;
                $typeCompte = $this->activeCompte?->value('type_de_compte') ?? 'not type';
                $statuscompte = $this->activeCompte?->value('status') ?? 'not status';
                $dateCreation =$this->activeCompte?->value(' created_at')  ?? 'not date creation';

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
