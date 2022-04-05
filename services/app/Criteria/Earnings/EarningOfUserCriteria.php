<?php
/*
 * File name: EarningOfUserCriteria.php
 * Last modified: 2021.02.21 at 14:50:32
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\Earnings;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EarningOfUserCriteria.
 */
class EarningOfUserCriteria implements CriteriaInterface
{
    private $userId;

    /**
     * EarningOfUserCriteria constructor.
     *
     * @param $eproviderId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param string              $model
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model;
        } elseif ((auth()->user()->hasRole('provider'))) {
            return $model->join('e_provider_users', 'e_provider_users.e_provider_id', '=', 'earnings.e_provider_id')
                ->groupBy('earnings.id')
                ->where('e_provider_users.user_id', $this->userId);
        }

        return $model;
    }
}
