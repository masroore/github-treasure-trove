<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddProductVariant extends Model
{
    protected $casts = [
        'attr_value' => 'array', // Will convarted to (Array)
    ];

    public function productvar()
    {
        return $this->belongsTo('App\Product', 'pro_id', 'id')->withTrashed();
    }

    public function getattrname()
    {
        return $this->belongsTo('App\ProductAttributes', 'attr_name', 'id');
    }

    public function getattrValue()
    {
        return $this->belongsTo('App\ProductValues', 'attr_value', 'id');
    }
}
