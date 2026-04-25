<?php

namespace App\Console;

use App\Models\Client;
use App\Notifications\EventExpiredNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

     protected $commands = [
        \App\Console\Commands\CommandeDateExpiration::class
    ];


    protected function schedule(Schedule $schedule): void
    {
        
            // $schedule->command(command:'app:commande-date-expiration')->everyMinute();
            $schedule->command('app:commande-date-expiration')->everyMinute();
    

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
