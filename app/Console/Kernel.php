<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
   
    protected $commands = [
        Commands\ProcessSalary::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('salary:command')->monthlyOn(5, '00:00');
    }

   
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
