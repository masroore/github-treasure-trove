<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductLabelProducts;
use App\Repositories\ProductLabelProductsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductLabelProductsRepository extends BaseRepository implements ProductLabelProductsRepositoryInterface
{
    /**
     * @var ProductLabelProducts
     */
    protected $model;

    public function __construct(ProductLabelProducts $model)
    {
        $this->model = $model;
    }

    /**
     * Find all by column With Pagination.
     *
     * @return Collection
     */
    public function findAllByPagination(
        array $where,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ) {
        return $this->model->select($columns)->with($relations)->where($where)->paginate(5)->toArray();
    }
}
