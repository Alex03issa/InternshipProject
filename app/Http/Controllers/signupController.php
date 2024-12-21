<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use App\Models\SiteStatistic;
use Illuminate\Support\Facades\Validator;

class signupController extends Controller
{
    /**
     * Show the sign-up page.
     *
     * @return \Illuminate\View\View
     */
    public function showSignUp()
    {
        return view('signup');
    }

    /**
     * Handle the sign-up form submission (Web).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[^A-Za-z0-9]/'
                ],
                'timezone' => 'required|string',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->with('error','Please choose a strong password to sign up');
            }

            // Capture timezone and current timestamp
            $timezone = $request->input('timezone');
            $now = Carbon::now($timezone);

            // Inline encryption logic for email
            $saltedHash = hash_hmac('sha256', $request->email, env('HASH_SECRET'));
            $firstEncryption = Crypt::encryptString($request->email);
            $encryptedEmail = Crypt::encryptString(json_encode([
                'email' => $firstEncryption,
                'hash' => $saltedHash,
            ]));

            // Inline verification token generation
            $tokenData = json_encode([
                'user_id' => $request->username,
                'email' => $request->email,
                'timestamp' => now()->addMinutes(30)->timestamp,
            ]);
            $hmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            $verificationToken = Crypt::encryptString(json_encode(['data' => $tokenData, 'hmac' => $hmac]));

            // Store the user in the database
            $user = User::create([
                'username' => $request->username,
                'email' => $encryptedEmail,
                'hashed_email' => $saltedHash,
                'password' => Hash::make($request->password),
                'verification_token' => $verificationToken,
                'provider' => 'sidetoside',
                'timezone' => $timezone,
                'created_at' => $now,
            ]);

            // Update statistics
            DB::beginTransaction();
            try {
                $this->updateSiteStatistics();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error during user registration: ' . $e->getMessage());
            }

            // Send verification email
            $this->sendVerificationEmail($user);

            return redirect()->back()->with('success', 'Registration successful! Please check your email to verify your account.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'There was an issue with your registration. Please try again later.');
        } catch (Exception $e) {
            Log::error("Sign-up Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Handle the sign-up form submission (API).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSignUp(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'timezone' => 'string',
            ]);

            // Capture timezone and current timestamp
            $timezone = $request->input('timezone', 'UTC');
            $now = Carbon::now($timezone);

            // Inline encryption logic for email
            $saltedHash = hash_hmac('sha256', $request->email, env('HASH_SECRET'));
            $firstEncryption = Crypt::encryptString($request->email);
            $encryptedEmail = Crypt::encryptString(json_encode([
                'email' => $firstEncryption,
                'hash' => $saltedHash,
            ]));

            // Inline verification token generation
            $tokenData = json_encode([
                'user_id' => $request->username,
                'email' => $request->email,
                'timestamp' => now()->addMinutes(30)->timestamp,
            ]);
            $hmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            $verificationToken = Crypt::encryptString(json_encode(['data' => $tokenData, 'hmac' => $hmac]));

            // Store the user in the database
            $user = User::create([
                'username' => $request->username,
                'email' => $encryptedEmail,
                'hashed_email' => $saltedHash,
                'password' => Hash::make($request->password),
                'verification_token' => $verificationToken,
                'provider' => 'sidetoside',
                'timezone' => $timezone,
                'created_at' => $now,
            ]);

            // Update statistics
            DB::beginTransaction();
            try {
                $this->updateSiteStatistics();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error during user registration: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Error updating statistics.'], 500);
            }

            // Send verification email
            $this->sendVerificationEmail($user);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please check your email to verify your account.',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'There was an issue with your registration. Please try again later.',
            ], 500);
        } catch (Exception $e) {
            Log::error("API Sign-up Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.',
            ], 500);
        }
    }

    /**
     * Update site statistics for user registration.
     */
    protected function updateSiteStatistics()
    {
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
    }

    /**
     * Send the verification email to the user.
     *
     * @param User $user
     */
    protected function sendVerificationEmail(User $user)
    {
        try {
            // Step 1: Decrypt the outer encryption layer
            $encryptedData = Crypt::decryptString($user->email);
            \Log::info("Step 1: Decrypted Outer Layer -> {$encryptedData}");
    
            // Step 2: Decode JSON to extract inner encryption and hash
            $data = json_decode($encryptedData, true);
            \Log::info("Step 2: Decoded JSON Data -> " . print_r($data, true));
    
            if (!isset($data['email']) || !isset($data['hash'])) {
                throw new Exception("Invalid email structure.");
            }
    
            // Step 3: Decrypt the inner encryption layer
            $decryptedEmail = Crypt::decryptString($data['email']);
            \Log::info("Step 3: Decrypted Email -> {$decryptedEmail}");
    
            // Optional: Verify the hash for integrity
            $calculatedHash = hash_hmac('sha256', $decryptedEmail, env('HASH_SECRET'));
            if ($calculatedHash !== $data['hash']) {
                throw new Exception("Hash integrity check failed.");
            }
            \Log::info("Step 4: Hash Verified Successfully");
    
            // Send the verification email
            Mail::to($decryptedEmail)->send(new VerificationMail($user));
            \Log::info("Verification email sent to: " . $decryptedEmail);
    
        } catch (Exception $e) {
            Log::error("Failed to send verification email: " . $e->getMessage());
        }
    }
}
