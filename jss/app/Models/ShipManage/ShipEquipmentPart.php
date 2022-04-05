<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/29
 * Time: 23:08.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;

class ShipEquipmentPart extends Model
{
    protected $table = 'tb_equipment_parts';

    public $timestamps = false;

    public static function loadEquipmentParts($equipId)
    {
        $list = static::query()
            ->select('tb_equipment_parts.*', 'tb_count_unit.Unit_En')
            ->leftJoin('tb_count_unit', 'tb_equipment_parts.Unit', '=', 'tb_count_unit.id')
            ->where('tb_equipment_parts.EuipmentID', $equipId)
            ->paginate(100);

        return $list;
    }

    public static function loadShipEquipmentParts($equipId = null)
    {
        $query = static::query()
            ->select('tb_equipment_parts.*', 'tb_ship_equipment.Euipment_Cn', 'tb_count_unit.Unit_En')
            ->leftJoin('tb_ship_equipment', 'tb_equipment_parts.EuipmentID', '=', 'tb_ship_equipment.id')
            ->leftJoin('tb_count_unit', 'tb_equipment_parts.Unit', '=', 'tb_count_unit.id');
        if (!empty($equipId)) {
            $query->where('tb_equipment_parts.EuipmentID', $equipId);
        }

        $list = $query->paginate(15);

        return $list;
    }
}
