<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Exception;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            // Check if the request is from API
            $isApiClient = request()->header('Client-Type') === 'API';

            // Step 1: Decrypt the verification token
            try {
                $decryptedToken = Crypt::decryptString($this->user->verification_token);
            } catch (Exception $e) {
                Log::warning("Failed to decrypt verification token for a user.");
                throw new Exception("An error occurred. Please try again.");
            }

            // Step 2: Decode the token and validate its structure
            $decodedToken = json_decode($decryptedToken, true);
            if (!isset($decodedToken['data'], $decodedToken['hmac'])) {
                Log::warning("Invalid token structure detected during email verification.");
                throw new Exception("An error occurred. Please try again.");
            }

            $tokenData = $decodedToken['data'];
            $providedHmac = $decodedToken['hmac'];

            // Step 3: Validate HMAC integrity
            try {
                $calculatedHmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
                if ($providedHmac !== $calculatedHmac) {
                    Log::warning("HMAC validation failed for a verification token.");
                    throw new Exception("An error occurred. Please try again.");
                }
            } catch (Exception $e) {
                Log::error("HMAC validation error during email verification.");
                throw new Exception("An error occurred. Please try again.");
            }

            // Step 4: Decode the token data
            try {
                $tokenDataArray = json_decode($tokenData, true);
                if (!isset($tokenDataArray['timestamp'])) {
                    Log::warning("Invalid token data structure during email verification.");
                    throw new Exception("An error occurred. Please try again.");
                }
            } catch (Exception $e) {
                Log::error("Token data decoding error during email verification.");
                throw new Exception("An error occurred. Please try again.");
            }

            // Step 5: Construct the verification URL
            $verificationUrl = $isApiClient
                ? url('/api/apiverify-email/' . $this->user->verification_token) // API link
                : route('verify.email', ['token' => $this->user->verification_token]); // Web link

            Log::info("Verification email is being sent.");

            // Step 6: Build and return the email
            return $this->subject(__('Email Verification'))
                        ->view('emails.verify')
                        ->with([
                            'verificationUrl' => $verificationUrl,
                            'user' => $this->user,
                            'isApiClient' => $isApiClient, // Pass this to the email view
                        ]);
        } catch (Exception $e) {
            Log::error("Error building verification mail: " . $e->getMessage());
            throw new Exception("Unable to send the verification email. Please try again later.");
        }
    }
}
