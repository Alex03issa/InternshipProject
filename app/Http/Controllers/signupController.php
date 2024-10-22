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
        // Log request data for debugging
        Log::info('Signup request received', ['request' => $request->all()]);

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

        // Log validation success
        Log::info('Signup validation successful', ['email' => $request->email]);

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

        // Log user creation success
        Log::info('User created successfully', ['user_id' => $user->id, 'email' => $user->email]);

        // Send verification email
        try {
            // Send verification email
            Mail::to($user->email)->send(new VerificationMail($user));
        } catch (Exception $e) {
            // Handle email sending exceptions
            Log::error('Email sending error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Registration successful, but failed to send verification email. Please contact support.');
        }
        return redirect()->back()->with('success', 'Registration successful! Please check your email to verify your account.');


        } catch (ValidationException $e) {
            // Handle validation exceptions
            Log::error('Validation error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (QueryException $e) {
            // Handle database query exceptions
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an issue with your registration. Please try again later.');

        } catch (Exception $e) {
            // Handle general exceptions
            Log::error('General error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}