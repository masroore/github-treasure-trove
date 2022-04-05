<?php

namespace App\Providers;

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
            //SendEmailVerificationNotification::class,
            \App\Listeners\User\MakeContactAfterRegister::class,
            \App\Listeners\User\SendEmailAfterRegistered::class,
        ],

        \App\Events\User\Created::class => [
            \App\Listeners\User\SendEmailAfterCreated::class,
        ],

        \App\Events\Form\Created::class => [
            \App\Listeners\Form\SendEmailAfterCreated::class,
            \App\Listeners\Form\SendToServices::class,
        ],

        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\MergeShoppingCarts::class,
        ],

        \App\Events\Shop\OrderConfirmed::class => [
            \App\Listeners\Shop\SendEmailOrderConfirmed::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

    }
}
