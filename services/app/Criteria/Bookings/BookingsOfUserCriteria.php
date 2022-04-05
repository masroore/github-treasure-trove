<?php
/*
 * File name: BookingsOfUserCriteria.php
 * Last modified: 2021.05.07 at 19:12:31
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\Bookings;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BookingsOfUserCriteria.
 */
class BookingsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var User
     */
    private $userId;

    /**
     * BookingsOfUserCriteria constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param string $model
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model;
        } elseif (auth()->user()->hasRole('provider')) {
            $eProviderId = DB::raw("json_extract(e_provider, '$.id')");

            return $model->join('e_provider_users', 'e_provider_users.e_provider_id', '=', $eProviderId)
                ->where('e_provider_users.user_id', $this->userId)
                ->groupBy('bookings.id')
                ->select('bookings.*');
        } elseif (auth()->user()->hasRole('customer')) {
            return $model->where('bookings.user_id', $this->userId)
                ->select('bookings.*')
                ->groupBy('bookings.id');
        }

        return $model;
    }
}
