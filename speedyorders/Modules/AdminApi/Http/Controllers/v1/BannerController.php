<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Models\Banner;
use Modules\AdminApi\Http\Controllers\BaseController;

class BannerController extends BaseController
{
    public function index()
    {
        $banners = Banner::query();
        $banners->where('status', 1);
        $banners = $banners->select(
            'id',
            'f_image',
            'f_title',
            'f_description',
            'f_button_text',
            'f_link',
            's_image',
            's_title',
            's_description',
            's_button_text',
            's_link',
            't_image',
            't_title',
            't_description',
            't_button_text',
            't_link',
            'sort_order',
            'status'
        )
            ->get();
        foreach ($banners as $banner) {
            $banner->status = 'Active';
        }

        return $this->success($banners);
    }
}
