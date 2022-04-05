<?php

/**
 * Created by PhpStorm.
 * User: Master
 * Date: 4/6/2017
 * Time: 6:13 PM.
 */

namespace App\Models\Member;

use DB;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'tb_unit';

    public $timestamps = false;

    public function units()
    {
        return $this->orderBy('orderkey')->get();
    }

    public function users()
    {
        return $this->hasOne('App\Models\UserInfo', 'unit')->get();
    }

    public static function getUnitName($unitId)
    {
        return static::find($unitId)->title;
    }

    public static function unitList()
    {
        $query = 'SELECT tb_unit.*, countChild  FROM tb_unit
                  LEFT JOIN (SELECT parentId, COUNT(*) AS countChild FROM tb_unit GROUP BY parentId) AS count_table ON tb_unit.id = count_table.parentId
                  ORDER BY orderkey';
        $result = DB::select($query);

        return $result;
    }

    public static function unitFullNameList()
    {
        $result = static::query()->orderBy('orderkey')->get();

        foreach ($result as $unit) {
            $unitTitle = '';
            if ($unit['parentId'] != 0) {
                $parent = static::query()->find($unit['parentId']);
                $topParent = static::query()->find($parent['parentId']);
                if (isset($topParent)) {
                    $unitTitle = $topParent['title'] . '/' . $parent['title'];
                } else {
                    $unitTitle = $parent['title'];
                }
            }

            $unit['title'] = empty($unitTitle) ? $unit['title'] : $unitTitle . '/' . $unit['title'];
        }

        return $result;
    }
}
