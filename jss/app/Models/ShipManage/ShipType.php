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

class ShipType extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ship_type';

    protected $date = ['deleted_at'];
}
