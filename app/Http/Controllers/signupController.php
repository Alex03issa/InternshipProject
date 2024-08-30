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
            ]);

        // Generate the verification token
        $verificationToken = Str::random(32);

        // Create the user with the verification token
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $verificationToken, 
        ]);

       
            // Send verification email
            Mail::to($user->email)->send(new VerificationMail($user));
            return redirect()->back()->with('success', 'Registration successful! Please check your email to verify your account.');


        } catch (ValidationException $e) {
            // Handle validation exceptions
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (QueryException $e) {
            // Handle database query exceptions
            return redirect()->back()->with('error', 'There was an issue with your registration. Please try again later.');

        } catch (Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}