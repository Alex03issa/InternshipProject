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
use App\Models\SiteStatistic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::info('Timezone retrieved from session before redirecting to Google: ' . $timezone);

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

                DB::beginTransaction();
                try {
                    // Your user registration logic here
            
                    // Update statistics after successful registration
                    $totalUsers = User::count();
                    $dailyUsers = User::whereDate('created_at', Carbon::today())->count();
                    $monthlyUsers = User::whereYear('created_at', Carbon::now()->year)
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->count();
            
                    $siteStatistic = SiteStatistic::first();
                    if ($siteStatistic) {
                        $siteStatistic->total_users_registered = $totalUsers;
                        $siteStatistic->daily_users_registered = $dailyUsers;
                        $siteStatistic->monthly_users_registered = $monthlyUsers;
                        $siteStatistic->save();
                    }
            
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::error('Error during user registration: ' . $e->getMessage());
                }


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

    public function apiGoogleLogin(Request $request)
    {
        try {
            // Retrieve token from the Authorization header or fallback to the request body
            $token = $request->bearerToken() ?: $request->input('token');

            if (!$token) {
                return response()->json(['success' => false, 'message' => 'Token is required.'], 400);
            }

            // Optional timezone input, defaults to 'UTC'
            $timezone = $request->input('timezone', 'UTC');

            // Use the token to retrieve the Google user
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);

            // Check if the user already exists in your database
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            $now = Carbon::now($timezone);

            if ($existingUser) {
                // Update the user if necessary
                if ($existingUser->username == 'default_username' || empty($existingUser->username)) {
                    $existingUser->username = $googleUser->getName();
                }

                $existingUser->update([
                    'profile_image' => $googleUser->getAvatar(),
                    'provider' => 'google',
                    'is_verified' => true,
                    'google_id' => $googleUser->getId(),
                    'timezone' => $timezone,
                ]);

                // Generate a Laravel Sanctum token for the existing user
                $token = $existingUser->createToken('MobileAppToken')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully!',
                    'token' => $token,
                    'user' => $existingUser,
                ], 200);
            } else {
                // Register a new user
                $randomPassword = $this->generateRandomPassword();

                $newUser = User::create([
                    'username' => $googleUser->getName(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'provider' => 'google',
                    'google_id' => $googleUser->getId(),
                    'is_verified' => true,
                    'profile_image' => $googleUser->getAvatar(),
                    'password' => Hash::make($randomPassword),
                    'timezone' => $timezone,
                    'created_at' => $now,
                ]);

                // Generate a Laravel Sanctum token for the new user
                $token = $newUser->createToken('MobileAppToken')->plainTextToken;

                // Update statistics after registration
                DB::beginTransaction();
                try {
                    $totalUsers = User::count();
                    $dailyUsers = User::whereDate('created_at', Carbon::today())->count();
                    $monthlyUsers = User::whereYear('created_at', Carbon::now()->year)
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->count();

                    $siteStatistic = SiteStatistic::first();
                    if ($siteStatistic) {
                        $siteStatistic->total_users_registered = $totalUsers;
                        $siteStatistic->daily_users_registered = $dailyUsers;
                        $siteStatistic->monthly_users_registered = $monthlyUsers;
                        $siteStatistic->save();
                    }

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::error('Error during user registration: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully!',
                    'token' => $token,
                    'user' => $newUser,
                ], 201);
            }
        } catch (Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to login using Google. Please try again.',
            ], 500);
        }
    }

 
}