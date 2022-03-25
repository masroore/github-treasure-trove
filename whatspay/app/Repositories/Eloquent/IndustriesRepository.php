<?php

namespace App\Repositories\Eloquent;

use App\Models\Industries;
use App\Repositories\IndustriesRepositoryInterface;

class IndustriesRepository extends BaseRepository implements IndustriesRepositoryInterface
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
    public function __construct(Industries $model)
    {
        $this->model = $model;
    }
}
