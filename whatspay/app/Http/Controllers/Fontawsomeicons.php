<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Exception;
use Illuminate\Support\Facades\Cache;

class Fontawsomeicons extends BaseController
{
    public function icons()
    {
        try {

            //$icons = Cache::rememberForever('fontawsomeicons', function() {

            $icons = config('fontawsomeicons');
            sort($icons);
            $icons = array_unique($icons);
            //return $icons;
            //});
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($icons, 'Icons found.');
    }
}
