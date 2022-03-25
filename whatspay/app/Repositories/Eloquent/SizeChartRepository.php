<?php

namespace App\Repositories\Eloquent;

use App\Models\SizeChart;
use App\Repositories\SizeChartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SizeChartRepository extends BaseRepository implements SizeChartRepositoryInterface
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
    public function __construct(SizeChart $model)
    {
        $this->model = $model;
    }

    /*
     * Find all by column With Pagination.
     *
     * @param array $where
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Collection
     */
}
