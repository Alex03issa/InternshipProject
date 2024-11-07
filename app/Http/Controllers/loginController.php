<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class loginController extends Controller
{
    /**
     * Show the sign-in page.
     *
     * @return \Illuminate\View\View
     */
    public function showSignIn()
    {
        return view('login');
    }

    /**
     * Handle the sign-in form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    

    public function signIn(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Find the user by email
            $user = User::where('email', $request->email)->first();
            
            

            if ($user && Hash::check($request->password, $user->password)) {
                

                if ($request->has('timezone')) {
                    $user->timezone = $request->input('timezone');
                    $user->save();
                }

                // Check if the user is an admin
                if ($user->user_type === 'admin') {

                    Auth::login($user);
                    return redirect()->route('filament.admin.pages.dashboard')->with('success', 'Logged in as Admin!');
                }

                // For regular users, check if email is verified
                if ($user->is_verified == 0) {
        
                    // Resend verification email
                    $token = $user->verification_token;
                    if (!$token) {
                        // If token is missing, generate a new one
                        $user->verification_token = Str::random(64);
                        $user->save();
                    }
                    
                try {
                    // Send verification email
                    Mail::to($user->email)->send(new VerificationMail($user));
                } catch (Exception $e) {
                    // Handle email sending exceptions
                    return redirect()->back()->with('error', 'Registration successful, but failed to send verification email. Please contact support.');
                }

                    return redirect()->route('login')->with('error', 'Your email is not verified. We have sent you a new verification email.');
                }

                // Rehash the password if it's not using Bcrypt
                if (Hash::needsRehash($user->password)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                // Log in the user
                Auth::login($user);
                return redirect()->route('homepage')->with('success', 'Logged in successfully!');
            }

            // Log failed login attempt
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);

        } catch (ValidationException $e) {
            // Handle validation exceptions
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (QueryException $e) {
            // Handle database query exceptions
            return redirect()->back()->with('error', 'There was an issue with your login. Please try again later.');

        } catch (Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return redirect()->route('homepage')->with('success', 'Logged out successfully!');
        } catch (Exception $e) {
            return redirect()->route('homepage')->with('error', 'An unexpected error occurred while logging out. Please try again.');
        }
    }
}
