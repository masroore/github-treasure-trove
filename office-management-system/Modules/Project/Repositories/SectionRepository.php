<?php

namespace Modules\Project\Repositories;

use Illuminate\Validation\ValidationException;
use Modules\Project\Entities\Section;

class SectionRepository
{
    public $model;

    public function __construct(Section $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getByParam(array $param, array $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where($param)->orderBy('order', 'asc')->get();
        }

        return $this->model->where($param)->get();
    }

    public function findByParam(array $param, array $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where($param)->orderBy('order', 'asc')->first();
        }

        return $this->model->where($param)->first();
    }

    public function create($params)
    {
        return $this->model->forceCreate($params);
    }

    public function update(Section $model, $params)
    {
        return $model->forceFill($params)->save();
    }

    public function findOrFail($id, $field = 'message')
    {
        $model = $this->model->find($id);
        if (!$model) {
            throw ValidationException::withMessages([$field => __('project::section.not_found')]);
        }

        return $model;
    }

    public function delete(Section $model)
    {
        return $model->delete();
    }
}
