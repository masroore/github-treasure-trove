<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductsCustomFields;
use App\Repositories\ProductsCustomFieldsRepositoryInterface;

class ProductsCustomFieldsRepository extends BaseRepository implements ProductsCustomFieldsRepositoryInterface
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
    public function __construct(ProductsCustomFields $model)
    {
        $this->model = $model;
    }
}
