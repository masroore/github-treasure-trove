<?php

namespace App\Repositories\Eloquent;

use App\Models\Attribute;
use App\Repositories\AttributeRepositoryInterface;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }
}
