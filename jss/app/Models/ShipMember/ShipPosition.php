<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/12
 * Time: 21:16.
 */

namespace App\Models\ShipMember;

use Illuminate\Database\Eloquent\Model;

class ShipPosition extends Model
{
    protected $table = 'tb_ship_duty';

    public static function getShipPositionList($keyword)
    {
        $query = static::query();
        if (isset($keyword)) {
            $query->where('Duty', 'like', '%' . $keyword . '%')
                ->orWhere('Duty_En', 'like', '%' . $keyword . '%');
        }
        $result = $query->get();

        return $result;
    }
}
