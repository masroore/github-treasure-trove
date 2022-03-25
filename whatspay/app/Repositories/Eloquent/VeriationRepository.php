<?php

namespace App\Repositories\Eloquent;

use App\Models\Veriations;
use App\Repositories\VeriationRepositoryInterface;

class VeriationRepository extends BaseRepository implements VeriationRepositoryInterface
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
    public function __construct(Veriations $model)
    {
        $this->model = $model;
    }
}
