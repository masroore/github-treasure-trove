<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class VariantValues extends Model
{
    protected $table = 'variant_values';

    protected $fillable = ['value', 'variant_id'];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
