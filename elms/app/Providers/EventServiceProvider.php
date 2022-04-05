<?php

namespace App\Providers;

use App\Events\NewMessage;
use App\Events\NewSubmission;
use App\Events\NewTask;
use App\Events\UsersPasswordReset;
use App\Listeners\CheckSubmission;
use App\Listeners\NotifyRecipient;
use App\Listeners\NotifyTaskStudents;
use App\Listeners\SendPasswordResets;
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
        NewSubmission::class => [
            CheckSubmission::class,
        ],
        NewTask::class => [
            NotifyTaskStudents::class,
        ],
        NewMessage::class => [
            NotifyRecipient::class,
        ],
        SendMessage::class => [
            SendtoRecipient::class,
        ],
        UsersPasswordReset::class => [
            SendPasswordResets::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

    }
}
