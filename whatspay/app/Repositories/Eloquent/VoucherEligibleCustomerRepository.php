<?php

namespace App\Repositories\Eloquent;

use App\Models\VoucherEligibleCustomer;
use App\Repositories\VoucherEligibleCustomerRepositoryInterface;

class VoucherEligibleCustomerRepository extends BaseRepository implements VoucherEligibleCustomerRepositoryInterface
{
    /**
     * @var VoucherEligibleCustomer
     */
    protected $model;

    public function __construct(VoucherEligibleCustomer $model)
    {
        $this->model = $model;
    }
}
