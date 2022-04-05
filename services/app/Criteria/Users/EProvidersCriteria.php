<?php
/**
 * File name: EProvidersCriteria.php
 * Last modified: 2021.01.02 at 19:15:05
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021.
 */

namespace App\Criteria\Users;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EProvidersCriteria.
 */
class EProvidersCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository.
     *
     * @param string              $model
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('roles', function ($q): void {
            $q->where('name', 'provider');
        });
    }
}
