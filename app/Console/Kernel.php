<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('reset:user-registration-counts')->dailyAt('00:00');
        $schedule->command('track:inactive-users');
        $schedule->command('ads:update-status')->daily();
        $schedule->command('posts:update-status')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected $commands = [
        \App\Console\Commands\ResetUserRegistrationCounts::class,
        \App\Console\Commands\TrackInactiveUsers::class,
        \App\Console\Commands\UpdateAdStatus::class,
        \App\Console\Commands\UpdatePostStatus::class,
        \App\Console\Commands\ManageEmails::class,
    ];
    
}
