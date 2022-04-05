<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allow extends Model
{
    public function managers()
    {
        return $this->belongsToMany(Manager::class, 'allow_manager', 'allow_id', 'manager_id');
    }
}
