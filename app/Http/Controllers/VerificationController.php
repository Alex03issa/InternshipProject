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
            return redirect()->route('login')->with('error', 'Invalid token');
        }

        $user->is_verified = true;
        $user->verification_token = null;
        $user->save();

        // Automatically log the user in after verification
        Auth::login($user);

        return redirect()->route('home.verified')->with('success', 'Email verified successfully');

    }

}
