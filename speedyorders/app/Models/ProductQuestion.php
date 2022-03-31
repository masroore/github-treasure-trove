<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuestion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_questions';

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
    protected $fillable = ['product_id', 'customer_id', 'name', 'description', 'email', 'status'];

    public function customer()
    {
        return $this->belongsTo('App\Models\CustomerUser');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
