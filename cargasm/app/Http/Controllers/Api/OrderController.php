<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @api {post} /order/status 1. Статус заказа
     * @apiVersion 1.0.0
     * @apiName ComplaintCar
     * @apiGroup 1.Статус заказа
     *
     * @apiParam {String} [id] Номер заказа
     * @apiParam {String} [region] Номер региона
     * @apiParam {String} [lang] Язык - ru,ua,kg
     */
    public function status(Request $request)
    {
        $id = $request->id;
        $region = $request->region;
        $lang = $request->lang;
        $result = config('services.orderStatusUrl');
        $result = $result . $id . '/' . $region . '/' . $lang;

        $arrContextOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];

        $resultResp = file_get_contents($result, false, stream_context_create($arrContextOptions));

        $resultResp = json_decode($resultResp, true);
        if (empty($resultResp)) {
            return response()
                ->json([
                    'message' => trans('system.order.error'),
                    'error' => [
                        'value' => trans('system.order.error'),
                    ],
                ]);
        }

        return $resultResp;
    }
}
