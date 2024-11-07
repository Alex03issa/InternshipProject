<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserStatistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TrackInactiveUsers extends Command
{
    protected $signature = 'track:inactive-users';
    protected $description = 'Track and update last visit for inactive users';

    public function handle()
    {
        $threshold = Carbon::now()->subMinutes(30); // 30-minute inactivity threshold

        // Find users who have been inactive for more than the threshold
        $inactiveUsers = UserStatistic::where('updated_at', '<', $threshold)
                                      ->whereNotNull('current_visit')
                                      ->get();

        foreach ($inactiveUsers as $userStatistic) {
            $userStatistic->last_visit = $userStatistic->current_visit;
            $userStatistic->current_visit = null; // Clear current_visit
            $userStatistic->save();

            Log::info('Inactivity detected. Last visit updated for user ID: ' . $userStatistic->user_id);
        }
    }
}
