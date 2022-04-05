<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class VoyStatus extends Model
{
    protected $table = 'tbl_voy_status';

    public $timestamps = false;

    public function economyEvent()
    {
        return $this->hasOne('App\Models\Operations\VoyStatusEvent', 'id', 'Related_Economy');
    }

    public function uneconomyEvent()
    {
        return $this->hasOne('App\Models\Operations\VoyStatusEvent', 'id', 'Related_UnEconomy');
    }

    public function otherEvent()
    {
        return $this->hasOne('App\Models\Operations\VoyStatusEvent', 'id', 'Related_Other');
    }

    public static function getStatusList($status = null)
    {
        $query = static::query();
        if (isset($status)) {
            $query->where('Voy_Status', 'like', $status . '%');
        }

        $result = $query->paginate();

        return $result;
    }
}
