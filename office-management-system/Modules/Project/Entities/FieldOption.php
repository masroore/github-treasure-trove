<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldOption extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\FieldOptionFactory::new();
    }
}
