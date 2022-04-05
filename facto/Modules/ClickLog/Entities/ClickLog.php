<?php

namespace Modules\ClickLog\Entities;

use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    protected $table = 'click_logs';

    protected $fillable = [
        'post_id', 'cat_id', 'click_date', 'count',
    ];

    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
