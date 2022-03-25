<?php

namespace App\Repositories\Eloquent;

use App\Models\DealGroups;
use App\Repositories\DealGroupsRepositoryInterface;

class DealGroupsRepository extends BaseRepository implements DealGroupsRepositoryInterface
{
    /**
     * @var DealGroups
     */
    protected $model;

    public function __construct(DealGroups $model)
    {
        $this->model = $model;
    }
}
