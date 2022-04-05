<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/14
 * Time: 7:41.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    protected $table = 'tb_fuel_analyze';

    public function getFuelForEval($shipId, $voyId)
    {
        $is_exist = self::where('shipId', $shipId)->where('voy_no', $voyId)->first();

        if ($is_exist == null) {
            return [];
        }

        return [
            'rob_fo' => $is_exist->rob_fo,
            'rob_do' => $is_exist->rob_do,

            'rob_fo_price' => $is_exist->oil_price_fo,
            'rob_do_price' => $is_exist->oil_price_do,
        ];
    }
}
