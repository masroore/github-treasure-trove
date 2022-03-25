<?php

namespace App\Repositories\Eloquent;

use App\Models\Deal;
use App\Repositories\DealRepositoryInterface;

class DealRepository extends BaseRepository implements DealRepositoryInterface
{
    /**
     * @var Deal
     */
    protected $model;

    public function __construct(Deal $model)
    {
        $this->model = $model;
    }
}
