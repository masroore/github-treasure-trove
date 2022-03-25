<?php

namespace App\Repositories\Eloquent;

use App\Models\Store;
use App\Repositories\StoreRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StoreRepository extends BaseRepository implements StoreRepositoryInterface
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
    public function __construct(Store $model)
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

    /**
     * Find model by column.
     *
     * @return Collection
     */
    public function findByMultipleColumns(
        string $column,
        array $whereIn,
        array $where,
        array $columns = ['*']
    ): ?Collection {
        return $this->model->select($columns)->whereIn($column, $whereIn)->where($where)->get();
    }

    /**
     * Delete model by column.
     *
     * @param array $column
     */
    public function deleteMultipleByColumn(string $column, array $where): bool
    {
        return $this->model->whereIn($column, $where)->delete();
    }
}
