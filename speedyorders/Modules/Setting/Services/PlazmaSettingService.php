<?php

namespace Modules\Setting\Services;

use App\Utils\Option;

class PlazmaSettingService
{
    public function handle($data)
    {
        try {
            Option::update('plazma_api_status', $data['plazma_api_status']);
            Option::update('plazma_api_url', $data['plazma_api_url']);
            Option::update('plazma_user_id', $data['plazma_user_id']);
            Option::update('plazma_password', $data['plazma_password']);
            Option::update('plazma_agent_id', $data['plazma_agent_id']);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
