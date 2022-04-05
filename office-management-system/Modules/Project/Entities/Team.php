<?php

namespace Modules\Project\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'privacy_type',
        'workspace_id',
    ];

    protected $primaryKey = 'id';

    protected $table = 'teams';

    protected static $logName = 'team';

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    protected static $ignoreChangedAttributes = ['updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->with('users');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function allUsers()
    {
        return $this->users->merge(collect([$this->owner]))->sortBy('name');
    }
}
