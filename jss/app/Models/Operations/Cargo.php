<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'tbl_cargo';

    public $timestamps = false;

    /*
    * params: 23,24,34
    * return 'CargoName1, CargoName2'
    */
    public function getCargoNames($ids = '')
    {
        $retVal = '';
        $ids = explode(',', $ids);
        foreach ($ids as $key => $id) {
            $info = self::where('id', $id)->first();
            if ($info != null) {
                $retVal .= $info->name . ', ';
            }
        }

        return strlen($retVal) == 0 ? '' : substr($retVal, 0, strlen($retVal) - 2);
    }
}
