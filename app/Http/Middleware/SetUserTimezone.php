<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;


class SetUserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the user is authenticated and has a timezone set
        if (Auth::check()) {
            $user = Auth::user();

            // Set the default timezone based on the user's timezone
            if ($user->timezone) {
                config(['app.timezone' => $user->timezone]);
                date_default_timezone_set($user->timezone);
    
                // Update all timestamps in relevant tables
                $this->updateTimestampsForAllModels($user->timezone);
                Log::info("Timezone applied for user: {$user->id}");
            } else {
                Log::info('User timezone is not set in the database.');
            }
        }

        return $next($request);
    }

    

    private function updateTimestampsForAllModels($userTimezone)
{
    // Define all the models that need timestamps updated
    $models = [
        \App\Models\UserStatistic::class,
        \App\Models\SiteStatistic::class,
        \App\Models\Post::class,
        \App\Models\GameInfo::class,
        \App\Models\Ad::class,
        \App\Models\AdStatistic::class,
        \App\Models\Background::class,
        \App\Models\Category::class,
        \App\Models\CategoryPost::class,
        \App\Models\ContentBlock::class,
        \App\Models\FailedJob::class,
        \App\Models\GameStatistic::class,
        \App\Models\Skin::class,
        \App\Models\TeamMember::class,
        \App\Models\Trophy::class,
        \App\Models\User::class,
        \App\Models\PasswordResetToken::class,
        \App\Models\PersonalAccessToken::class,
    ];

    foreach ($models as $modelClass) {
        // Use the model class to query records and update timestamps
        $modelClass::query()->each(function ($record) use ($userTimezone) {
            // Handle standard Laravel timestamps: created_at and updated_at
            if (isset($record->created_at)) {
                $record->created_at = Carbon::parse($record->created_at)->setTimezone($userTimezone);
            }

            if (isset($record->updated_at)) {
                $record->updated_at = Carbon::now()->setTimezone($userTimezone);
            }

            // Handle custom timestamp fields as identified in the migrations

            // Users table
            if (isset($record->last_visit)) {
                $record->last_visit = Carbon::parse($record->last_visit)->setTimezone($userTimezone);
            }
            if (isset($record->current_visit)) {
                $record->current_visit = Carbon::now()->setTimezone($userTimezone);
            }

            if (isset($record->timezone)) {
                // No direct change in the value, but it's used for time calculations
                $record->timezone = $userTimezone; 
            }

            // Password Reset Tokens
            if (isset($record->created_at)) {
                $record->created_at = Carbon::parse($record->expires_at)->setTimezone($userTimezone);
            }

            // Failed Jobs
            if (isset($record->failed_at)) {
                $record->failed_at = Carbon::parse($record->failed_at)->setTimezone($userTimezone);
            }

            // Personal Access Tokens
            if (isset($record->token_last_used_at)) {
                $record->token_last_used_at = Carbon::parse($record->token_last_used_at)->setTimezone($userTimezone);
            }

            // Ads table
            if (isset($record->published_at)) {
                $record->published_at = Carbon::parse($record->published_at)->setTimezone($userTimezone);
            }

            // Site Statistics table
            if (isset($record->last_reset_at)) {
                $record->last_reset_at = Carbon::parse($record->last_reset_at)->setTimezone($userTimezone);
            }

            // Trophies table
            if (isset($record->achieved_at)) {
                $record->achieved_at = Carbon::parse($record->achieved_at)->setTimezone($userTimezone);
            }

            // Save record with updated timestamps
            $record->save();
        });
    }
}
}
