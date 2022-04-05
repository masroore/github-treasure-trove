<?php

namespace App\Listeners;

class MergeShoppingCarts
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
     * @param  object  $event
     */
    public function handle($event): void
    {
//        \Cart::merge(['eloquent', 'cookie']);
        //\Favorite::merge(['eloquent', 'cookie']);
    }
}
