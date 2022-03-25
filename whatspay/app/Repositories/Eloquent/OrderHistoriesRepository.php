<?php

namespace App\Repositories\Eloquent;

use App\Models\OrderHistories;
use App\Models\Orders;
use App\Repositories\OrderHistoriesRepositoryInterface;

class OrderHistoriesRepository extends BaseRepository implements OrderHistoriesRepositoryInterface
{
    /**
     * @var Orders
     */
    protected $model;

    /**
     * @param Orders $model
     */
    public function __construct(OrderHistories $model)
    {
        $this->model = $model;
    }
}
