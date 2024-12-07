<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogOutInactiveUser
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
        if (Auth::check()) {
            // Get the last activity time from the session
            $lastActivity = session('last_activity_time');
            $timeout = 60 * 30; // 60 minutes timeout in seconds

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                // Logout the user due to inactivity
                $userId = Auth::id();
                Auth::logout();
                session()->flush(); // Clear all session data
                Log::info("User $userId has been logged out due to inactivity.");

                return redirect()->route('login')->with('error', 'You have been logged out due to inactivity.');
            }

            // Update the last activity time in the session
            session(['last_activity_time' => time()]);
        }

        return $next($request);
    }
}
