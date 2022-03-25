<?php

namespace App\Services;

use App\Repositories\VoucherEligibleCustomerRepositoryInterface;

class VoucherEligibleCustomerService
{
    /**
     * @var VoucherEligibleCustomerRepositoryInterface
     */
    protected $vouchereligiblecustomerRepository;

    public function __construct(VoucherEligibleCustomerRepositoryInterface $vouchereligiblecustomerRepository)
    {
        $this->vouchereligiblecustomerRepository = $vouchereligiblecustomerRepository;
    }
}
