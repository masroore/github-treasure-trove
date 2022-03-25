<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
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
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    /**
     * Find model by column.
     *
     * @return Model
     */
    public function findByColumnCollection(
        array $where,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Collection {
        return $this->model->select($columns)->with($relations)->where($where)->get();
    }
}
