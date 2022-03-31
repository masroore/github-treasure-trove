<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reviews';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'customer_id', 'order_item_id', 'author', 'text', 'rating', 'image', 'status'];

    public function customer()
    {
        return $this->belongsTo('App\Models\CustomerUser');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
