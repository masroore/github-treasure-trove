<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    protected $table = 'premia';

    public function upso_type()
    {
        return $this->belongsTo(UpsoType::class);
    }

    public function upso()
    {
        return $this->belongsTo(Upso::class);
    }
}
