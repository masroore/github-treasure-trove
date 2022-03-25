<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductAddOns;
use App\Repositories\ProductAddOnsRepositoryInterface;

class ProductAddOnsRepository extends BaseRepository implements ProductAddOnsRepositoryInterface
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
    public function __construct(ProductAddOns $model)
    {
        $this->model = $model;
    }
}
