<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Exception;
use Illuminate\Support\Facades\DB;

class GeneralSettingService
{
    public function handle(array $data)
    {
        try {
            DB::beginTransaction();

            Option::set('company_name', $data['company_name']);
            Option::set('company_address', $data['company_address']);
            Option::set('company_email', $data['company_email']);
            Option::set('company_phone', $data['company_phone']);

            if (isset($data['site_logo']) && !empty($data['site_logo'])) {
                $image = $data['site_logo'];
                $imageName =
                    uniqid() .
                    time() .
                    '.' .
                    $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data['site_logo'] = $imageName;

                Option::set('site_logo', $data['site_logo']);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
