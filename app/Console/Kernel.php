<?php

namespace App\Console;

use App\Services\FootBallCache;
use App\Services\Notifications;
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
        // $schedule->command('inspire')->hourly();

        /** live events */
        $schedule->call(function () {
            $notifications = new Notifications();
            $notifications->live();
        })->everyMinute();

        $schedule->call(function () {
            $football = new FootBallCache();
            $football->live_fixtures();
            $football->countries();
            $football->leagues();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
