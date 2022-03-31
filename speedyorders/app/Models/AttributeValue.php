<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = ['id', 'name', 'attributes_id'];

    public function option()
    {
        return $this->belongsTo(Option::class, 'attributes_id');
    }
}
