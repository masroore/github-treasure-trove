<?php

namespace Modules\ExternalShop\Import;

use Exception;
use Illuminate\Support\Facades\Cache;
use Modules\ExternalShop\Import\Contracts\ShopDriverInterface;
use Modules\ExternalShop\Import\Drivers\Prom;
use Modules\ExternalShop\Import\Drivers\Rozetka;

class Shop
{
    const TYPE_ROZETKA = 'rozetka';
    const TYPE_PROM = 'prom';

    /**
     * @param int $type
     */
    public function init(string $type): ShopDriverInterface
    {
        switch ($type) {
            case self::TYPE_ROZETKA:
                $username = variable('externalshop_rozetka_username');
                $password = variable('externalshop_rozetka_password');
                $token = Cache::remember('EXTERNAL_ROZETKA_TOKEN', 1200, function () use ($username, $password) {
                    $res = new Rozetka($username, $password);

                    return $res->repairApiToken();
                });

                $res = new Rozetka($username, $password, $token);
//                $res = new Rozetka(env('EXTERNAL_ROZETKA_USERNAME'), env('EXTERNAL_ROZETKA_PASSWORD'), env('EXTERNAL_ROZETKA_TOKEN'));

                break;
            case self::TYPE_PROM:
                $token = variable('externalshop_prom_token');
                $res = new Prom($token);

                break;
            default:
                throw new Exception("Shop type [$type] is not defined.");
        }

        return $res;
    }

    /**
     * @param $order
     * @param $source
     *
     * @return array
     */
    public function makeOrderData($order, $source)
    {
        return [
            'source' => $source,
            'external_id' => $order->id,
            'number' => $order->number,
            'delivery_address' => $order->delivery_address,
            'delivery_service' => $order->delivery_service,
            'payment_info' => $order->payment_info,
            'total_sum' => $order->total_sum,
            'client_comment' => $order->client_comment,
            'seller_comment' => $order->seller_comment,
            'status' => $order->status,
            'confirmed_at' => $order->confirmed_at,
            'client' => $order->client->toArray(),
            'purchases' => $this->purchasesToArray($order->purchases),
            'raw' => $order->raw,
        ];
    }

    public function purchasesToArray($purchases)
    {
        $res = [];
        foreach ($purchases as $purchase) {
            $res[] = $purchase->toArray();
        }

        return $res;
    }
}
