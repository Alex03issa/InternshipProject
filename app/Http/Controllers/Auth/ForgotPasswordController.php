<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Exception;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            Log::info('Password reset request received (web).', ['email' => $request->email]);

            // Validate the input
            $request->validate(['email' => 'required|email']);

            // Hash the email to find the user
            $hashedEmail = hash_hmac('sha256', $request->email, env('HASH_SECRET'));
            $user = User::where('hashed_email', $hashedEmail)->first();

            if (!$user) {
                Log::warning('No user found with the provided email (web).', ['hashed_email' => $hashedEmail]);
                return back()->withErrors(['email' => 'No user found with this email.']);
            }

            // Decrypt the stored email
            $encryptedData = Crypt::decryptString($user->email);
            $data = json_decode($encryptedData, true);

            if (!isset($data['email'])) {
                Log::error('Invalid email structure in the database.', ['user_id' => $user->id]);
                return back()->withErrors(['email' => 'Invalid email structure.']);
            }

            $decryptedEmail = Crypt::decryptString($data['email']);
            if ($decryptedEmail !== $request->email) {
                Log::warning('Email mismatch detected.', ['user_id' => $user->id]);
                return back()->withErrors(['email' => 'Invalid email address.']);
            }

            // Generate the password reset token
            $plainToken = Password::broker()->createToken($user);

            // Encrypt the token
            $tokenData = json_encode([
                'user_id' => $user->id,
                'email' => $decryptedEmail,
                'token' => $plainToken,
                'timestamp' => now()->addMinutes(30)->timestamp, // Token expiry
            ]);
            $hmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            $encryptedToken = Crypt::encryptString(json_encode(['data' => $tokenData, 'hmac' => $hmac]));

            Log::info("Generated encrypted password reset token for user ID {$user->id}.");

            // Store the token
            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => $encryptedToken,
                    'created_at' => now(),
                    'hashed_email' => $hashedEmail,
                ]
            );

            // Send the reset link email
            Mail::to($decryptedEmail)->send(new PasswordResetMail($user, $encryptedToken));
            Log::info("Password reset email sent to {$decryptedEmail}.");

            return back()->with('success', 'Password reset link sent successfully. Please check your email.');
        } catch (Exception $e) {
            Log::error('ForgotPassword Error (web): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors(['email' => 'We couldn\'t send you an email right now. Please try again later.']);
        }
    }

    public function apiForgotPassword(Request $request)
    {
        try {
            Log::info('Password reset request received (API).', ['email' => $request->email]);

            // Validate the input
            $request->validate(['email' => 'required|email']);

            // Hash the email to find the user
            $hashedEmail = hash_hmac('sha256', $request->email, env('HASH_SECRET'));
            $user = User::where('hashed_email', $hashedEmail)->first();

            if (!$user) {
                Log::warning('No user found with the provided email (API).', ['hashed_email' => $hashedEmail]);
                return response()->json(['success' => false, 'message' => 'No user found with this email.'], 404);
            }

            // Decrypt the stored email
            $encryptedData = Crypt::decryptString($user->email);
            $data = json_decode($encryptedData, true);

            if (!isset($data['email'])) {
                Log::error('Invalid email structure in the database.', ['user_id' => $user->id]);
                return response()->json(['success' => false, 'message' => 'Invalid email structure.'], 400);
            }

            $decryptedEmail = Crypt::decryptString($data['email']);
            if ($decryptedEmail !== $request->email) {
                Log::warning('Email mismatch detected.', ['user_id' => $user->id]);
                return response()->json(['success' => false, 'message' => 'Invalid email address.'], 400);
            }

            // Generate the password reset token
            $plainToken = Password::broker()->createToken($user);

            // Encrypt the token
            $tokenData = json_encode([
                'user_id' => $user->id,
                'email' => $decryptedEmail,
                'token' => $plainToken,
                'timestamp' => now()->addMinutes(30)->timestamp, // Token expiry
            ]);
            $hmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            $encryptedToken = Crypt::encryptString(json_encode(['data' => $tokenData, 'hmac' => $hmac]));

            Log::info("Generated encrypted password reset token for user ID {$user->id} (API).");

            // Store the token
            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => $encryptedToken,
                    'created_at' => now(),
                    'hashed_email' => $hashedEmail,
                ]
            );

            // Prepare the reset link
            $resetUrl = url("/password/reset/{$encryptedToken}");

            Log::info("Password reset link generated successfully (API): {$resetUrl}");

            return response()->json([
                'success' => true,
                'message' => 'Password reset link generated successfully.',
                'reset_link' => $resetUrl,
            ], 200);
        } catch (Exception $e) {
            Log::error('API ForgotPassword Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Unable to send password reset email. Please try again later.'], 500);
        }
    }
}
