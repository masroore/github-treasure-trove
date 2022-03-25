<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industries extends Model
{
    use HasFactory;

    // get industry types
    public function types()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function slug()
    {
        return $this->morphOne('App\Models\Slug', 'slugeable');
    }
}
