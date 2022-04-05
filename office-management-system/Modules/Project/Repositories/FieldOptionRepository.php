<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\FieldOption;

class FieldOptionRepository
{
    public $model;

    public function __construct(FieldOption $model)
    {
        $this->model = $model;
    }

    public function store($params)
    {
        return $this->model->forceCreate($params);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id, $with = [])
    {
        if ($with) {
            return $this->model->with($with)->findOrFail($id);
        }

        return $this->model->findOrFail($id);
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

    public function update(FieldOption $model, $params)
    {
        return $model->forceFill($params)->save();
    }
}
