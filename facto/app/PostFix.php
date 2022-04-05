<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostFix extends Model
{
    protected $connection = 'repair';

    protected $table = 'posts';

    public function tags()
    {
        return $this->belongsToMany(TagFix::class, 'postfix_tagfix', 'post_id', 'tag_id');
    }
}
