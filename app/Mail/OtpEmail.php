<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class OtpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $user;

    public function __construct($otp, $user)
    {
        $this->otp = $otp;
        $this->user = $user;
    }

    public function build()
    {
        // return otp and user
        return $this->markdown('emails.otp')
            ->subject('Your OTP for Password Reset')
            ->with([
                'otp' => $this->otp,
                'user' => $this->user
            ]);
    }
}
