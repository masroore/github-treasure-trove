<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/14
 * Time: 7:41.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ShipCertList extends Model
{
    use SoftDeletes;

    protected $table = 'tb_ship_certlist';

    protected $date = ['deleted_at'];

    public static function availabelCertList($shipName)
    {
        $hasList = DB::table('tb_ship_certregistry')->select(DB::raw('GROUP_CONCAT(CertNo) as CertStr'))->where('ShipName', $shipName)->get();
        if (null === $hasList) {
            $list = static::query()->get();
        } else {
            $list = static::query()
                ->where('CertNo', 'not in', $hasList->CertStr)
                ->get();
        }

        return $list;
    }
}
