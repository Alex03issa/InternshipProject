<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $encryptedToken;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $encryptedToken
     */
    public function __construct($user, $encryptedToken)
    {
        $this->user = $user;
        $this->encryptedToken = $encryptedToken;

        // Log construction, but avoid logging sensitive data
        Log::info("PasswordResetMail Mailable constructed for user.");
    }

    /**
     * Build the email message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            // Generate the reset URL
            $resetUrl = url("/password/reset/{$this->encryptedToken}");

            // Log that the email is being built, without sensitive details
            Log::info("Building PasswordResetMail for user.");

            // Build and return the email
            return $this->subject('Reset Your Password')
                        ->view('emails.password_reset')
                        ->with([
                            'resetUrl' => $resetUrl,
                            'user' => $this->user,
                        ]);
        } catch (\Exception $e) {
            // Log the error without exposing sensitive data
            Log::error("Error building PasswordResetMail: " . $e->getMessage());
            throw new \Exception("Unable to build the password reset email. Please try again later.");
        }
    }
}
