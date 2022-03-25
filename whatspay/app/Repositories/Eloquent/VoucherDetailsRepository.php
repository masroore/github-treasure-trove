<?php

namespace App\Repositories\Eloquent;

use App\Models\VoucherDetails;
use App\Repositories\VoucherDetailsRepositoryInterface;

class VoucherDetailsRepository extends BaseRepository implements VoucherDetailsRepositoryInterface
{
    /**
     * @var VoucherDetails
     */
    protected $model;

    public function __construct(VoucherDetails $model)
    {
        $this->model = $model;
    }
}
