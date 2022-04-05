<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function items()
    {
        return $this->hasMany(packageItem::class, 'packageId');
    }
}
