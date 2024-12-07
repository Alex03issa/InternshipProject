<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
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

            // Step 2: Hash the Google email
            $saltedHash = hash_hmac('sha256', $googleUser->getEmail(), env('HASH_SECRET'));

            // Step 3: Check if the user exists based on hashed email
            $existingUser = User::where('hashed_email', $saltedHash)->first();
            $timezone = Session::get('user_timezone', 'UTC');
            $now = Carbon::now($timezone);

            if ($existingUser) {
                // Update the existing user
                $existingUser->update([
                    'username' => $existingUser->username ?: $googleUser->getName(),
                    'profile_image' => $googleUser->getAvatar(),
                    'provider' => 'google',
                    'is_verified' => true,
                    'google_id' => $googleUser->getId(),
                    'timezone' => $timezone,
                ]);

                Auth::login($existingUser);
                return redirect()->route('homepage')->with('success', 'Logged in successfully!');
            } else {
                // Step 4: Encrypt and hash the Google email
                $firstEncryption = Crypt::encryptString($googleUser->getEmail());
                $encryptedEmail = Crypt::encryptString(json_encode([
                    'email' => $firstEncryption,
                    'hash' => $saltedHash,
                ]));

                // Step 5: Create a new user
                $randomPassword = $this->generateRandomPassword();
                $newUser = User::create([
                    'username' => $googleUser->getName(),
                    'name' => $googleUser->getName(),
                    'email' => $encryptedEmail,
                    'hashed_email' => $saltedHash,
                    'provider' => 'google',
                    'google_id' => $googleUser->getId(),
                    'is_verified' => true,
                    'profile_image' => $googleUser->getAvatar(),
                    'password' => Hash::make($randomPassword),
                    'timezone' => $timezone,
                    'created_at' => $now,
                ]);

                Session::put('generated_password', $randomPassword);
                Auth::login($newUser);

                $this->updateSiteStatistics();
                return redirect()->route('homepage')->with('success', 'Logged in successfully!');
            }
        } catch (InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Invalid state. Please try logging in again.');
        } catch (QueryException $e) {
            return redirect()->route('login')->with('error', 'A database error occurred. Please try again later.');
        } catch (Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }

    private function generateRandomPassword($length = 10)
    {
        return bin2hex(openssl_random_pseudo_bytes($length / 2));
    }

    public function apiGoogleLogin(Request $request)
    {
        try {
            $token = $request->bearerToken() ?: $request->input('token');
            if (!$token) {
                return response()->json(['success' => false, 'message' => 'Token is required.'], 400);
            }

            $timezone = $request->input('timezone', 'UTC');
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);
            $saltedHash = hash_hmac('sha256', $googleUser->getEmail(), env('HASH_SECRET'));
            $now = Carbon::now($timezone);

            $existingUser = User::where('hashed_email', $saltedHash)->first();

            if ($existingUser) {
                $existingUser->update([
                    'profile_image' => $googleUser->getAvatar(),
                    'provider' => 'google',
                    'is_verified' => true,
                    'google_id' => $googleUser->getId(),
                    'timezone' => $timezone,
                ]);

                $token = $existingUser->createToken('MobileAppToken')->plainTextToken;
                return response()->json(['success' => true, 'message' => 'Logged in successfully!', 'token' => $token, 'user' => $existingUser], 200);
            } else {
                $firstEncryption = Crypt::encryptString($googleUser->getEmail());
                $encryptedEmail = Crypt::encryptString(json_encode([
                    'email' => $firstEncryption,
                    'hash' => $saltedHash,
                ]));

                $randomPassword = $this->generateRandomPassword();
                $newUser = User::create([
                    'username' => $googleUser->getName(),
                    'name' => $googleUser->getName(),
                    'email' => $encryptedEmail,
                    'hashed_email' => $saltedHash,
                    'provider' => 'google',
                    'google_id' => $googleUser->getId(),
                    'is_verified' => true,
                    'profile_image' => $googleUser->getAvatar(),
                    'password' => Hash::make($randomPassword),
                    'timezone' => $timezone,
                    'created_at' => $now,
                ]);

                $this->updateSiteStatistics();
                $token = $newUser->createToken('MobileAppToken')->plainTextToken;
                return response()->json(['success' => true, 'message' => 'Logged in successfully!', 'token' => $token, 'user' => $newUser], 201);
            }
        } catch (Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Unable to login using Google. Please try again.'], 500);
        }
    }

    private function updateSiteStatistics()
    {
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
            Log::error('Error updating site statistics: ' . $e->getMessage());
        }
    }
}
