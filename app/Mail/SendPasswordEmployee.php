<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendPasswordEmployee extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $user;

    public function __construct($password, $user)
    {
        $this->password = $password;
        $this->user = $user;
    }

    public function build()
    {
        // return password and user
        return $this->markdown('emails.send-password-employee')
            ->subject('Your Password for ' . config('app.name') . ' Account')
            ->with([
                'password' => $this->password,
                'user' => $this->user
            ]);
    }
}
