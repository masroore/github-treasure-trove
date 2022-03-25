<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductVariationItems;
use App\Repositories\ProductVariationItemsRepositoryInterface;

class ProductVariationItemsRepository extends BaseRepository implements ProductVariationItemsRepositoryInterface
{
    /**
     * @var Model|ProductVariationItems
     */
    protected $model;

    public function __construct(ProductVariationItems $model)
    {
        $this->model = $model;
    }
}
