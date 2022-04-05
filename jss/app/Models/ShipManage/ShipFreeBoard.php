<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 4/6/2017
 * Time: 6:13 PM.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipFreeBoard extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ship_freeboard';

    protected $date = ['deleted_at'];
}
