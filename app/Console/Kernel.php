<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\NotifyPopularPeople::class,
    ];    

    protected function schedule(Schedule $schedule)
    {
        \Log::info('Scheduler processed at ' . now());
    
        $schedule->command('notify:popular-people')
                 ->everyMinute()
                 ->when(fn() => true) 
                 ->withoutOverlapping()
                 ->evenInMaintenanceMode()
                 ->runInBackground();
    }
    
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
