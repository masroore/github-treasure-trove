<?php
/**
 * Created by PhpStorm.
 * User: Hongstar
 * Date: 2017-07-06
 * Time: 오후 4:51.
 */

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VoyStatusType extends Model
{
    protected $table = 'tbl_voy_status_type';

    public $timestamps = false;

    public static function countEventType()
    {
        $list = static::query()
            ->select(DB::raw('count(*) as typeCount, Type'))
            ->groupBy('Type')
            ->get();

        return $list;
    }
}
