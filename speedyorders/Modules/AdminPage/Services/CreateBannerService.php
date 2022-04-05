<?php

namespace Modules\AdminPage\Services;

use App\Models\Banner;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateBannerService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();

            if (isset($validatedData['f_image'])) {
                $image = $validatedData['f_image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $image_name);
                $validatedData['f_image'] = $image_name;
            }
            if (isset($validatedData['s_image'])) {
                $image = $validatedData['s_image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $image_name);
                $validatedData['s_image'] = $image_name;
            }
            if (isset($validatedData['t_image'])) {
                $image = $validatedData['t_image'];
                $image_name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $image_name);
                $validatedData['t_image'] = $image_name;
            }
            Banner::create($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            dd($e);

            return false;
        }
    }
}
