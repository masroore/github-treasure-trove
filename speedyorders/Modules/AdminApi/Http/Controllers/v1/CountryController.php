<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Models\Country;
use Modules\AdminApi\Http\Controllers\BaseController;

class CountryController extends BaseController
{
    public function getAllCountry()
    {
        $countries = Country::all();

        return $this->success($countries);
    }
}
