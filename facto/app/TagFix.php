<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagFix extends Model
{
    protected $connnection = 'repair';

    protected $table = 'tags';

    public function posts()
    {
        return $this->belongsToMany(PostFix::class, 'postfix_tagfix', 'tag_id', 'post_id');
    }
}
