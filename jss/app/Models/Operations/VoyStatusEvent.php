<?php
/**
 * Created by PhpStorm.
 * User: Hongstar
 * Date: 2017-07-06
 * Time: 오후 4:51.
 */

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VoyStatusEvent extends Model
{
    protected $table = 'tbl_voy_status_event';

    public $timestamps = false;

    public function typeName()
    {
        return $this->hasOne('App\Models\Operations\VoyStatusType', 'id', 'TypeId');
    }

    public static function getVoyEventList($status)
    {
        $list = static::query()
            ->select('tbl_voy_status_event.id', 'tbl_voy_status_event.Event')
            ->join('tbl_voy_status_type', 'tbl_voy_status_event.TypeId', '=', 'tbl_voy_status_type.id')
            ->where('tbl_voy_status_type.type', $status)
            ->orderBy('tbl_voy_status_event.id')
            ->get();

        return $list;
    }

    public static function getVoyTypeEventList()
    {
        $list = static::query()
            ->select('tbl_voy_status_event.Event', 'tbl_voy_status_type.ItemName', 'tbl_voy_status_type.Type')
            ->join('tbl_voy_status_type', 'tbl_voy_status_event.TypeId', '=', 'tbl_voy_status_type.id')
            ->where('tbl_voy_status_event.event', 'like', '%Stop%')
            ->orderBy('tbl_voy_status_type.id')
            ->get();

        return $list;
    }
}
