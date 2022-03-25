<?php

namespace App\Repositories\Eloquent;

use App\Models\StoreBrands;
use App\Repositories\EloquentRepositoryInterface;

class StoreBrandsRepository extends BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * StoreBrandsRepository constructor.
     */
    public function __construct(StoreBrands $model)
    {
        $this->model = $model;
    }
}
