<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/16
 * Time: 5:21.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ShipEquipment extends Model
{
//    use SoftDeletes;
    protected $table = 'tb_ship_equipment';

    protected $table_register = 'tb_ship_register';

    public function getYearList($shipId)
    {
        $yearList = [];
        $info = DB::table($this->table_register)->where('IMO_No', $shipId)->first();
        if ($info == null) {
            $baseYear = date('Y');
        } else {
            $baseYear = substr($info->RegDate, 0, 4);
        }

        for ($year = date('Y'); $year >= $baseYear; --$year ) {
            $yearList[] = $year;
        }

        return $yearList;
    }

    public function getEquipmentList($params)
    {
        $selector = self::whereRaw(1);

        if (isset($params['shipId']) && $params['shipId'] != 0) {
            $selector->where('shipId', $params['shipId']);
        }

        if (isset($params['year']) && $params['year'] != 0) {
            $selector->whereRaw(DB::raw('mid(request_date, 1, 4) like ' . $params['year']));
        }

        if (isset($params['placeType']) && $params['placeType'] != 0) {
            $selector->where('place', $params['placeType']);
        }

        if (isset($params['activeType']) && $params['activeType'] != 0) {
            $selector->where('type', $params['activeType']);
        }

        if (isset($params['activeStatus']) && $params['activeStatus'] != 0) {
            if ($params['activeStatus'] == 1) {
                $selector->where('supply_date', 'like', '0000-00-00')->orWhereNull('supply_date');
            } else {
                $selector->whereNotNull('supply_date');
            }
        }

        $records = $selector->get();

        return $records;
    }
}
