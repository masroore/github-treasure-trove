<?php

namespace App\Services;

use App\Repositories\VoucherUsageRepositoryInterface;

class OrderProductService
{
    /**
     * @var VoucherUsageRepositoryInterface
     */
    protected $voucherusageRepository;

    public function __construct(VoucherUsageRepositoryInterface $voucherusageRepository)
    {
        $this->voucherusageRepository = $voucherusageRepository;
    }
}
