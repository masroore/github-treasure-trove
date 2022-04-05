<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataFile extends Model
{
    protected $table = 'ct_datas_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
