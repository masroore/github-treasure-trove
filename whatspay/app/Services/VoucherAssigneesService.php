<?php

namespace App\Services;

use App\Repositories\VoucherAssigneesRepositoryInterface;

class VoucherAssigneesService
{
    /**
     * @var VoucherAssigneesRepositoryInterface
     */
    protected $VoucherAssigneesRepository;

    public function __construct(VoucherAssigneesRepositoryInterface $VoucherAssigneesRepository)
    {
        $this->VoucherAssigneesRepository = $VoucherAssigneesRepository;
    }
}
