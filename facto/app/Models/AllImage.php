<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllImage extends Model
{
    public function all_imagable()
    {
        return $this->morphTo();
    }
}
