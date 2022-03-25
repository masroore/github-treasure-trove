<?php

namespace App\Repositories\Eloquent;

use App\Models\AttributeSet;
use App\Repositories\AttributeSetRepositoryInterface;

class AttributeSetRepository extends BaseRepository implements AttributeSetRepositoryInterface
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
    public function __construct(AttributeSet $model)
    {
        $this->model = $model;
    }
}
