<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = '';

    /**
     * Casting attributes to specific types.
     */
    protected $casts = [
        'last_updated' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
