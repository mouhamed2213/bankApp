<?php

namespace App\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Exécute notre commande de calcul des intérêts chaque année, le 1er janvier à 2h du matin.
        $schedule->command('interest:calculate')->yearly()->timezone('Africa/Dakar'); // Adaptez le fuseau horaire
    }
}
