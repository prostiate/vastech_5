<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('backup:run --only-db')->daily();
        $schedule->command('check:expense:status')->daily();
        $schedule->command('check:purchase_quote:status')->daily();
        $schedule->command('check:purchase_order:status')->daily();
        $schedule->command('check:purchase_delivery:status')->daily();
        $schedule->command('check:purchase_invoice:status')->daily();
        $schedule->command('check:purchase_payment:status')->daily();
        $schedule->command('check:sales_quote:status')->daily();
        $schedule->command('check:sales_order:status')->daily();
        $schedule->command('check:sales_invoice:status')->daily();
        $schedule->command('check:sales_payment:status')->daily();
        $schedule->command('check:depreciate')->everyMinute()->appendOutputTo(storage_path('logs/inspire.log'));;
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
