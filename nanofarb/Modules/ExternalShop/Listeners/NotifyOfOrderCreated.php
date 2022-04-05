<?php

namespace Modules\ExternalShop\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class NotifyOfOrderCreated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //...
    }

    /**
     * Handle the event.
     */
    public function handle(\Modules\ExternalShop\Events\OrderCreated $event): void
    {
        $order = $event->order;

        if (variable('externalshop_send_seller_email')) {
            $mails = array_map(function ($mail) {
                return trim($mail);
            }, explode(',', variable('mail_to_address')));
            if ($mails) {
                Mail::to($mails)
                    ->send(new \App\Mail\CustomMail('Сохранен новый заказ', 'externalshop::.mails.new-order', [
                        'order' => $order,
                    ]));
            }
        }
    }
}
