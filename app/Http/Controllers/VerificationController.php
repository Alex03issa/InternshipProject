<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid token or the email is already verified.');
        }

        $user->is_verified = true;
        $user->verification_token = null;
        $user->save();

        // Automatically log the user in after verification
        Auth::login($user);

        return redirect()->route('home.verified')->with('success', 'Email verified successfully');

    }


    public function apiverify($token)
    {
        try {
            $user = User::where('verification_token', $token)->first();

            if (!$user || $user->is_verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token is invalid or the email is already verified.',
                ], 400);
            }
            

            $user->is_verified = true;
            $user->verification_token = null;
            $user->save();

            // Automatically log the user in after verification
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully.',
                'user' => $user,
                'token' => $user->createToken('AppToken')->plainTextToken, // Provide token for app session
            ]);
        } catch (Exception $e) {
            Log::error("Verification Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying the email. Please try again.',
            ], 500);
        }
    }

}
