<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductWithAttribute;
use App\Repositories\ProductWithAttributeRepositoryInterface;

class ProductWithAttributeRepository extends BaseRepository implements ProductWithAttributeRepositoryInterface
{
    /**
     * @var ProductWithAttribute
     */
    protected $model;

    public function __construct(ProductWithAttribute $model)
    {
        $this->model = $model;
    }
}
