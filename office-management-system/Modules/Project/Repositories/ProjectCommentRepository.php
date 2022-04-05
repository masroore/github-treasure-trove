<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\ProjectComment;

class ProjectCommentRepository
{
    public $model;

    public function __construct(ProjectComment $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(ProjectComment $model, $params)
    {
        $model->forceFill($params)->save();

        return $model->refresh();
    }

    public function delete(ProjectComment $model)
    {
        return $model->delete();
    }

    public function create($params)
    {
        return $this->model->forceCreate($params);
    }
}
