<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = ['id', 'name', 'option_id', 'image', 'sort_order'];

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}
