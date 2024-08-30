<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Two\InvalidStateException;
use Exception;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to initiate Google authentication. Please try again.');
        }
    }

public function handleGoogleCallback()
{
    try {
        // Step 1: Retrieve the Google user
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Step 2: Check if the user already exists in your database
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Step 3: Update user's profile image if needed
            $existingUser->update(['profile_image' => $googleUser->getAvatar()]);
            

            // Log in the existing user
            Auth::login($existingUser);
            return redirect()->route('homepage')->with('success', 'Logged in successfully!');
        } else {
            // Step 6: Register a new user
            $randomPassword = $this->generateRandomPassword();
            $newUser = User::create([
                'username' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(), // Automatically mark as verified
                'profile_image' => $googleUser->getAvatar(),
                'password' => Hash::make($randomPassword),
            ]);

            // Store the generated password in session
            Session::put('generated_password', $randomPassword);
 
            // Log in the new user
            Auth::login($newUser);
            return redirect()->route('homepage')->with('success', 'Logged in successfully!');
        }
    } catch (InvalidStateException $e) {
        return redirect()->route('login')->with('error', 'Invalid state. Please try logging in again.');

    } catch (QueryException $e) {
        return redirect()->route('login')->with('error', 'A database error occurred. Please try again later.');

    } catch (Exception $e) {
        return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
    }
}

    // Helper function to generate a random password
    private function generateRandomPassword($length = 10)
    {
        return bin2hex(openssl_random_pseudo_bytes($length / 2));
    }
}