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
use Carbon\Carbon;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function storeTimezone(Request $request)
    {
        // Store the detected timezone in the session
        Session::put('user_timezone', $request->input('timezone', 'UTC'));

        return response()->json(['success' => true, 'message' => 'Timezone stored in session.']);
    }
 
    public function redirectToGoogle()
    {
        
        try {
           
            $timezone = Session::get('user_timezone', 'UTC');
            \Log::info('Timezone retrieved from session before redirecting to Google: ' . $timezone);

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
            
            $timezone = Session::get('user_timezone', 'UTC');
            $now = Carbon::now($timezone);
          
            if ($existingUser) {
                // Check if the username is still the default or empty
                if ($existingUser->username == 'default_username' || empty($existingUser->username)) {
                    // Update the username to the Google name
                    $existingUser->update(['username' => $googleUser->getName()]);
                }

              
                // Step 3: Update the user's profile image and provider
                $existingUser->update([
                    'profile_image' => $googleUser->getAvatar(),
                    'provider' => 'google',  // Set provider to 'google'
                    'is_verified' => true,
                    'google_id' => $googleUser->getId(),
                    'timezone' => $timezone,
                ]);
     
               


                // Log in the existing user
                Auth::login($existingUser);
                return redirect()->route('homepage')->with('success', 'Logged in successfully!');
            } else {
                // Step 6: Register a new user
                $randomPassword = $this->generateRandomPassword();
                

                $newUser = User::create([
                    'username' => $googleUser->getName(),  // Set Google name as username for new users
                    'name' => $googleUser->getName(),      // Store Google name
                    'email' => $googleUser->getEmail(),
                    'provider' => 'google',
                    'google_id' => $googleUser->getId(),
                    'is_verified' => true,                 // Automatically mark as verified
                    'profile_image' => $googleUser->getAvatar(),
                    'password' => Hash::make($randomPassword),
                    'timezone' => $timezone,
                    'created_at' => $now, 
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
            \Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }
    

    // Helper function to generate a random password
    private function generateRandomPassword($length = 10)
    {
        return bin2hex(openssl_random_pseudo_bytes($length / 2));
    }
}