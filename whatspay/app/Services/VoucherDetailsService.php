<?php

namespace App\Services;

use App\Repositories\VoucherDetailsRepositoryInterface;

class VoucherDetailsService
{
    /**
     * @var
     */
    protected $voucherdetailsRepository;

    public function __construct(VoucherDetailsRepositoryInterface $voucherdetailsRepository)
    {
        $this->voucherdetailsRepository = $voucherdetailsRepository;
    }
}
