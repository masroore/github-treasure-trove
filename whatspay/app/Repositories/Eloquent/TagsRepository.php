<?php

namespace App\Repositories\Eloquent;

use App\Models\Tags;
use App\Repositories\TagsRepositoryInterface;

class TagsRepository extends BaseRepository implements TagsRepositoryInterface
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
    public function __construct(Tags $model)
    {
        $this->model = $model;
    }
}
