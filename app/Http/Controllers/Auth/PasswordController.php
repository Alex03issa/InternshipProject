<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;

class PasswordController extends Controller
{
    public function showCreateForm()
    {
        try {
            return view('auth.passwordcreation');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to load the password creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = Auth::user();

            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();

                Auth::logout();
                return redirect()->route('login')->with('status', 'Password set successfully! Please login.');
            }

            return redirect()->route('login')->with('error', 'User not found. Please try again.');
        
        } catch (ValidationException $e) {
            // Handle validation exceptions
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (QueryException $e) {
            // Handle database-related exceptions
            return redirect()->route('login')->with('error', 'There was an issue saving your password. Please try again later.');

        } catch (Exception $e) {
            // Handle general exceptions
            return redirect()->route('login')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function prompt()
    {
        try {
            return view('auth.password_prompt');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to load the password prompt. Please try again.');
        }
    }

    public function handleChoice(Request $request)
    {
        try {
            if ($request->input('action') === 'change') {
                return redirect()->route('password.create');
            }

            // If the user wants to keep the generated password, log them in and redirect to homepage
            return redirect()->route('homepage')->with('success', 'You are logged in with your new password!');
        
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'An unexpected error occurred while processing your choice. Please try again.');
        }
    }
}