<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    protected $table = 'permissions';

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }
}
