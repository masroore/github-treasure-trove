<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeSet extends Model
{
    use HasFactory;

    protected $table = 'product_attribute_sets';

    protected $fillable = [
        'store_id',
        'title',
        'slug',
        'display_layout',
        'order', // priority
    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}
