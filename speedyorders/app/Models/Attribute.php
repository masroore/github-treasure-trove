<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['id', 'attribute_label', 'input_type', 'is_required', 'attribute_code', 'include_in_filter'];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attributes_id');
    }
}
