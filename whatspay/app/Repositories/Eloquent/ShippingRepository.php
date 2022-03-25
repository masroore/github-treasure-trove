<?php

namespace App\Repositories\Eloquent;

use App\Models\Shipping;
use App\Repositories\ShippingRepositoryInterface;

class ShippingRepository extends BaseRepository implements ShippingRepositoryInterface
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
    public function __construct(Shipping $model)
    {
        $this->model = $model;
    }
}
