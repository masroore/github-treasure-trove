<?php

namespace Modules\Project\Repositories;

use Modules\Project\Entities\Tag;

class TagRepository
{
    public $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function storeOrGet($data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function findByName($name)
    {
        return $this->model->where(['name' => $name])->first();
    }
}
