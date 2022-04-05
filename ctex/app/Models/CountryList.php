<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryList extends Model
{
    protected $table = 'lk_countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alpha2Code',
        'name',
        'nativeName',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
