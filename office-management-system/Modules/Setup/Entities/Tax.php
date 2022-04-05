<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\ChartAccount;

class Tax extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->morphOne(ChartAccount::class, 'contactable');
    }
}
