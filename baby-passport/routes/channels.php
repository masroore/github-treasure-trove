<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('moms.appointment.{id}', function ($user, $cartId) {
    return (int) $user->id === (int) \App\Models\Cart::find($cartId)->user_id;
});*/

Broadcast::channel('administrator', function () {
    return true;
});
