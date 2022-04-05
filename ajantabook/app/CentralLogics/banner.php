<?php

namespace App\CentralLogics;

use App\Model\Banner;

class banner
{
    public static function get_banners()
    {
        return self::latest()->get();
    }
}
