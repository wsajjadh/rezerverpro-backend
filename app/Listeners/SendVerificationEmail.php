<?php

namespace App\Listeners;

use App\Events\UserSignedUp;
use App\Mail\VerificationCodeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserSignedUp $event): void
    {
        Mail::to($event->user->email)->send(
            new VerificationCodeEmail($event->user)
        );
    }
}
