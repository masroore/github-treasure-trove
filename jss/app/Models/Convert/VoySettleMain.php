<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/10/19
 * Time: 10:16.
 */

namespace App\Models\Convert;

use Illuminate\Database\Eloquent\Model;

class VoySettleMain extends Model
{
    protected $table = 'tbl_voy_settle_main';

    protected $_DAY_UNIT = 1000 * 3600;
}
