<?php

namespace App\Traits;

use App\Models\Log;
use Auth;

trait LogTrait
{
    /**
     * Save a log on database or server exception, to track the error we save the user id.
     *
     * @var LogModel
     */
    public function saveLog($exMessage, $exCode, $exType)
    {
        $log = Log::create([
            'uuid' => uniqid(),
            'user_id' => !Auth::guest() ? Auth::user()->id : null,
            'code' => $exCode,
            'description' => $exMessage,
            'type' => $exType,
        ]);

        return $log;
    }
}
