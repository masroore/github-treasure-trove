<?php

namespace App\Providers;

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

    ];

    /**
     * Register any events for your application.
     */
    protected $subscribe = [
        'App\Listeners\AuthSubscriber',
        'App\Listeners\TeamSubscriber',
        'App\Listeners\CategorySubscriber',
        'App\Listeners\TaskSubscriber',
        'App\Listeners\ActivitySubscriber',
    ];

    public function boot(): void
    {
        parent::boot();

    }
}
