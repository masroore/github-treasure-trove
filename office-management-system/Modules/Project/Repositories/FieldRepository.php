<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\Field;

class FieldRepository
{
    public $model;

    public function __construct(Field $model)
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
            return $this->model->with($with)->where($param)->get();
        }

        return $this->model->where($param)->get();
    }

    public function findByParam(array $param, array $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where($param)->first();
        }

        return $this->model->where($param)->first();
    }

    public function findOrFail($field_id, array $with = [])
    {
        if ($with) {
            return $this->model->with($with)->where(['id' => $field_id])->firstOrFail();
        }

        return $this->model->where(['id' => $field_id])->firstOrFail();
    }

    public function update(Field $model, $params)
    {
        return $model->forceFill($params)->save();
    }

    public function delete(Field $model)
    {
        return $model->delete();
    }
}
