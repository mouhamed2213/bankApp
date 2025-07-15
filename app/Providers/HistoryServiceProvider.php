<?php

namespace App\Providers;

use App\Models\compte\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Compte\CompteBancaire;
use Illuminate\Support\Facades\View;


class HistoryServiceProvider extends ServiceProvider
{
    private $history;
    private $currentUserAccountId;
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
            // history of the user
            $history = $this->allHistory();

            view()->share('history', $history);
        });

    }


//    // all history
    function allHistory(){
        $user = Auth::user();
        $accountChangedId = session('switchAccount_id');
        $defaultAccountId = session('default_accounts_id');
        if(session('default_accounts_id')) {
            $this->currentUserAccountId = $defaultAccountId;
            $this -> history = Transaction::valid()->
            where('compte_source_id', $defaultAccountId)
            ->latest()
             ->take(10)
            ->get();
        } elseif(session('default_accounts_id')) {
            $this->currentUserAccountId = $defaultAccountId;
            $this -> history = Transaction::valid()->
            where('compte_source_id', $defaultAccountId)
            ->latest()
             ->take(10)
            ->get();
        }



        return $this->history;
    }


}
