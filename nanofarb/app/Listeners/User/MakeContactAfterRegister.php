<?php

namespace App\Listeners\User;

class MakeContactAfterRegister
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        if (($user = $event->user) && $user instanceof \App\Models\User) {
            $contact = $user->contacts()->create([
                'name' => $user->full_name,
                'phone' => $user->phone,
                'email' => $user->email,
            ]);
            $user->contact_id = $contact->id;
            $user->save();
        }
    }
}
