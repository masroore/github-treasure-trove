<?php

namespace Modules\Setting\Services;

use App\Utils\Option;
use Exception;

class GeneralSettingService
{
    public function handle(array $data)
    {
        try {
            Option::set('company_name', $data['company_name']);
            Option::set('company_address', $data['company_address']);
            Option::set('company_email', $data['company_email']);
            Option::set('company_phone', $data['company_phone']);
            Option::set('company_city', $data['company_city']);
            Option::set('company_country', $data['company_country']);
            Option::set('company_postal', $data['company_postal']);

            if (isset($data['company_state'])) {
                Option::set('company_state', $data['company_state']);
            }

            if (isset($data['company_state'])) {
                Option::set('company_street', $data['company_street']);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
