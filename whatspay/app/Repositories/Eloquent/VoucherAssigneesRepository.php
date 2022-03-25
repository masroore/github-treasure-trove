<?php

namespace App\Repositories\Eloquent;

use App\Models\VoucherAssignees;
use App\Repositories\VoucherAssigneesRepositoryInterface;

class VoucherAssigneesRepository extends BaseRepository implements VoucherAssigneesRepositoryInterface
{
    /**
     * @var VoucherAssignees
     */
    protected $model;

    public function __construct(VoucherAssignees $model)
    {
        $this->model = $model;
    }
}
