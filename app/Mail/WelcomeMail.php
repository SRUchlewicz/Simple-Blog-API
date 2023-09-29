<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('email.welcome')
                    ->with([
                        'user_name' => $this->user->firstname,
                    ]);
    }
}
