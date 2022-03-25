<?php

namespace App\Repositories\Eloquent;

use App\Models\OrderPaymentsExtraDetail;
use App\Repositories\OrderPaymentsExtraDetailRepositoryInterface;

class OrderPaymentsExtraDetailRepository extends BaseRepository implements OrderPaymentsExtraDetailRepositoryInterface
{
    /**
     * @var OrderPaymentsExtraDetail
     */
    protected $model;

    public function __construct(OrderPaymentsExtraDetail $model)
    {
        $this->model = $model;
    }
}
