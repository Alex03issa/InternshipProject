<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Database\QueryException;
use Laravel\Socialite\Two\InvalidStateException;
use Exception;

class AppleAuthController extends Controller
{
    public function redirectToApple()
    {
        try {
            return Socialite::driver('apple')->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to initiate Apple authentication. Please try again.');
        }
    }

    public function handleAppleCallback()
    {
        try {
            $appleUser = Socialite::driver('apple')->stateless()->user();

            $existingUser = User::where('email', $appleUser->getEmail())->first();

            if ($existingUser) {
                // Update user avatar if needed
                $existingUser->update(['profile_image' => $appleUser->getAvatar()]);

                // Check if the user has a password
                if (!$existingUser->password) {
                    // Store Apple ID and redirect to password creation
                    $existingUser->apple_id = $appleUser->getId();
                    $existingUser->save();
                    Auth::login($existingUser);
                    return redirect()->route('password.create');
                }

                // Log the user in
                Auth::login($existingUser);
                return redirect()->route('homepage')->with('success', 'Logged in successfully!');
            } else {
                // Register the user
                $newUser = User::create([
                    'name' => $appleUser->getName(),
                    'email' => $appleUser->getEmail(),
                    'apple_id' => $appleUser->getId(),
                    'profile_image' => $appleUser->getAvatar(),
                    'password' => null, // Password will be set later
                ]);

                // Log the user in and redirect to password creation
                Auth::login($newUser);
                return redirect()->route('password.create');
            }
        } catch (InvalidStateException $e) {
            // Handle invalid state exception, which can occur if the CSRF token doesn't match
            return redirect()->route('login')->with('error', 'Invalid state. Please try logging in again.');

        } catch (QueryException $e) {
            // Handle database-related exceptions
            return redirect()->route('login')->with('error', 'A database error occurred. Please try again later.');

        } catch (Exception $e) {
            // Handle all other general exceptions
            return redirect()->route('login')->with('error', 'Unable to login using Apple. Please try again.');
        }
    }
}
