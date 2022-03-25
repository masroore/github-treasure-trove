<?php

namespace App\Services;

use App\Repositories\DealRepositoryInterface;

class DealGroupDetailsService
{
    /**
     * @var DealRepositoryInterface
     */
    protected $dealRepository;

    public function __construct(DealRepositoryInterface $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }
}
