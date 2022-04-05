<?php

namespace Vanguard\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Vanguard\Events\User\Banned;
use Vanguard\Events\User\LoggedIn;
use Vanguard\Listeners\Login\UpdateLastLoginTimestamp;
use Vanguard\Listeners\Registration\SendSignUpNotification;
use Vanguard\Listeners\Users\ActivateUser;
use Vanguard\Listeners\Users\InvalidateSessions;

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
            SendSignUpNotification::class,
        ],
        LoggedIn::class => [
            UpdateLastLoginTimestamp::class,
        ],
        Banned::class => [
            InvalidateSessions::class,
        ],
        Verified::class => [
            ActivateUser::class,
        ],
        'Vanguard\Events\NewEstimateCreatedEvent' => [
            //'Vanguard\Listeners\NewEstimateCreatedListener',
            //'Vanguard\Listeners\MakeNotificationListener',
            'Vanguard\Listeners\EstimateTrackerListener',
        ],
        'Vanguard\Events\CustomerApprovedEstimateEvent' => [
            'Vanguard\Listeners\SaveApprovalSignatureListener',
            'Vanguard\Listeners\EstimateApprovedListener',
            'Vanguard\Listeners\CreateNewWorkOrderListener',
            'Vanguard\Listeners\EstimateTrackerListener',
            'Vanguard\Listeners\WorkOrderTrackerListener',
            'Vanguard\Listeners\NewInvoiceListener',

        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

    ];

    /**
     * Register any other events for your application.
     */
    public function boot(): void
    {
        parent::boot();

    }
}
