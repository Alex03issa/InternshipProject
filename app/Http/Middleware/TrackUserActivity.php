<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use App\Models\SiteStatistic;
use App\Models\UserStatistic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class TrackUserActivity
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
        $response = $next($request);

        // Log request type (User or Guest) for debugging purposes
        Log::info('Tracking activity for request type: ' . (Auth::check() ? 'User' : 'Guest'));

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

            Log::info('SiteStatistic record created.');
        }

        // Update user registration statistics
        $now = Carbon::now();
        $siteStatistic->total_users_registered = User::count();
        $siteStatistic->daily_users_registered = User::whereDate('created_at', $now->toDateString())->count();
        $siteStatistic->monthly_users_registered = User::whereYear('created_at', $now->year)
                                                      ->whereMonth('created_at', $now->month)
                                                      ->count();

        // Define a version for the cookies
        $cookieVersion = 'v1';

        // Increment visits if this is a new visit for today
        $currentVisitCookie = Cookie::get('current_visit_' . $cookieVersion);
        if (!$currentVisitCookie || !Carbon::parse($currentVisitCookie)->isToday()) {
            $siteStatistic->increment('daily_visits');
            $siteStatistic->increment('monthly_visits');
            $siteStatistic->increment('total_visits');
            Cookie::queue(Cookie::make('current_visit_' . $cookieVersion, Carbon::now()->toDateTimeString(), 1440)); // Set cookie for 1 day

            Log::info('Visits incremented. Daily, monthly, and total visits updated.');
        } else {
            Log::info('Visit not incremented - already recorded for today.');
        }

        if (Auth::check()) {
            // Authenticated User
            $userStatistic = UserStatistic::firstOrCreate(['user_id' => Auth::id()]);

            if ($userStatistic->last_visit == null || $userStatistic->current_visit == null || !Carbon::parse($userStatistic->current_visit)->isToday()) {
                // If the user was previously counted as a guest today
                $guestIdCookie = Cookie::get('guest_id_' . $cookieVersion);
                if ($guestIdCookie) {
                    // Decrement guest counts only if they are greater than zero
                    if ($siteStatistic->daily_active_guests > 0) {
                        $siteStatistic->decrement('daily_active_guests');
                    }
                    if ($siteStatistic->monthly_active_guests > 0) {
                        $siteStatistic->decrement('monthly_active_guests');
                    }
        
                    // Remove guest_id from cookies since the user is now registered
                    Cookie::queue(Cookie::forget('guest_id_' . $cookieVersion));
                }
        
                // Increment user counts
                $siteStatistic->increment('daily_active_users');
                $siteStatistic->increment('monthly_active_users');
            }
            
            if (!$userStatistic->current_visit || !Carbon::parse($userStatistic->current_visit)->isToday()) {
                $userStatistic->current_visit = Carbon::now();
                $userStatistic->save();
                Log::info('User current visit tracked for user ID: ' . Auth::id());
            }
        

            Log::info('User activity updated for user ID: ' . Auth::id());
        } else {
            // Guest User
            $guestId = Cookie::get('guest_id_' . $cookieVersion);
            if (!$guestId) {
                // First time visit as a guest, assign a new guest ID
                $guestId = uniqid('guest_', true);
                Cookie::queue(Cookie::make('guest_id_' . $cookieVersion, $guestId, 1440)); // Set cookie for 1 day

                // Increment guest statistics only for unique guests
                $siteStatistic->increment('daily_active_guests');
                $siteStatistic->increment('monthly_active_guests');

                Log::info('Guest activity tracked with unique ID: ' . $guestId);
            } else {
                Log::info('Guest already tracked with ID: ' . $guestId);
            }
        }

        $siteStatistic->save();

        return $response;
    }
}
