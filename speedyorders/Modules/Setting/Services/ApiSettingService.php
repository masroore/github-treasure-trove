<?php

namespace Modules\Setting\Services;

use App\Utils\Option;

class ApiSettingService
{
    public function handle(array $data)
    {
        try {
            Option::set('api_system_endpoint', $data['api_system_endpoint'] ?? null);
            Option::set('api_agent_email', $data['api_agent_email'] ?? null);
            Option::set('api_agent_password', $data['api_agent_password'] ?? null);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
