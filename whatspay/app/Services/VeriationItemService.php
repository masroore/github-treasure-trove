<?php

namespace App\Services;

use App\Repositories\VeriationItemsRepositoryInterface;

class VeriationItemService
{
    /**
     * @var
     */
    protected $veriationitemRepository;

    /**
     * AttributeSetService constructor.
     */
    public function __construct(VeriationItemsRepositoryInterface $veriationitemRepository)
    {
        $this->veriationitemRepository = $veriationitemRepository;
    }
}
