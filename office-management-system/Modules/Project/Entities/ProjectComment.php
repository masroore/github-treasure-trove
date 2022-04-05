<?php

namespace Modules\Project\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    protected $fillable = [];

    protected $with = ['user', 'comments'];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\ProjectCommentFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
