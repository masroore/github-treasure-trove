<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $guarded = ['id'];

    protected $with = ['new', 'old', 'field', 'creator'];

    public function new()
    {
        return $this->morphTo(__FUNCTION__, 'table_type', 'new_id');
    }

    public function old()
    {
        return $this->morphTo(__FUNCTION__, 'table_type', 'old_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }
}
