<?php

namespace Modules\Project\Repositories;

use Illuminate\Validation\ValidationException;
use Modules\Project\Entities\Team;

class TeamRepository
{
    public $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function create($params)
    {
        return $this->model->forceCreate($params);
    }

    public function findOrFail($id, $field = 'message')
    {
        $model = $this->model->with('projects', 'projects.team', 'users', 'owner')->find($id);
        if (!$model) {
            throw ValidationException::withMessages([$field => __('project::team.not_found')]);
        }

        return $model;
    }

    public function update(Team $model, $params)
    {
        return $model->forceFill($params)->save();
    }

    public function teamByWorkspace($workspace_id)
    {
        return $this->model->where('workspace_id', $workspace_id)->get();
    }

    public function teamUsers($id)
    {
        $team = $this->model->with('users')->find($id);

        return $team->users();
    }

    public function teamUsers2($id)
    {
        $team = $this->model->with('users')->find($id);

        return $team->users;
    }

    public function getTeamByWorkspace($id)
    {
        return $this->model->where('workspace_id', $id)->get();
    }
}
