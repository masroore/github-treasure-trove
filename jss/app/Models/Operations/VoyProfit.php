<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-16
 * Time: 오후 7:57.
 */

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VoyProfit extends Model
{
    protected $table = 'tbl_voy_profit';

    public $timestamps = false;

    public static function makeVoyId(): void
    {
        $list = self::all();
        foreach ($list as $profit) {
            $cp = CP::where('CP_No', $profit['VOY'])->first();

            $profit['VoyId'] = $cp['id'];
            $profit->save();
        }
    }
}
