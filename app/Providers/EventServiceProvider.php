<?php

namespace App\Providers;

use App\Events\ActivityLogged;
use App\Events\SchedulePlotted;
use App\Events\UserConfirmed;
use App\Events\UserCreated;
use App\Listeners\LogActivityListener;
use App\Listeners\SendEmailNotification;
use App\Listeners\SendSMSMessageToStudent;
use App\Listeners\SendUserEmailWithPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserConfirmed::class => [
            SendEmailNotification::class,
        ],
        UserCreated::class =>[
            SendUserEmailWithPassword::class,
        ],
        SchedulePlotted::class => [
            SendSMSMessageToStudent::class,
        ],
        ActivityLogged::class => [
            LogActivityListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
