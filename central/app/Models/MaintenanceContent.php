<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceContent extends Model
{
    protected $table = 'ct_maintenance_contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang',
        'content',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
