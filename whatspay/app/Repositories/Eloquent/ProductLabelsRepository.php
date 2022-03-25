<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductLabels;
use App\Repositories\ProductLabelsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductLabelsRepository extends BaseRepository implements ProductLabelsRepositoryInterface
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
    public function __construct(ProductLabels $model)
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
