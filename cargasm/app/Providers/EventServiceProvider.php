<?php

namespace App\Providers;

use App\Events\EventSortable;
use App\Listeners\NotifyEventSortable;
use App\Listeners\SendNotifyAfterEmailVerified;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            //            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            SendNotifyAfterEmailVerified::class,
        ],
        SocialiteWasCalled::class => [
            VKontakteExtendSocialite::class,
            'SocialiteProviders\\Apple\\AppleExtendSocialite@handle',
        ],

        'App\Events\NewChatMessage' => [
            'App\Listeners\SendChatMessageNotification',
        ],
        EventSortable::class => [
            NotifyEventSortable::class,
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
