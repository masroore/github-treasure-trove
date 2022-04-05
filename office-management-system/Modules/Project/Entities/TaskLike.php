<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class TaskLike extends Model
{
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\TaskLikeFactory::new();
    }
}
