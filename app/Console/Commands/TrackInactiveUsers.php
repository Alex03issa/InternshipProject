<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserStatistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TrackInactiveUsers extends Command
{
    protected $signature = 'track:inactive-users';
    protected $description = 'Track and update last visit for inactive users';

    public function handle()
    {
        $threshold = Carbon::now('UTC')->subMinutes(30)->startOfMinute(); 

        $inactiveUsers = UserStatistic::whereNotNull('current_visit')->get();
        
        foreach ($inactiveUsers as $userStatistic) {
            // Fetch the associated user's timezone from the User model
            $user = User::find($userStatistic->user_id);
            $userTimeZone = $user->timezone ?? 'UTC';

            // Convert `current_visit` to UTC for comparison
            $currentVisitInUTC = Carbon::parse($userStatistic->current_visit, $userTimeZone)->utc();

            if ($currentVisitInUTC->lessThan($threshold)) {
                // Update last_visit and manually set updated_at to user's local time
                $userStatistic->last_visit = $userStatistic->current_visit;
                $userStatistic->current_visit = null;
                
                // Save the updated_at timestamp in user's timezone
                $userStatistic->timestamps = false; 
                $userStatistic->updated_at = Carbon::now($userTimeZone);
                $userStatistic->save();
                $userStatistic->timestamps = true; 

                Log::info("Inactivity detected. Last visit updated for user ID: {$userStatistic->user_id}");
            }
        }
    }

}
