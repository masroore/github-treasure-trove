<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Exception;

class Places extends BaseController
{
    public function countries()
    {
        try {
            $countries = array_keys(config('places'));

            sort($countries);
            $countries = array_unique($countries);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($countries, 'Countries found.');
    }

    public function country($country)
    {
        try {
            $country = config('places')[strtoupper($country)]['cities'];

            // sort array
            sort($country);

            // select unique cities
            $country = array_unique($country);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($country, 'Citites found.');
    }
}
