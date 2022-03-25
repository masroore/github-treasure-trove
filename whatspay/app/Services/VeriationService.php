<?php

namespace App\Services;

use App\Repositories\VeriationRepositoryInterface;

class VeriationService
{
    /**
     * @var
     */
    protected $veriationRepository;

    /**
     * AttributeSetService constructor.
     */
    public function __construct(VeriationRepositoryInterface $veriationRepository)
    {
        $this->veriationRepository = $veriationRepository;
    }
}
