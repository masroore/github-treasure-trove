<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/16
 * Time: 10:15.
 */

namespace App\Models\ShipMember;

use Illuminate\Database\Eloquent\Model;

class ShipMemberCapacity extends Model
{
    protected $table = 'tb_member_capacity';

    public $timestamps = false;

    public static function getData()
    {
        $result = static::query()
            ->select('tb_member_capacity.*', 'tb_ship_stcw_reg.STCWRegCode')
            ->join('tb_ship_stcw_reg', 'tb_ship_stcw_reg.id', '=', 'tb_member_capacity.STCWRegID')
            ->paginate();

        return $result;
    }

    public static function totalData()
    {
        $result = static::query()
            ->select('tb_member_capacity.*', 'tb_ship_stcw_reg.STCWRegCode')
            ->join('tb_ship_stcw_reg', 'tb_ship_stcw_reg.id', '=', 'tb_member_capacity.STCWRegID')
            ->orderBy('tb_member_capacity.orderNum')
            ->get();

        return $result;
    }
}
