<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $guarded = ['id'];

    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot(['value']);
    }
}
