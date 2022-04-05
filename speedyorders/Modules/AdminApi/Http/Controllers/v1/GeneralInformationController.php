<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Models\AdminOption;
use Illuminate\Http\Request;
use Modules\AdminApi\Http\Controllers\BaseController;

class GeneralInformationController extends BaseController
{
    public function generalInformation(Request $request)
    {
        $keyArray = ['company_name', 'company_address', 'company_email', 'company_phone', 'google_analytics_url',
            'facebook_url', 'instagram_url', 'pinterest_url', 'youtube_url', 'twitter_url', 'linkedin_url', ];

        if ($request->uuid) {
            $generalInfo = AdminOption::where('uuid', $request->uuid)->whereIn('name', $keyArray)->select('name', 'value')->first();
            if ($generalInfo) {
                return $this->success($generalInfo);
            }

            return $this->failure(['Requested general information not found.']);
        }

        $generalInfo = AdminOption::select('name', 'value')->whereIn('name', $keyArray)->get();

        return $this->success($generalInfo);
    }
}
