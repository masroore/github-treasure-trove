<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class AddOnService extends Model
{
    public function service()
    {
        return $this->belongsTo(Services::class, 'serviceId');
    }
}
