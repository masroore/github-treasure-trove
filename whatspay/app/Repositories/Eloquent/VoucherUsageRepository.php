<?php

namespace App\Repositories\Eloquent;

use App\Models\VoucherUsage;
use App\Repositories\VoucherUsageRepositoryInterface;

class VoucherUsageRepository extends BaseRepository implements VoucherUsageRepositoryInterface
{
    /**
     * @var VoucherUsage
     */
    protected $model;

    public function __construct(VoucherUsage $model)
    {
        $this->model = $model;
    }
}
