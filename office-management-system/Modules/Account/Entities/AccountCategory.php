<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    protected $guarded = [];

    public function chart_accounts()
    {
        return $this->hasMany(ChartAccount::class, 'configuration_group_id');
    }
}
