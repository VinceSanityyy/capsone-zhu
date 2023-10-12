<?php

namespace App\Listeners;

use App\Events\UserConfirmed;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(UserConfirmed $event): void
    {
        // dd($event->user);
        Mail::to($event->user->email)->send(new \App\Mail\UserConfirmed($event->user));
    }
}
