<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'user_id', 'workspace_id', 'color'];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\TagFactory::new();
    }
}
