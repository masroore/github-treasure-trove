<?php

namespace App\Providers;

use App\Events\MessageSent;
use App\Events\UserRegistered;
use App\Listeners\SendEmailMessageToUser;
use App\Listeners\SendNotificationMessageToUser;
use App\Listeners\SendRegistrationEmailToUser;
use App\Listeners\SendRegistrationNotificationToUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MessageSent::class => [
            SendEmailMessageToUser::class,
            SendNotificationMessageToUser::class,
        ],
        UserRegistered::class => [
            SendRegistrationEmailToUser::class,
            SendRegistrationNotificationToUser::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
