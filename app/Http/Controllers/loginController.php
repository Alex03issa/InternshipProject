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

                // Check if the user is an admin
                if ($user->usertype === 'admin') {
                    // Allow admin to pass even if not verified
                    Auth::login($user);
                    return redirect()->route('admin.dashboard')->with('success', 'Logged in as Admin!');
                }

                // For regular users, check if email is verified
                if (!$user->is_verified) {
                    Mail::to($user->email)->send(new VerificationMail($user));
                    return back()->withErrors([
                        'email' => 'Please verify your email address before logging in.',
                    ]);
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
    public function logout()
    {
        try {
            Auth::logout();
            return redirect()->route('homepage')->with('success', 'Logged out successfully!');
        } catch (Exception $e) {
            return redirect()->route('homepage')->with('error', 'An unexpected error occurred while logging out. Please try again.');
        }
    }
}
