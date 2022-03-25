<?php

namespace App\Repositories\Eloquent;

use App\Models\Orders;
use App\Repositories\OrdersRepositoryInterface;

class OrdersRepository extends BaseRepository implements OrdersRepositoryInterface
{
    /**
     * @var Orders
     */
    protected $model;

    public function __construct(Orders $model)
    {
        $this->model = $model;
    }
}
