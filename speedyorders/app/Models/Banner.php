<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'f_image', 'f_title', 'f_description', 'f_button_text', 'f_link', 's_image', 's_title', 's_description', 's_button_text', 's_link',
        't_image', 't_title', 't_description', 't_button_text', 't_link', 'sort_order', 'status',
    ];

    protected $hidden = [
        'id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        // Order by sort order ASC
        static::addGlobalScope('sort_order', function (Builder $builder): void {
            $builder->orderBy('sort_order', 'asc');
        });
    }
}
