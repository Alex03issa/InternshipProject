<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
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
        $isApiClient = request()->header('Client-Type') === 'API'; // Assume a custom header is sent to indicate client type
    
        $verificationUrl = $isApiClient
            ? url('/api/apiverify-email/' . $this->user->verification_token) // API link
            : route('verify.email', ['token' => $this->user->verification_token]); // Web link
    
        return $this->subject('Email Verification')
                    ->view('emails.verify')
                    ->with([
                        'verificationUrl' => $verificationUrl,
                        'user' => $this->user,
                        'isApiClient' => $isApiClient, // Pass this to the email view
                    ]);
    }
    


}
