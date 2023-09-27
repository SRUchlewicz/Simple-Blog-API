<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct(
        string $token
    ) {
        $this->token = $token;
    }

    
    public function build(): self
    {
        return $this->view('email.reset_password')
                    ->with([
                        'token' => $this->token,
                    ]);
    }
}
