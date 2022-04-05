<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/15
 * Time: 9:10.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipEquipmentSubKind extends Model
{
    use SoftDeletes;

    protected $table = 'tb_equ_sub_kind';

    protected $date = ['deleted_at'];

    public function mainKind()
    {
        return $this->belongsTo('App\Models\ShipManage\ShipEquipmentMainKind', 'Kind');
    }

    public static function subKindByShip($shipName, $mainKind)
    {
        $result = static::query()
            ->select('tb_ship_equip_kind.id', 'tb_equ_sub_kind.GroupOfEuipment_Cn')
            ->join('tb_ship_equip_kind', 'tb_ship_equip_kind.KindofEuipmentId', '=', 'tb_equ_sub_kind.id')
            ->where('tb_ship_equip_kind.ShipId', $shipName)
            ->where('tb_ship_equip_kind.KindId', $mainKind)
            ->orderBy('tb_ship_equip_kind.KindId')
            ->get();

        return $result;
    }
}
