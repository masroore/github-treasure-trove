<?php

namespace Modules\AdminPage\Services;

use App\Models\Banner;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateBannerService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            $banner = Banner::find($validatedData['id']);
            if (isset($validatedData['f_image'])) {
                $image = $validatedData['f_image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $image_name);
                @unlink(public_path('images/banners/' . $banner->f_image));
                $validatedData['f_image'] = $image_name;
            }
            if (isset($validatedData['s_image'])) {
                $image = $validatedData['s_image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $image_name);
                @unlink(public_path('images/banners/' . $banner->s_image));
                $validatedData['s_image'] = $image_name;
            }
            if (isset($validatedData['t_image'])) {
                $image = $validatedData['t_image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $image_name);
                @unlink(public_path('images/banners/' . $banner->t_image));
                $validatedData['t_image'] = $image_name;
            }
            $banner->update($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
