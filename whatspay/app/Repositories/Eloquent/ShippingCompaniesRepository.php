<?php

namespace App\Repositories\Eloquent;

use App\Models\ShippingCompanies;
use App\Repositories\ShippingCompaniesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ShippingCompaniesRepository extends BaseRepository implements ShippingCompaniesRepositoryInterface
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
    public function __construct(ShippingCompanies $model)
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
