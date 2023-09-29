<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeMessage implements ShouldQueue
{
    public function handle(UserRegistered $event)
    {
        Mail::to($event->user->email)->send(
            new WelcomeMail($event->user)
        );
    }
}
