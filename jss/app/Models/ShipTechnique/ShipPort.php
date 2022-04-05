<?php
/**
 * Created by PhpStorm.
 * User: SJG
 * Date: 2017.05.25
 * Time: AM 9:59.
 */

namespace App\Models\ShipTechnique;

use Illuminate\Database\Eloquent\Model;

class ShipPort extends Model
{
    protected $table = 'tbl_port';

    public $timestamps = false;

    public function getPortNames($ids, $bracket = true)
    {
        $retVal = '';
        $ids = explode(',', $ids);
        foreach ($ids as $key => $id) {
            $info = self::where('id', $id)->first();
            if ($info != null) {
                $retVal .= $info->Port_En . ($bracket ? '(' . $info->Port_Cn . ')' : '') . ', ';
            }
        }

        return strlen($retVal) == 0 ? '' : substr($retVal, 0, strlen($retVal) - 2);
    }

    public function getPortNameForVoy($ids)
    {
        $retVal = '';
        $ids = explode(',', $ids);
        foreach ($ids as $key => $id) {
            $info = self::where('id', $id)->first();
            if ($info != null) {
                $retVal .= $info->Port_En . '(' . $info->Port_Cn . ')' . ' / ';
            }
        }

        return strlen($retVal) == 0 ? '' : substr($retVal, 0, strlen($retVal) - 2);
    }
}
