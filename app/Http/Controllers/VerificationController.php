<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Exception;

class VerificationController extends Controller
{
    /**
     * Handle email verification (Web).
     *
     * @param string $encryptedToken
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($encryptedToken)
    {
        try {
            Log::info('Starting email verification (Web).', ['token' => $encryptedToken]);

            // Decrypt the token
            $token = Crypt::decryptString($encryptedToken);
            $decodedToken = json_decode($token, true);

            if (!isset($decodedToken['data'], $decodedToken['hmac'])) {
                throw new Exception('Invalid token structure.');
            }

            $tokenData = $decodedToken['data'];
            $providedHmac = $decodedToken['hmac'];

            // Verify HMAC integrity
            $calculatedHmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            if ($calculatedHmac !== $providedHmac) {
                throw new Exception('Token integrity verification failed.');
            }

            // Decode token data
            $decodedData = json_decode($tokenData, true);
            if (!isset($decodedData['user_id'], $decodedData['email'], $decodedData['timestamp'])) {
                throw new Exception('Invalid token data.');
            }

            // Validate token expiry
            if ($decodedData['timestamp'] < now()->timestamp) {
                throw new Exception('Token has expired.');
            }

            // Retrieve user
            $hashedEmail = hash_hmac('sha256', $decodedData['email'], env('HASH_SECRET'));
            $user = User::where('hashed_email', $hashedEmail)->first();

            if (!$user) {
                throw new Exception('User not found for the given token.');
            }

            if ($user->is_verified) {
                throw new Exception('Email is already verified.');
            }

            // Mark user as verified
            $user->is_verified = true;
            $user->verification_token = null;
            $user->save();

            Auth::login($user);

            Log::info('Email verified successfully.', ['user_id' => $user->id]);
            return redirect()->route('home.verified')->with('success', 'Email verified successfully.');
        } catch (Exception $e) {
            Log::error('Verification Error (Web): ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle email verification (API).
     *
     * @param string $encryptedToken
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiVerify($encryptedToken)
    {
        try {
            Log::info('Starting email verification (API).', ['token' => $encryptedToken]);

            // Decrypt the token
            $token = Crypt::decryptString($encryptedToken);
            $decodedToken = json_decode($token, true);

            if (!isset($decodedToken['data'], $decodedToken['hmac'])) {
                throw new Exception('Invalid token structure.');
            }

            $tokenData = $decodedToken['data'];
            $providedHmac = $decodedToken['hmac'];

            // Verify HMAC integrity
            $calculatedHmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            if ($calculatedHmac !== $providedHmac) {
                throw new Exception('Token integrity verification failed.');
            }

            // Decode token data
            $decodedData = json_decode($tokenData, true);
            if (!isset($decodedData['user_id'], $decodedData['email'], $decodedData['timestamp'])) {
                throw new Exception('Invalid token data.');
            }

            // Validate token expiry
            if ($decodedData['timestamp'] < now()->timestamp) {
                throw new Exception('Token has expired.');
            }

            // Retrieve user
            $hashedEmail = hash_hmac('sha256', $decodedData['email'], env('HASH_SECRET'));
            $user = User::where('hashed_email', $hashedEmail)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found for the given token.',
                ], 404);
            }

            if ($user->is_verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is already verified.',
                ], 400);
            }

            // Mark user as verified
            $user->is_verified = true;
            $user->verification_token = null;
            $user->save();

            // Automatically log the user in after verification
            Auth::login($user);

            // Generate encrypted API token
            $plainToken = $user->createToken('AppToken')->plainTextToken;
            $encryptedToken = Crypt::encryptString($plainToken);

            Log::info('Email verified successfully (API).', ['user_id' => $user->id]);
            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully.',
                'user' => [
                    'id' => $user->id,
                    'email' => Crypt::decryptString(json_decode(Crypt::decryptString($user->email), true)['email']),
                ],
                'token' => $encryptedToken,
            ], 200);
        } catch (Exception $e) {
            Log::error('Verification Error (API): ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Verification failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
