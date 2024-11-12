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
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $siteStatistic = SiteStatistic::first();

        if (!$siteStatistic) {
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
        }

        $now = Carbon::now();
        $siteStatistic->total_users_registered = User::count();
        $siteStatistic->daily_users_registered = User::whereDate('created_at', $now->toDateString())->count();
        $siteStatistic->monthly_users_registered = User::whereYear('created_at', $now->year)
                                                      ->whereMonth('created_at', $now->month)
                                                      ->count();

        // Track daily and monthly visits using a cookie
        $cookieVersion = 'v1';
        $currentVisitCookie = Cookie::get('current_visit_' . $cookieVersion);
        if (!$currentVisitCookie || !Carbon::parse($currentVisitCookie)->isToday()) {
            $siteStatistic->increment('daily_visits');
            $siteStatistic->increment('monthly_visits');
            $siteStatistic->increment('total_visits');
            Cookie::queue(Cookie::make('current_visit_' . $cookieVersion, Carbon::now()->toDateTimeString(), 1440));
        }

        if (Auth::check()) {
            // Authenticated User
            $userStatistic = UserStatistic::firstOrCreate(['user_id' => Auth::id()]);

            // Check if the user has not yet been counted today
            if (!$userStatistic->current_visit || !Carbon::parse($userStatistic->current_visit)->isToday()) {

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
                
                // Ensure only this user's `current_visit` and `last_visit` are updated
                $userStatistic->last_visit = $userStatistic->current_visit;
                $userStatistic->current_visit = Carbon::now();
                $userStatistic->save();

                // Count user as active for the day and month
                $siteStatistic->increment('daily_active_users');
                $siteStatistic->increment('monthly_active_users');
            }
        } else {
            // Guest User
            $guestId = Cookie::get('guest_id_' . $cookieVersion);
            if (!$guestId) {
                $guestId = uniqid('guest_', true);
                Cookie::queue(Cookie::make('guest_id_' . $cookieVersion, $guestId, 1440));

                // Increment guest statistics only for unique guests
                $siteStatistic->increment('daily_active_guests');
                $siteStatistic->increment('monthly_active_guests');
            }
        }

        $siteStatistic->save();
        return $response;
    }
}
