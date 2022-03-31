<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['id', 'name', 'type', 'sort_order'];

    public function optionValues()
    {
        return $this->hasMany(OptionValue::class, 'option_id');
    }
}
