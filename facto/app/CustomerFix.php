<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerFix extends Model
{
    protected $connection = 'repair';

    protected $table = 'customers';

    public function comments()
    {
        return $this->hasMany(CommentFix::class);
    }
}
