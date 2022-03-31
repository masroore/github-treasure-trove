<?php

namespace Modules\AdminApi\Http\Controllers\v1;

use App\Utils\Option;
use Modules\AdminApi\Http\Controllers\BaseController;

class ChatController extends BaseController
{
    public function chatScript()
    {
        $chatScript = Option::get('chat_script');

        return $this->success($chatScript);
    }
}
