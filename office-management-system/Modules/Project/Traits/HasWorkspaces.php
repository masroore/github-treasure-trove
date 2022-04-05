<?php

namespace Modules\Project\Traits;

use Illuminate\Support\Facades\Auth;
use Modules\Project\Entities\Workspace;

trait HasWorkspaces
{
    /**
     * Determine if the given workspace is the current workspace.
     *
     * @param  mixed  $workspace
     */
    public function isCurrentWorkspace($workspace): bool
    {
        return $workspace->id === $this->currentWorkspace->id;
    }

    /**
     * Get the current workspace of the user's context.
     */
    public function currentWorkspace()
    {
        if (null === $this->current_workspace_id && $this->id) {
            $this->switchWorkspace($this->personalWorkspace());
        }

        return $this->belongsTo(Workspace::class, 'current_workspace_id');
    }

    /**
     * Switch the user's context to the given workspace.
     *
     * @param $workspace
     */
    public function switchWorkspace($workspace): bool
    {
        if (!$this->belongsToWorkspace($workspace)) {
            return false;
        }

        $this->forceFill([
            'current_workspace_id' => $workspace->id,
        ])->save();

        $this->setRelation('currentWorkspace', $workspace);

        return true;
    }

    /**
     * Get all of the workspaces the user owns or belongs to.
     */
    public function allWorkspaces(): \Illuminate\Collections\Collection
    {
        return $this->ownedWorkspaces->merge($this->workspaces)->sortBy('name');
    }

    /**
     * Get all of the workspaces the user owns.
     */
    public function ownedWorkspaces()
    {
        return $this->hasMany(Workspace::class);
    }

    /**
     * Get the user's "personal" workspace.
     *
     * @return \Modules\Project\Entities\Workspace
     */
    public function personalWorkspace()
    {
        return $this->ownedWorkspaces->where('default_workspace', true)->first();
    }

    /**
     * Determine if the user owns the given workspace.
     *
     * @param  mixed  $workspace
     *
     * @return bool
     */
    public function ownsWorkspace($workspace)
    {
        return $this->id == $workspace->user_id;
    }

    /**
     * Determine if the user belongs to the given workspace.
     *
     * @param  mixed  $workspace
     *
     * @return bool
     */
    public function belongsToWorkspace($workspace)
    {
        $flag = false;
        foreach ($workspace->teams as $team) {
            foreach ($team->users as $user) {
                if ($user->id == Auth::id()) {
                    $flag = true;

                    break;
                }
            }
        }

        if (!$flag) {
            return $this->workspaces->contains(function ($w) use ($workspace) {
                return $w->id === $workspace->id;
            }) || $this->ownsWorkspace($workspace);
        }

        return $flag;
    }

    /**
     * Get all of the teams the user belongs to.
     */
    public function workspaces()
    {
        return $this->hasMany(Workspace::class, 'user_id', 'id');
    }
}
