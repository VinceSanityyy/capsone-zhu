<?php

namespace App\Listeners;

use App\Events\ActivityLogged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogActivityListener
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
    public function handle(ActivityLogged $event): void
    {
        $event->user->logActivities()->create([
            'action' => $event->activity
        ]);
    }
}
