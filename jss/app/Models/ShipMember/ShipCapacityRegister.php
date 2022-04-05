<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/5/24
 * Time: 16:36.
 */

namespace App\Models\ShipMember;

use Illuminate\Database\Eloquent\Model;

class ShipCapacityRegister extends Model
{
    protected $table = 'tb_capacity_registry';

    public function mainCapacity()
    {
        return $this->hasOne('App\Models\ShipMember\ShipMemberCapacity', 'id', 'CapacityID');
    }

    public function subCapacity()
    {
        return $this->hasOne('App\Models\ShipMember\ShipMemberCapacity', 'id', 'GMDSSID');
    }
}
