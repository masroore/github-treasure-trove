<?php

namespace App\Listeners;

use App\Mail\ChangeEmail;
use App\Mail\ChangeOldEmail;
use App\Mail\NewUserAdminEmail;
use App\Notifications\Auth\Admin\AddNewUser as AddNewUserNotification;
use App\Notifications\Auth\Recovery as AuthRecoveryNotification;
use App\Notifications\Auth\Register as AuthRegisterNotification;
use App\Services\SeedService;
use App\Services\TeamService;
use Illuminate\Support\Facades\Mail;

class AuthSubscriber
{
    public function __construct(
        TeamService $teamService,
        SeedService $seedService
    ) {
        $this->teamService = $teamService;
        $this->seedService = $seedService;
    }

    public function onRegister($event): void
    {
        $event->user->notify((new AuthRegisterNotification($event->link)));
        if (env('APP_ENV') == 'production') {
            Mail::to('new-registrations@treenga.com')->send(new NewUserAdminEmail($event->user->email));
        }
    }

    public function onRecovery($event): void
    {
        $event->user->notify(new AuthRecoveryNotification($event->link));
    }

    public function onAddNewUser($event): void
    {
        $event->user->notify((new AddNewUserNotification($event->user, $event->link, $event->me)));
    }

    public function onChangeEmail($event): void
    {
        Mail::to($event->user->new_email)->send(new ChangeEmail($event->link));
        Mail::to($event->user->email)->send(new ChangeOldEmail());
    }

    public function onVerify($event): void
    {
        $this->teamService->createPrivate($event->user);
        $this->seedService->seed($event->user);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events): void
    {
        $events->listen(
            'App\Events\Auth\Register',
            'App\Listeners\AuthSubscriber@onRegister'
        );
        $events->listen(
            'App\Events\Auth\Recovery',
            'App\Listeners\AuthSubscriber@onRecovery'
        );
        $events->listen(
            'App\Events\Auth\Admin\AddNewUser',
            'App\Listeners\AuthSubscriber@onAddNewUser'
        );
        $events->listen(
            'App\Events\Auth\ChangeEmail',
            'App\Listeners\AuthSubscriber@onChangeEmail'
        );
        $events->listen(
            'App\Events\Auth\Verify',
            'App\Listeners\AuthSubscriber@onVerify'
        );
    }
}
