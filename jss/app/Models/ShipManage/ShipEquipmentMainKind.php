<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/15
 * Time: 9:10.
 */

namespace App\Models\ShipManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipEquipmentMainKind extends Model
{
    use SoftDeletes;

    protected $table = 'tb_equ_main_kind';

    protected $date = ['deleted_at'];

    public function subKinds()
    {
        return $this->hasOne('App\Models\ShipManage\ShipEquipmentSubKind', 'Kind', 'id');
    }
}
