<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class TaskDependency extends Model
{
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\TaskDependencyFactory::new();
    }
}
