<?php
/**
 * File name: EProvidersCustomersCriteria.php
 * Last modified: 2021.01.02 at 19:15:05
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021.
 */

namespace App\Criteria\Users;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EProvidersCustomersCriteria.
 */
class EProvidersCustomersCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository.
     *
     * @param string $model
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('roles', function ($q): void {
            $q->where('name', '<>', 'admin');
        });
    }
}
