<?php

namespace App\Repositories\Eloquent;

use App\Models\ShippingRule;
use App\Repositories\ShippingRuleRepositoryInterface;

class ShippingRuleRepository extends BaseRepository implements ShippingRuleRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(ShippingRule $model)
    {
        $this->model = $model;
    }
}
