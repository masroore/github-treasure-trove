<?php

namespace App\Services;

use App\Repositories\VoucherUsageRepositoryInterface;

class VoucherUsageService
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
