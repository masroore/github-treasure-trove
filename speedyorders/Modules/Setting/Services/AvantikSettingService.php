<?php

namespace Modules\Setting\Services;

use App\Utils\Option;
use Exception;

class AvantikSettingService
{
    public function handle(array $data)
    {
        try {
            Option::set('avantik_api_status', $data['avantik_api_status']);
            Option::set('avantik_api_url', $data['avantik_api_url']);
            Option::set('avantik_username', $data['avantik_username']);
            Option::set('avantik_password', $data['avantik_password']);
            Option::set('avantik_agent_code', $data['avantik_agent_code']);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
