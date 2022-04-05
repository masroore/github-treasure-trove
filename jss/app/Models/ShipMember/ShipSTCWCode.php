<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/12
 * Time: 21:17.
 */

namespace App\Models\ShipMember;

use Illuminate\Database\Eloquent\Model;

class ShipSTCWCode extends Model
{
    protected $table = 'tb_ship_stcw_reg';

    public static function getCodeList()
    {
        $result = static::query()
            ->select('tb_ship_stcw_reg.*', 'tb_ship_training_course.Course')
            ->join('tb_ship_training_course', 'tb_ship_stcw_reg.TrainingCourseID', '=', 'tb_ship_training_course.id')
            ->orderBy('STCWRegCode')
            ->get();

        return $result;
    }
}
