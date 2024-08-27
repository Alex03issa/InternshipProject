<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
             // Update user avatar if needed
             $existingUser->update(['profile_image' => $user->getAvatar()]);
            // Log the user in
            Auth::login($existingUser, true);
        } else {
            // Register the user
            $newUser = User::create([
                'username' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
                'profile_image' => $user->getAvatar(),
                // You may want to set a default password or make it nullable
              
            ]);

            Auth::login($newUser, true);
        }

        // Redirect to home after login
        return redirect()->route('homepage');
    }
}
