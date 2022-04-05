<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VoyProRandom extends Model
{
    protected $table = 'tbl_voypro_random';

    public $timestamps = false;

    public function shipName()
    {
        return $this->hasOne('App\Models\ShipManage\ShipRegister', 'RegNo', 'shipid');
    }

    public function sewage()
    {
        return $this->hasOne('App\Models\Operations\Sewage', 'RegNo', 'shipid');
    }

    public function lPortName()
    {
        return $this->hasOne('App\Models\ShipTechnique\ShipPort', 'id', 'lport');
    }

    public function dPortName()
    {
        return $this->hasOne('App\Models\ShipTechnique\ShipPort', 'id', 'dport');
    }

    public function shipReg()
    {
        return $this->hasOne('App\Models\ShipManage\ShipRegister', 'RegNo', 'shipid');
    }

    public static function getCalcVoyData($shipId)
    {
        $query = static::query();
        if (null !== $shipId) {
            $query->where('shipid', $shipId);
        }

        $result = $query->orderBy('caldate', 'desc')->paginate(10)->setPath('');
        if (null !== $shipId) {
            $result->appends(['shipId' => $shipId]);
        }

        return $result;
    }
}
