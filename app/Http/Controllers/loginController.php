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
     * Show the sign-in page (for web).
     *
     * @return \Illuminate\View\View
     */
    public function showSignIn()
    {
        return view('login');
    }

    /**
     * Handle the sign-in form submission for web requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signIn(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($request->has('timezone')) {
                    $user->timezone = $request->input('timezone');
                    $user->save();
                }

                if ($user->user_type === 'admin') {
                    Auth::login($user);
                    return redirect()->route('filament.admin.pages.dashboard')->with('success', 'Logged in as Admin!');
                }

                if ($user->is_verified == 0) {
                    $token = $user->verification_token ?: Str::random(64);
                    $user->verification_token = $token;
                    $user->save();

                    try {
                        Mail::to($user->email)->send(new VerificationMail($user));
                    } catch (Exception $e) {
                        return redirect()->back()->with('error', 'Registration successful, but failed to send verification email. Please contact support.');
                    }

                    return redirect()->route('login')->with('error', 'Your email is not verified. We have sent you a new verification email.');
                }

                if (Hash::needsRehash($user->password)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                Auth::login($user);
                return redirect()->route('homepage')->with('success', 'Logged in successfully!');
            }

            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'There was an issue with your login. Please try again later.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Handle sign-in for API requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSignIn(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($request->has('timezone')) {
                    $user->timezone = $request->input('timezone');
                    $user->save();
                }

    
                if ($user->is_verified == 0) {
                    $token = $user->verification_token ?: Str::random(64);
                    $user->verification_token = $token;
                    $user->save();

                    try {
                        Mail::to($user->email)->send(new VerificationMail($user));
                    } catch (Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Registration successful, but failed to send verification email. Please contact support.'
                        ], 500);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => 'Your email is not verified. We have sent you a new verification email.'
                    ], 403);
                }

                if (Hash::needsRehash($user->password)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                $token = $user->createToken('MobileAppToken')->plainTextToken;


                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully!',
                    'token' => $token,
                    'user' => $user
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.'
            ], 401);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'There was an issue with your login. Please try again later.'
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }

    /**
     * Log the user out of the application (for web).
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

    public function apiLogout(Request $request)
    {
        try {
            // Revoke the current token that the user is using
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while logging out. Please try again.'
            ], 500);
        }
    }


}
