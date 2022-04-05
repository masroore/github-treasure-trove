<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    protected $guarded = [];

    public function postTranslated()
    {
        return $this->belongsTo(Post::class, 'post_translated_id', 'id');
    }
}
