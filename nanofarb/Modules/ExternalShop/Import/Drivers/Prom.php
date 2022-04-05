<?php

namespace Modules\ExternalShop\Import\Drivers;

use DateTime;
use Exception;
use Modules\ExternalShop\Import\Models\Client;
use Modules\ExternalShop\Import\Models\Order;
use Modules\ExternalShop\Import\Models\Purchase;

/**
 * Class Prom.
 */
class Prom extends ShopDriver
{
    const HOST = 'https://my.prom.ua';

    protected $token;

    /**
     * Prom constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getOrders(array $params = [])
    {
        $url = '/api/v1/orders/list';

//        if ($status) {
//            $url .= '?'.http_build_query(array('status' => $status));
//        }

        $params['limit'] = 500;
        if (count($params)) {
            $url .= '?' . http_build_query($params); //last_id
        }

        $response = $this->doRequest($url);

        if (!isset($response['orders'])) {
            throw new Exception(__METHOD__ . ' | Bad response');
        }

        return array_map(function ($item) {
            return new \Modules\ExternalShop\Import\Models\Order($this->mapOrder($item));
        }, $response['orders']);
    }

    public function getLastOrders($lastParam = null, array $params = [])
    {
        $lastParam = $lastParam ?: now()
            ->startOfDay()->format('Y-m-d\TH:i:s'); //2020-01-28T12:50:34
        $params = array_merge(['date_from' => $lastParam], $params);

        return $this->getOrders($params);
    }

    /**
     * @param $id
     */
    public function getOrder($id): Order
    {
        $response = $this->doRequest('/api/v1/orders/' . $id);

        return new \Modules\ExternalShop\Import\Models\Order($this->mapOrder($response['order']));
    }

    /**
     * @param $id
     * @param $status
     *
     * @return mixed
     */
    public function setOrderStatus($id, $status)
    {
        $status = $this->localOrderStatusToExternalOrderStatus($status);

        $body = [
            'status' => $status,
            'ids' => is_array($id) ? $id : [$id],
        ];

        $response = $this->doRequest('/api/v1/orders/set_status', 'POST', $body);

        return $response;
    }

    /**
     * @param $method
     * @param $url
     * @param $body
     *
     * @return mixed
     */
    protected function doRequest($url, $method = 'GET', $body = null, bool $assoc = true)
    {
        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::HOST . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        }

        if (!empty($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, $assoc);
    }

    /**
     * @return array
     */
    protected function mapOrder(array $raw)
    {
        return [
            'id' => (int) ($raw['id']),
            'number' => $raw['id'],
            'confirmed_at' => new DateTime($raw['date_created']),
            'delivery_address' => $raw['delivery_address'] ?? '',
            'delivery_service' => $raw['delivery_option']['name'] ?? '',
            'payment_info' => $raw['payment_option']['name'] ?? '',
            'total_sum' => $this->preparePrice($raw['price']),
            'client_comment' => $raw['client_notes'] ?? '',
            'seller_comment' => $raw['seller_comment'] ?? '',
            'status' => $this->externalOrderStatusToLocalOrderStatus($raw['status']),
            'client' => new Client($this->mapClient($raw)),
            'purchases' => array_map(function ($item) {
                return new Purchase($this->mapPurchase($item));
            }, $raw['products']),
            'raw' => $raw,
        ];
    }

    public function preparePrice($rawPrice)
    {
        $rawPrice = preg_replace('/[^0-9,.]/', '', $rawPrice);
        $rewPrice = (int) ((float) (preg_replace('/^(\d+),(\d+).*$/', '$1.$2', $rawPrice)) * 100);

        return $rewPrice;
    }

    /**
     * @param $status
     *
     * @return mixed
     */
    protected function externalOrderStatusToLocalOrderStatus($status)
    {
        $statuses = [
            'pending' => self::ORDER_STATUS_NEW_PENDING,
            'received' => self::ORDER_STATUS_STILL_PROCESSED,
            //'' => self::ORDER_STATUS_STILL_DELIVERED,
            'delivered' => self::ORDER_STATUS_DELIVERED,
            'paid' => self::ORDER_STATUS_COMPLETED,
            'canceled' => self::ORDER_STATUS_CANCELED,
            //'' => self::ORDER_STATUS_REJECTED,
            'draft' => self::ORDER_STATUS_DRAFT,
        ];

        switch ($status) {
            case 'pending':
                return self::ORDER_STATUS_NEW_PENDING;
            case 'received':
                return self::ORDER_STATUS_STILL_PROCESSED;
            case 'delivered':
                return self::ORDER_STATUS_DELIVERED;
            case 'paid':
                return self::ORDER_STATUS_COMPLETED;
            case 'canceled':
                return self::ORDER_STATUS_CANCELED;
            case 'draft':
                return self::ORDER_STATUS_DRAFT;
            default:
                return self::ORDER_STATUS_INDEFINED;
        }
    }

    protected function localOrderStatusToExternalOrderStatus($status)
    {
        $statuses = [
            self::ORDER_STATUS_NEW_PENDING => 'pending',
            self::ORDER_STATUS_STILL_PROCESSED => 'received',
            self::ORDER_STATUS_STILL_DELIVERED => 'received',
            self::ORDER_STATUS_DELIVERED => 'delivered',
            self::ORDER_STATUS_COMPLETED => 'paid',
            self::ORDER_STATUS_CANCELED => 'canceled',
            self::ORDER_STATUS_REJECTED => 'canceled',
            self::ORDER_STATUS_DRAFT => 'draft',
        ];

        if (isset($statuses[$status])) {
            return $statuses[$status];
        }

        throw new Exception("Order status [$status] is not defined");
    }

    protected function mapClient(array $raw)
    {
        return [
            'id' => $raw['client_id'],
            'fullname' => mb_convert_case(($raw['client_first_name'] ?? '')
                . ' ' . ($raw['client_second_name'] ?? '')
                . ' ' . ($raw['client_last_name'] ?? ''), MB_CASE_TITLE, 'UTF-8'),
            'phone' => preg_replace('/[^0-9]/', '', $raw['phone']),
            'email' => $raw['email'],
        ];
    }

    protected function mapPurchase(array $raw)
    {
        return [
            'id' => $raw['id'],
            'sku' => $raw['sku'],
            'name' => $raw['name'],
            'price' => $this->preparePrice($raw['price']),
            'quantity' => $raw['quantity'],
            'url' => $raw['url'],
            'img' => $raw['image'],
        ];
    }
}
