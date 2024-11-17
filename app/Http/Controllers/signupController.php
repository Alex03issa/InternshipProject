<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\SiteStatistic;
use Illuminate\Support\Facades\DB;

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
     * Handle the sign-up form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

     public function signUp(Request $request)
     {

        try {
            // Validate the request data
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'timezone' => 'required|string',
            ]);

        $timezone = $request->input('timezone');
        $now = Carbon::now($timezone);


        // Generate the verification token
        $verificationToken = Str::random(64);

        // Create the user with the verification token
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $verificationToken,
            'provider' => 'sidetoside',
            'timezone' => $timezone,
            'created_at' => $now, 
        ]);

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

        // Send verification email
        try {
            // Send verification email
            Mail::to($user->email)->send(new VerificationMail($user));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Registration successful, but failed to send verification email. Please contact support.');
        }
        return redirect()->back()->with('success', 'Registration successful! Please check your email to verify your account.');


        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'There was an issue with your registration. Please try again later.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Handle the sign-up API request.
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

            $timezone = $request->input('timezone');
            $now = Carbon::now($timezone);

            // Generate the verification token
            $verificationToken = Str::random(64);

            // Create the user with the verification token
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_token' => $verificationToken,
                'provider' => 'sidetoside',
                'timezone' => $timezone,
                'created_at' => $now,
            ]);

            DB::beginTransaction();
            try {
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
                return response()->json(['success' => false, 'message' => 'Error updating statistics.'], 500);
            }

            // Send verification email
            try {
                Mail::to($user->email)->send(new VerificationMail($user));
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration successful, but failed to send verification email. Please contact support.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please check your email to verify your account.'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'There was an issue with your registration. Please try again later.'
            ], 500);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }
    
}