<?php

namespace App\Repositories\Eloquent;

use App\Models\Store;
use App\Repositories\BranchRepositoryInterface;

class BranchRepository extends BaseRepository implements BranchRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Store $model)
    {
        $this->model = $model;
    }
}
