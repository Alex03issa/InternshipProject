<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // Check if the user has signed in with Google or Apple ID
            if ($user->provider == 'google' || $user->provider == 'apple') {
                $user->is_verified = true; // Mark as verified
                $user->verification_token = null;
                $user->provider = $user->provider;
                $user->save();
                return $next($request);
            } 
    

            // Check if the user's email is verified using 'is_verified'
            if (!$user->is_verified) {
                return redirect()->route('login')->with('error', 'Please verify your email address.');
            }
        }

        return $next($request);
    }
}



