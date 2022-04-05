<?php
/*
 * File name: ChangeCustomerRoleToEProvider.php
 * Last modified: 2021.09.15 at 13:38:29
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Listeners;

/**
 * Class ChangeCustomerRoleToEProvider.
 */
class ChangeCustomerRoleToEProvider
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle($event): void
    {
        if ($event->newEProvider->accepted) {
            foreach ($event->newEProvider->users as $user) {
                $user->syncRoles(['provider']);
            }
        }
    }
}
