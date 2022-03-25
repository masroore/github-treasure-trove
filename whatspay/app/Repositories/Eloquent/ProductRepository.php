<?php

namespace App\Repositories\Eloquent;

use App\Models\Products;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
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
    public function __construct(Products $model)
    {
        $this->model = $model;
    }

    public function updateByColumns(array $where, array $payload)
    {
        dd($this->model->update($payload)->where($where));

        return $this->model->update($payload)->where($where);
    }
}
