<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductWithAttributeSet;
use App\Repositories\ProductWithAttributeSetRepositoryInterface;

class ProductWithAttributeSetRepository extends BaseRepository implements ProductWithAttributeSetRepositoryInterface
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
    public function __construct(ProductWithAttributeSet $model)
    {
        $this->model = $model;
    }
}
