<?php

namespace Modules\Project\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'team_id',
        'description',
        'privacy',
        'default_view',
        'uuid',
        'due_date',
    ];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\ProjectFactory::new();
    }

    protected $with = ['owner', 'team', 'users', 'comments'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')->withPivot(['icon', 'color', 'favourite', 'default_view']);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot(['order', 'field_id', 'visibility'])->orderBy('order', 'asc');
    }

    public function visible_fields()
    {
        return $this->fields()->where('visibility', 1);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function allUsers()
    {
        return $this->users->merge(collect([$this->owner]))->sortBy('name');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->with('fields');
    }

    public function comments()
    {
        return $this->hasMany(ProjectComment::class)->orderBy('id', 'desc');
    }
}
