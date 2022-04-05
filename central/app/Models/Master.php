<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table = 'ct_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option',
        'description',
        'value',
        'type',
        'suffix',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
