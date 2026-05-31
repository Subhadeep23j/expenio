<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtp extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public int $expiresInMinutes;

    public function __construct(string $otp, int $expiresInMinutes)
    {
        $this->otp = $otp;
        $this->expiresInMinutes = $expiresInMinutes;
    }

    public function build()
    {
        return $this->subject('Your password reset OTP')
            ->view('emails.password-reset-otp');
    }
}
