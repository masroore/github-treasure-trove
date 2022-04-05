<?php

namespace Modules\Setting\Services;

use App\Utils\Option;
use Exception;

class SabreSettingService
{
    public function handle(array $data)
    {
        try {
            Option::set('sabre_api_status', $data['sabre_api_status']);
            Option::set('sabre_url', $data['sabre_url']);
            Option::set('sabre_ipcc', $data['sabre_ipcc']);
            Option::set('sabre_id', $data['sabre_id']);
            Option::set('sabre_password', $data['sabre_password']);
            Option::set('sabre_printer_terminal', $data['sabre_printer_terminal']);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
