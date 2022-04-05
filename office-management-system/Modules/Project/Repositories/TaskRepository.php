<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\Task;

class TaskRepository
{
    public $model;

    public $section;

    public function __construct(
        Task $model,
        SectionRepository $section
    ) {
        $this->model = $model;
        $this->section = $section;
    }

    public function getByParam(array $param, $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where($param)->get();
        }

        return $this->model->where($param)->get();
    }

    public function findByParam(array $param, $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where($param)->firstOrFail();
        }

        return $this->model->where($param)->firstOrFail();
    }

    public function findById($id, $with = null)
    {
        if ($with) {
            return $this->model->with($with)->find($id);
        }

        return $this->model->find($id);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(Task $model, $params)
    {
        $model->forceFill($params)->save();

        return $model->refresh();
    }

    public function getByTaskGroupBySection(array $param)
    {
        return $this->model->groupBy('section_id')->where($param)->get();
    }

    public function delete(Task $model)
    {
        return $model->delete();
    }

    public function create($params)
    {
        return $this->model->forceCreate($params)->disableLogging();
    }

    public function getSectionFromChildTask($task)
    {
        if (!$task->section_id) {
            return $this->getSectionFromChildTask($this->findById($task->parent_id));
        }

        $section = $this->section->findByParam(['id' => $task->section_id], ['tasks' => function ($q) {
            return $q->with('tags')->orderBy('order', 'asc');
        }]);

        return $section;
    }
}
