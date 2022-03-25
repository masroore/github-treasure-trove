<?php

namespace App\Repositories\Eloquent;

use App\Models\Brands;
use App\Repositories\BrandsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BrandsRepository extends BaseRepository implements BrandsRepositoryInterface
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
    public function __construct(Brands $model)
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
