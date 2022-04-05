<?php

namespace App\Listeners;

use App\Events\RequestPersonalData;
use App\Mail\User\PersonalData;
use Illuminate\Support\Facades\Mail;

class EmailPersonalData
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
    public function handle(RequestPersonalData $event): void
    {
        Mail::to($event->user->email)->send(new PersonalData($event->user, $event->time));
    }
}
