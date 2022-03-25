<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductTags;
use App\Repositories\ProductTagsRepositoryInterface;

class ProductTagsRepository extends BaseRepository implements ProductTagsRepositoryInterface
{
    /**
     * @var ProductTags
     */
    protected $model;

    public function __construct(ProductTags $model)
    {
        $this->model = $model;
    }
}
