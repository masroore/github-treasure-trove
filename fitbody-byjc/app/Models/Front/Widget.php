<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Widget.
 */
class Widget extends Model
{
    /**
     * @var string
     */
    protected $table = 'widgets';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @param $query
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @param $query
     */
    public function scopeHomepage($query)
    {
        return $query->where('group', 'homepage')->orderBy('sort_order');
    }
}
