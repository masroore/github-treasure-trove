<?php

namespace Modules\Project\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'default_workspace' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'default_workspace',
        'user_id',
    ];

    protected $primaryKey = 'id';

    protected $table = 'workspaces';

    protected static $logName = 'workspace';

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    protected static $ignoreChangedAttributes = ['updated_at'];

    /**
     * Get the owner of the workspace.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the workspace's users including its owner.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allUsers()
    {
        return $this->users->merge([$this->owner]);
    }

    /**
     * Determine if the given user belongs to the workspace.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function hasUser($user)
    {
        return $this->users->contains($user) || $user->ownsTeam($this);
    }

    /**
     * Determine if the given email address belongs to a user on the workspace.
     *
     * @return bool
     */
    public function hasUserWithEmail(string $email)
    {
        return $this->allUsers()->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    /**
     * Remove the given user from the workspace.
     *
     * @param  \App\Models\User  $user
     */
    public function removeUser($user): void
    {
        if ($user->current_workspace_id === $this->id) {
            $user->forceFill([
                'current_workspace_id' => null,
            ])->save();
        }

        $this->users()->detach($user);
    }

    /**
     * Purge all of the workspace's resources.
     */
    public function purge(): void
    {
        $this->owner()->where('current_workspace_id', $this->id)
            ->update(['current_workspace_id' => null]);

        $this->users()->where('current_workspace_id', $this->id)
            ->update(['current_workspace_id' => null]);

        $this->users()->detach();

        $this->delete();
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
