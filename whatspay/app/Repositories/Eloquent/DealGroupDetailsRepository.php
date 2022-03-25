<?php

namespace App\Repositories\Eloquent;

use App\Models\DealGroupDetails;
use App\Repositories\DealGroupDetailsRepositoryInterface;

class DealGroupDetailsRepository extends BaseRepository implements DealGroupDetailsRepositoryInterface
{
    /**
     * @var DealGroupDetails
     */
    protected $model;

    public function __construct(DealGroupDetails $model)
    {
        $this->model = $model;
    }
}
