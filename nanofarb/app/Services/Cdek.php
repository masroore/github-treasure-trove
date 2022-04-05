<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 08.03.19
 * Time: 12:33.
 */

namespace App\Services;

use Cache;
use CdekSDK\Requests\CalculationRequest;
use CdekSDK\Requests\PvzListRequest;
use Log;

class Cdek
{
    protected $client;

    /**
     * Cdek constructor.
     *
     * @param $client
     */
    public function __construct()
    {
        //$this->client = new \CdekSDK\CdekClient();
        $this->client = app(\CdekSDK\CdekClient::class);
    }

    /**
     * Почтовые отделения для города.
     *
     * @return array
     */
    public function getPwz(int $cityId, string $pwzCode = '')
    {
        $request = new PvzListRequest();
        $request->setCityId($cityId);
        $request->setType(PvzListRequest::TYPE_ALL);
        $request->setCashless(true);
        $request->setCodAllowed(true);
        $request->setDressingRoom(true);

        $response = $this->client->sendPvzListRequest($request);
        if ($response->hasErrors()) {
            Log::error(__METHOD__ . ' Error CDEK response');
            // обработка ошибок
        }

        if ($pwzCode) {
            foreach ($response as $item) {
                if ($item->Code == $pwzCode) {
                    return $item;
                }
            }

            return null;
        }

        return $response;
    }

    public function getPwzFromCache(int $cityId, string $pwzCode = '')
    {
        $response = Cache::remember(md5(serialize([$cityId, $pwzCode])), 5, function () use ($cityId, $pwzCode) {
            return $this->getPwz($cityId, $pwzCode);
        });

        return $response;
    }

    /**
     * Калькулятор стоимости доставки.
     *
     * @return null|float
     */
    public function getCalculationDeliveryPrice(array $params)
    {
        [$senderCityId, $receiverCityId, $tariffId, $productsParams] = $params;

        //$request = new CalculationRequest();
        $request = CalculationRequest::withAuthorization();
        $request
            ->setSenderCityId($senderCityId)
            ->setReceiverCityId($receiverCityId)
            ->setTariffId($tariffId);

        foreach ($productsParams as $product) {
            $request->addPackage($product);
        }

        $response = $this->client->sendCalculationRequest($request);

        if ($response->hasErrors()) {
            // обработка ошибок
            Log::error(__METHOD__ . ' Error CDEK response');

            return 0;
        }

        /** @var \CdekSDK\Responses\CalculationResponse $response */
        return $response;
    }

    public function getCalculationDeliveryPriceFromCache(array $params)
    {
        $response = Cache::remember(md5(serialize($params)), 5, function () use ($params) {
            return $this->getCalculationDeliveryPrice($params);
        });

        return $response ?: $this->getCalculationDeliveryPrice($params);
    }
}
