<?php

namespace App\Observers\Shop;

use App\Models\Shop\Order;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     */
    public function created(Order $order): void
    {
        $order->number = $order->id + 1000;
        if (!$order->ip) {
            $order->ip = request()->ip();
        }
        $order->save();
    }

    /**
     * Handle the order "updated" event.
     */
    public function updated(Order $order): void
    {

    }

    /**
     * Handle the order "deleted" event.
     */
    public function deleted(Order $order): void
    {

    }

    /**
     * Handle the order "restored" event.
     */
    public function restored(Order $order): void
    {

    }

    /**
     * Handle the order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {

    }
}
