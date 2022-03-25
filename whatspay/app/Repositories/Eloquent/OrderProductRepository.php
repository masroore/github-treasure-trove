<?php

namespace App\Repositories\Eloquent;

use App\Models\OrderProduct;
use App\Repositories\OrderProductRepositoryInterface;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    /**
     * @var OrderProduct
     */
    protected $model;

    public function __construct(OrderProduct $model)
    {
        $this->model = $model;
    }
}
