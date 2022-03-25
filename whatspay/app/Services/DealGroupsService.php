<?php

namespace App\Services;

use App\Repositories\DealGroupsRepositoryInterface;

class DealGroupsService
{
    /**
     * @var DealGroupsRepositoryInterface
     */
    protected $dealgroupsrepository;

    public function __construct(DealGroupsRepositoryInterface $dealgroupsrepository)
    {
        $this->dealgroupsrepository = $dealgroupsrepository;
    }
}
