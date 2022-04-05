<?php
/*
 * File name: CategoriesOfEProviderCriteria.php
 * Last modified: 2021.02.21 at 14:50:32
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\Categories;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CategoriesOfEProviderCriteria.
 */
class CategoriesOfEProviderCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $request;

    /**
     * CategoriesOfEProviderCriteria constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
        if (!$this->request->has('e_provider_id')) {
            return $model;
        }
        $id = $this->request->get('e_provider_id');

        return $model->join('e_services', 'e_services.category_id', '=', 'categories.id')
            ->where('e_services.e_provider_id', $id)
            ->select('categories.*')
            ->groupBy('categories.id');
    }
}
