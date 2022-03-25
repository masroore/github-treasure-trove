<?php

namespace App\Repositories\Eloquent;

use App\Models\Favorites;
use App\Repositories\FavoritesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class FavoritesRepository extends BaseRepository implements FavoritesRepositoryInterface
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
    public function __construct(Favorites $model)
    {
        $this->model = $model;
    }
}
