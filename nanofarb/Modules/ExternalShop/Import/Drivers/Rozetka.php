<?php

namespace Modules\ExternalShop\Import\Drivers;

use DateTime;
use Exception;
use Modules\ExternalShop\Import\Models\Client;
use Modules\ExternalShop\Import\Models\Order;
use Modules\ExternalShop\Import\Models\Purchase;

/**
 * Class Rozetka.
 */
class Rozetka extends ShopDriver
{
    const HOST = 'https://api.seller.rozetka.com.ua';

    protected $token;

    protected $username;

    protected $password;

    /**
     * Rozetka constructor.
     */
    public function __construct(
        string $username,
        string $password,
        ?string $token = null
    ) {
        $this->token = $token;
        $this->username = $username;
        $this->password = $password;
    }

    public function getOrders(array $params = [])
    {
        $url1 = $url2 = $url3 = '/orders/search';

        // 1 - В обработке
        $params1 = array_merge([
            'expand' => 'purchases,user,delivery,payment_type',
            'type' => '1',
        ], $params);
        // 2 - Успешно завершенные
        $params2 = array_merge([
            'expand' => 'purchases,user,delivery,payment_type',
            'type' => '2',
        ], $params);
        // 3 - Неуспешно завершенные
        $params3 = array_merge([
            'expand' => 'purchases,user,delivery,payment_type',
            'type' => '3',
        ], $params);

        $url1 .= '?' . http_build_query($params1);
        $url2 .= '?' . http_build_query($params2);
        $url3 .= '?' . http_build_query($params3);

        $response1 = $this->doRequest($url1);
        $response2 = $this->doRequest($url2);
        $response3 = $this->doRequest($url3);

        $res = array_merge($response1['content']['orders'], $response2['content']['orders'], $response3['content']['orders']);

        return array_map(function ($item) {
            return new \Modules\ExternalShop\Import\Models\Order($this->mapOrder($item));
        }, $res);
    }

    public function getLastOrders($lastParam = null, array $params = [])
    {
        $lastParam = $lastParam ?: now()
            ->format('Y-m-d'); //2019-09-18
        $params = array_merge(['created_from' => $lastParam], $params);

        return $this->getOrders($params);
    }

    public function getOrder($id): Order
    {
        $params = ['expand' => 'purchases,user,delivery,payment_type'];
        $url = '/orders/' . $id . '?' . http_build_query($params);

        $response = $this->doRequest($url);

        if (isset($response['success']) && $response['success'] === true) {
            return new \Modules\ExternalShop\Import\Models\Order($this->mapOrder($response['content']));
        }

        throw new Exception('Error rozetka response');
    }

    public function setOrderStatus($id, $status)
    {
        $status = $this->localOrderStatusToExternalOrderStatus($status);

        $body = [
            'status' => $status,
            'seller_comment' => '$status',
        ];

        $response = $this->doRequest('/orders/' . $id, 'PUT', $body);

        return $response;
    }

    protected function mapOrder(array $raw)
    {
        return [
            'id' => (int) ($raw['id']),
            'number' => $raw['id'],
            'confirmed_at' => new DateTime($raw['created']),
            'delivery_address' => $this->getOrderDeliveryAddress($raw),
            'delivery_service' => $raw['delivery']['delivery_service_name'] . ', ' . $raw['delivery']['place_number'],
            'payment_info' => $raw['payment_type'],
            'total_sum' => $this->preparePrice($raw['cost_with_discount']),
            'seller_comment' => '',
            'client_comment' => $raw['comment'],
            'status' => $this->externalOrderStatusToLocalOrderStatus($raw['status']),
            'client' => new Client($this->mapClient($raw)),
            'purchases' => array_map(function ($item) {
                return new Purchase($this->mapPurchase($item));
            }, $raw['purchases']),
            'raw' => $raw,
        ];
    }

    protected function getOrderDeliveryAddress($raw)
    {
        $array = array_filter([
            $raw['delivery']['city']['title'] ?? null,
            $raw['delivery']['place_street'] ?? null,
            $raw['delivery']['place_number'] ?? null,
            $raw['delivery']['place_house'] ?? null,
            $raw['delivery']['place_flat'] ?? null,
            $raw['delivery']['recipient_title'] ?? null,
        ], function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });

        return implode(', ', $array);
    }

    protected function mapClient(array $raw)
    {
        return [
            'id' => $raw['user']['id'],
            'fullname' => mb_convert_case($raw['delivery']['recipient_title'] ?? $raw['user']['contact_fio'], MB_CASE_TITLE, 'UTF-8'),
            'phone' => preg_replace('/[^0-9]/', '', $raw['user_phone']),
            'email' => $raw['user']['email'],
        ];
    }

    protected function mapPurchase(array $raw)
    {
        return [
            'id' => $raw['id'],
            'sku' => $raw['item']['article'],
            'name' => $raw['item_name'],
            'price' => $this->preparePrice($raw['price_with_discount']),
            'quantity' => $raw['quantity'],
            'url' => $raw['item']['url'],
            'img' => $raw['item']['photo_preview'],
        ];
    }

    protected function preparePrice($rawPrice)
    {
        return (int) ($rawPrice * 100);
    }

    /**
     * https://api.seller.rozetka.com.ua/apidoc/#api-OrderStatuses-GetOrderStatuses.
     *
     * @param $status
     *
     * @return int|mixed
     */
    protected function externalOrderStatusToLocalOrderStatus($status)
    {
        switch ($status) {
            case 1:
                return self::ORDER_STATUS_NEW_PENDING;
            case 2:
            case 3:
            case 26:
                return self::ORDER_STATUS_STILL_PROCESSED;
            case 4:
                return self::ORDER_STATUS_STILL_DELIVERED;
            case 5:
                return self::ORDER_STATUS_DELIVERED;
            case 6:
                return self::ORDER_STATUS_COMPLETED;
            case 7:
                return self::ORDER_STATUS_NEW_PENDING;
            case 10:
                return self::ORDER_STATUS_CANCELED;
            case 11:
            case 12:
                return self::ORDER_STATUS_REJECTED;
            case 13:
                return self::ORDER_STATUS_CANCELED;
            default:
                return self::ORDER_STATUS_INDEFINED;
        }
    }

    protected function localOrderStatusToExternalOrderStatus($status)
    {
        $statuses = [
            self::ORDER_STATUS_NEW_PENDING => 1,
            self::ORDER_STATUS_STILL_PROCESSED => 2,
            self::ORDER_STATUS_STILL_DELIVERED => 4,
            self::ORDER_STATUS_DELIVERED => 5,
            self::ORDER_STATUS_COMPLETED => 6,
            self::ORDER_STATUS_CANCELED => 13,
            self::ORDER_STATUS_REJECTED => 12,
            self::ORDER_STATUS_DRAFT => 25,
        ];

        if (isset($statuses[$status])) {
            return $statuses[$status];
        }

        throw new Exception("Order status [$status] is not defined");
    }

    public function repairApiToken()
    {
        $this->token = '';

        $response = $this->doRequest('/sites', 'POST', [
            'username' => $this->username,
            'password' => base64_encode($this->password),
        ]);

        if (isset($response['success']) && $response['success'] === true && isset($response['content']['access_token'])) {
            $this->token = $response['content']['access_token'];

            return $response['content']['access_token'];
        }

        throw new Exception('Error getting/response Rozetka access token');
    }

    protected function doRequest($url, $method = 'GET', $body = null, bool $assoc = true)
    {
        $headers[] = 'Content-Type: application/json';

        if ($this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

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
}
