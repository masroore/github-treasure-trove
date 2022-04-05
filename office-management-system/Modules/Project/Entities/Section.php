<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'order',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class)->with('fields', 'tasks');
    }
}
