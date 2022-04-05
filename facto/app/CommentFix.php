<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentFix extends Model
{
    protected $connection = 'repair';

    protected $table = 'comments';

    public function customer()
    {
        return $this->belongsTo(CustomerFix::class);
    }
}
