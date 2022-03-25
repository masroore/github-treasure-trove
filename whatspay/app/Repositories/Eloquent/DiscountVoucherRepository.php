<?php

namespace App\Repositories\Eloquent;

use App\Models\DiscountVoucher;
use App\Repositories\DiscountVoucherRepositoryInterface;

class DiscountVoucherRepository extends BaseRepository implements DiscountVoucherRepositoryInterface
{
    /**
     * @var DiscountVoucher
     */
    protected $model;

    public function __construct(DiscountVoucher $model)
    {
        $this->model = $model;
    }
}
