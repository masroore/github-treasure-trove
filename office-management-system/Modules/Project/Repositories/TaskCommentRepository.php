<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\TaskComment;

class TaskCommentRepository
{
    public $model;

    public function __construct(TaskComment $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(TaskComment $model, $params)
    {
        $model->forceFill($params)->save();

        return $model->refresh();
    }

    public function delete(TaskComment $model)
    {
        return $model->delete();
    }

    public function create($params)
    {
        return $this->model->forceCreate($params);
    }
}
