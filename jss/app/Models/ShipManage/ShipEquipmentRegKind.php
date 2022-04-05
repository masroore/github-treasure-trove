<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/15
 * Time: 22:35.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipEquipmentRegKind extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ship_equip_kind';

    protected $date = ['deleted_at'];

    public static function mainKindByShip($shipName)
    {
        $result = static::query()
            ->select('tb_equ_main_kind.Kind_Cn', 'tb_equ_main_kind.id')
            ->join('tb_equ_main_kind', 'tb_ship_equip_kind.KindId', '=', 'tb_equ_main_kind.id')
            ->where('tb_ship_equip_kind.ShipId', '=', $shipName)
            ->groupBy('tb_ship_equip_kind.KindId')
            ->get();

        return $result;
    }
}
