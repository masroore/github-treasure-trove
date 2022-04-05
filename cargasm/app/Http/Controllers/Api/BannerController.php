<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * @api {get} /api/v1/banners/list 01. Список банеров
     * @apiVersion 1.0.0
     * @apiName GetBanners
     * @apiGroup 19.Банеры
     */
    public function list()
    {
        $banners = Banner::byLang()->with('media')->where('is_active', true)->get();

        //return BannerResource::collection($banners);
        $res = [];
        foreach (Banner::regionList() as $region => $title) {
            $res[$region] = BannerResource::collection($banners->where('region', $region));
        }

        return response()->json([
            'data' => $res,
        ]);
    }
}
