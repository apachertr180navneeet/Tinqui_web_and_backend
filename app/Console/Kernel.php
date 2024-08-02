<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     

    protected function schedule(Schedule $schedule)
    {
       
         $schedule->command('auto:release')->hourly();
         $schedule->command('auto:cancel')->hourly();

         $schedule->command('reminder:ten')->daily();
         $schedule->command('reminder:seven')->daily();

         $schedule->command('product:accept')->everyMinute();
          $schedule->command('liveauction:expire')->everyMinute();
    }
 
    /**
     * Register the commands for the application.
     *
     * @return void
     */

     protected $commands = [
        Commands\AutoFundsRelease::class,
        Commands\AutoCancel::class,
        Commands\ReminderSevenDays::class,
        Commands\ReminderTenDays::class,
        Commands\ProductExpirationandBidAutoAccept::class,
    ];


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
