<?php

namespace Modules\ExternalShop\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Modules\ExternalShop\Entities\Order;
use Modules\ExternalShop\Events\OrderCreated;
use Modules\ExternalShop\Import\Shop;

class GetOrders implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $source;

    protected $force;

    protected $last;

    protected $event;

    protected $shop;

    /**
     * GetOrders constructor.
     */
    public function __construct(
        string $source,
        bool $force = false,
        bool $last = false,
        bool $event = false
    ) {
        $this->source = $source;
        $this->force = $force;
        $this->last = $last;
        $this->event = $event;
        $this->shop = new Shop();
    }

    public function handle(): void
    {
        if ($this->stopJob()) {
            return;
        }

        Log::info('Start job [ExternalShopGetLastOrders]: ' . $this->source);

        $apiShop = $this->shop->init($this->source);

        if ($this->last) {
            $externalOrders = $apiShop->getLastOrders();
        } else {
            $externalOrders = $apiShop->getOrders();
        }

        foreach ($externalOrders as $externalOrder) {
            $this->saveOrder($externalOrder, $this->source, $this->force);
        }
    }

    public function stopJob()
    {
        if ($this->source === Shop::TYPE_ROZETKA) {
            if (empty(variable('externalshop_rozetka_username')) || empty(variable('externalshop_rozetka_password'))) {
                Log::warning("Api arguments for external driver [$this->source] not set.");

                return true;
            }
        }

        if ($this->source === Shop::TYPE_PROM) {
            if (empty(variable('externalshop_prom_token'))) {
                Log::warning("Api arguments for external driver [$this->source] not set.");

                return true;
            }
        }

        return false;
    }

    /**
     * @param $order
     * @param $source
     *
     * @return bool
     */
    public function saveOrder($order, $source, bool $force = false)
    {
        if ($force) {
            $order = Order::withTrashed()->updateOrCreate([
                'source' => $source,
                'external_id' => $order->id,
            ], $this->shop->makeOrderData($order, $source));
        } elseif (!Order::withTrashed()->where('external_id', $order->id)->where('source', $source)->first()) {
            $order = Order::create($this->shop->makeOrderData($order, $source));
            if ($this->event) {
                event(new OrderCreated($order));
            }

            return $order;
        }

        return false;
    }
}
