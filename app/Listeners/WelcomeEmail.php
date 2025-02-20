<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class WelcomeEmail
{
    /**
     * Handle the event.
     */
    public function handle(Registered|Verified $event): void
    {
        if (! $event->user instanceof MustVerifyEmail || $event instanceof Verified) {
            $event->user->sendWelcomeEmail();
        }
    }
}
