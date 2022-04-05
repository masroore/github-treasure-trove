<?php
/**
 * Created by PhpStorm.
 * User: ChoeMunBong
 * Date: 2017/4/16
 * Time: 13:09.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ship extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ship';

    protected $date = ['deleted_at'];

    public static function getShipName($shipId)
    {
        return static::find($shipId)->name;
    }

    public static function getShipGeneralInfos()
    {
        $infoList = static::query()
            ->select(
                'tb_ship_register.id',
                'tb_ship.name',
                'tb_ship_type.ShipType_Cn',
                'tb_ship_register.shipName_Cn',
                'tb_ship_register.shipName_En',
                'tb_ship_register.Class',
                'tb_ship_register.IMO_No',
                'tb_ship_register.Flag_Cn',
                'tb_ship_register.Displacement'
            )
            ->join('tb_ship_register', 'tb_ship_register.Shipid', '=', 'tb_ship.id')
            ->join('tb_ship_type', 'tb_ship_register.ShipType', '=', 'tb_ship_type.id')
            ->orderby('tb_ship.id')
            ->get();

        return $infoList;
    }

    public static function getAllItem()
    {
        $list = static::query()
            ->paginate(10);

        return $list;
    }
}
