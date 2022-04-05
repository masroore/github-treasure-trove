<?php

namespace Modules\AdminSetting\Services;

use App\Utils\Option;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateSocialMediaSettingService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            Option::set('facebook_url', $validatedData['facebook_url']);
            Option::set('instagram_url', $validatedData['instagram_url']);
            Option::set('pinterest_url', $validatedData['pinterest_url']);
            Option::set('youtube_url', $validatedData['youtube_url']);
            Option::set('twitter_url', $validatedData['twitter_url']);
            Option::set('linkedin_url', $validatedData['linkedin_url']);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
