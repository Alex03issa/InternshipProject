<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Show the password reset form (Web).
     *
     * @param string|null $token
     * @return \Illuminate\View\View
     */
    public function showResetForm($token)
    {
        try {
            Log::info("Received reset token for password reset form.", ['token' => $token]);

            // Decrypt the token
            $decryptedToken = Crypt::decryptString($token);
            $decodedToken = json_decode($decryptedToken, true);

            if (!isset($decodedToken['data'], $decodedToken['hmac'])) {
                Log::error("Invalid token structure.", ['token' => $token]);
                throw new Exception("Invalid token format.");
            }

            $tokenData = json_decode($decodedToken['data'], true);

            // Verify HMAC integrity
            $calculatedHmac = hash_hmac('sha256', $decodedToken['data'], env('HASH_SECRET'));
            if ($calculatedHmac !== $decodedToken['hmac']) {
                Log::error("HMAC verification failed.", ['token' => $token]);
                throw new Exception("Token integrity check failed.");
            }

            // Check token expiry
            if ($tokenData['timestamp'] < now()->timestamp) {
                Log::error("Token has expired.", ['token' => $token, 'timestamp' => $tokenData['timestamp']]);
                throw new Exception("Token has expired.");
            }

            Log::info("Token is valid and has not expired.", ['tokenData' => $tokenData]);

            return view('auth.passwords.reset', [
                'token' => $token,
                'email' => $tokenData['email'],
            ]);
        } catch (Exception $e) {
            Log::error('Password Reset Token Error: ' . $e->getMessage(), ['exception' => $e]);
            return view('auth.passwords.email')->withErrors([
                'email' => 'Invalid or expired reset link. Please request a new one.',
            ]);
        }
    }

    /**
     * Handle password reset (Web).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        try {
            Log::info('Password reset request received.', ['email' => $request->email]);

            // Validate the incoming request
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
            ]);

            // Step 1: Decrypt the token
            Log::info('Decrypting the reset token...', ['token' => $request->token]);
            $encryptedToken = $request->token;
            $tokenPayload = json_decode(Crypt::decryptString($encryptedToken), true);

            if (!isset($tokenPayload['data'], $tokenPayload['hmac'])) {
                Log::error('Invalid token structure.', ['token' => $encryptedToken]);
                return back()->withErrors(['email' => 'Invalid token format.']);
            }

            // Validate HMAC
            $expectedHmac = hash_hmac('sha256', $tokenPayload['data'], env('HASH_SECRET'));
            if ($expectedHmac !== $tokenPayload['hmac']) {
                Log::error('HMAC validation failed.', ['token' => $encryptedToken]);
                return back()->withErrors(['email' => 'Invalid or tampered token.']);
            }

            $tokenData = json_decode($tokenPayload['data'], true);

            // Validate token expiry
            if (now()->timestamp > $tokenData['timestamp']) {
                Log::error('Token expired.', ['timestamp' => $tokenData['timestamp']]);
                return back()->withErrors(['email' => 'The password reset link has expired.']);
            }

            // Look up the user and reset record
            $hashedEmail = hash_hmac('sha256', $request->email, env('HASH_SECRET'));
            $passwordReset = \DB::table('password_reset_tokens')
                ->where('hashed_email', $hashedEmail)
                ->first();

            if (!$passwordReset) {
                Log::error('Password reset record not found.', ['hashed_email' => $hashedEmail]);
                return back()->withErrors(['email' => 'Invalid or expired token.']);
            }

            // Compare tokens
            if ($passwordReset->token !== $request->token) {
                Log::error('Token mismatch.', ['requestToken' => $request->token, 'dbToken' => $passwordReset->token]);
                return back()->withErrors(['email' => 'Invalid or expired token.']);
            }

            // Reset the user's password
            $user = User::where('hashed_email', $hashedEmail)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the reset record
            \DB::table('password_reset_tokens')->where('hashed_email', $hashedEmail)->delete();

            Log::info('Password reset successfully.', ['userId' => $user->id]);
            return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
        } catch (Exception $e) {
            Log::error('ResetPassword Error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withErrors(['email' => 'Unable to reset the password. Please try again.']);
        }
    }

    /**
     * Handle password reset for API requests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiResetPassword(Request $request)
    {
        try {
            Log::info('API password reset request received.', ['email' => $request->email]);

            // Validate the request
            $request->validate([
                'token' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Decrypt and validate the token
            $encryptedToken = $request->token;
            $tokenPayload = json_decode(Crypt::decryptString($encryptedToken), true);

            if (!isset($tokenPayload['data'], $tokenPayload['hmac'])) {
                Log::error('Invalid token format.');
                return response()->json(['success' => false, 'message' => 'Invalid token format.'], 400);
            }

            // Validate HMAC
            $expectedHmac = hash_hmac('sha256', $tokenPayload['data'], env('HASH_SECRET'));
            if ($expectedHmac !== $tokenPayload['hmac']) {
                Log::error('HMAC validation failed.');
                return response()->json(['success' => false, 'message' => 'Invalid or tampered token.'], 400);
            }

            $tokenData = json_decode($tokenPayload['data'], true);

            // Validate token expiry
            if (now()->timestamp > $tokenData['timestamp']) {
                Log::error('Token expired.', ['timestamp' => $tokenData['timestamp']]);
                return response()->json(['success' => false, 'message' => 'The password reset link has expired.'], 400);
            }

            // Look up the user and reset record
            $hashedEmail = hash_hmac('sha256', $request->email, env('HASH_SECRET'));
            $passwordReset = \DB::table('password_reset_tokens')
                ->where('hashed_email', $hashedEmail)
                ->first();

            if (!$passwordReset) {
                Log::error('Password reset record not found.', ['hashed_email' => $hashedEmail]);
                return response()->json(['success' => false, 'message' => 'Invalid or expired token.'], 400);
            }

            // Compare tokens
            if ($passwordReset->token !== $request->token) {
                Log::error('Token mismatch.', ['requestToken' => $request->token, 'dbToken' => $passwordReset->token]);
                return response()->json(['success' => false, 'message' => 'Invalid or expired token.'], 400);
            }

            // Reset the user's password
            $user = User::where('hashed_email', $hashedEmail)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the reset record
            \DB::table('password_reset_tokens')->where('hashed_email', $hashedEmail)->delete();

            Log::info('Password reset successfully for API.', ['userId' => $user->id]);
            return response()->json(['success' => true, 'message' => 'Your password has been reset successfully.'], 200);
        } catch (Exception $e) {
            Log::error('API ResetPassword Error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Unable to reset the password. Please try again.'], 500);
        }
    }
}
