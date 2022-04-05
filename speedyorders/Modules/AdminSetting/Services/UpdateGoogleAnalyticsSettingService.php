<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateGoogleAnalyticsSettingService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            Option::set('google_analytics_url', $validatedData['google_analytics_url']);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
