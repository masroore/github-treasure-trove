<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class SailDistance extends Model
{
    protected $table = 'tbl_d_a_saildistance';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    public function LPortName()
    {
        return $this->hasOne('App\Models\ShipTechnique\ShipPort', 'id', 'LPortID');
    }

    public function DPortName()
    {
        return $this->hasOne('App\Models\ShipTechnique\ShipPort', 'id', 'DPortID');
    }

    public static function getDistanceList($lport = null, $dport = null)
    {
        $query = static::query();
        if (!empty($lport)) {
            $query->where('LPortID', $lport);
        }
        if (!empty($dport)) {
            $query->where('DPortID', $dport);
        }

        return $query->paginate(20);
    }
}
