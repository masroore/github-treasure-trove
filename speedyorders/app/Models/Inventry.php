<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventry extends Model
{
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inventry';

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
    protected $fillable = ['available', 'alert_qty', 'products_id'];
}
