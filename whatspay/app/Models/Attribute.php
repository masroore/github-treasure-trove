<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $table = 'product_attributes';

    protected $fillable = [
        'attribute_set_id',
        'title',
        'slug',
        'color',
        'image',
        'is_default',
        'order',
        'status ',
        'status ',
    ];

    public function attribute()
    {
        return $this->belongsTo(AttributeSet::class);
    }
}
