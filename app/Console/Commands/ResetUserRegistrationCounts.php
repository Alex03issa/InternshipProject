<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteStatistic;
use App\Models\UserStatistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ResetUserRegistrationCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:user-registration-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset daily and monthly user registration counts';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $siteStatistic = SiteStatistic::first();

        if (!$siteStatistic) {
            // If no SiteStatistic record exists, create one
            $siteStatistic = SiteStatistic::create([
                'total_users_registered' => 0,
                'daily_users_registered' => 0,
                'monthly_users_registered' => 0,
                'daily_active_guests' => 0,
                'monthly_active_guests' => 0,
                'daily_active_users' => 0,
                'monthly_active_users' => 0,
                'total_visits' => 0,
                'daily_visits' => 0,
                'monthly_visits' => 0,
                'last_reset_at' => Carbon::now(),
            ]);

            Log::info('SiteStatistic record created during reset command.');
        }

        $now = Carbon::now();


        // Reset daily statistics
        $siteStatistic->daily_visits = 0;
        $siteStatistic->daily_active_guests = 0;
        $siteStatistic->daily_active_users = 0;
        $siteStatistic->daily_users_registered = 0;

        // Reset monthly statistics on the first day of the month
        if ($now->day === 1) {
            $siteStatistic->monthly_users_registered = 0;
            $siteStatistic->monthly_visits = 0;
            $siteStatistic->monthly_active_guests = 0;
            $siteStatistic->monthly_active_users = 0;
        }

        // Update last reset timestamp
        $siteStatistic->last_reset_at = $now;
        $siteStatistic->save();


        Log::info('Reset command executed at: ' . Carbon::now()->toDateTimeString());


        Log::info('Site statistics have been successfully reset.');
    }
}
