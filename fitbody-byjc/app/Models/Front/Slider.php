<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * @var string
     */
    protected $table = 'sliders';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @param $query
     */
    public function scopeHome($query)
    {
        return $this->where('group_id', 1)->orderBy('sort_order');
    }
}
