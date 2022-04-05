<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\Project;

class ProjectRepository
{
    public $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        $project = $this->model->create([
            'name' => $data['name'],
            'user_id' => $data['user_id'],
            'team_id' => $data['team_id'],
            'description' => $data['description'] ?? null,
            'privacy' => $data['privacy'] ?? null,
            'default_view' => $data['default_view'] ?? null,
            'uuid' => $data['uuid'],
            'due_date' => $data['due_date'] ?? null,
        ]);

        return $project;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findByUuid($uuid, $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where(['uuid' => $uuid])->firstOrFail();
        }

        return $this->model->where(['uuid' => $uuid])->firstOrFail();
    }

    public function getByParam(array $param, array $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where($param)->first();
        }

        return $this->model->where($param)->first();
    }

    public function update(Project $project, $params)
    {
        $project->forceFill($params)->save();

        return $project->refresh();
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }
}
