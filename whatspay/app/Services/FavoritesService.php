<?php

namespace App\Services;

use App\Repositories\FavoritesRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class FavoritesService
{
    /**
     * @var
     */
    private $favoritesRepository;

    /**
     * favorites service constructor.
     */
    public function __construct(FavoritesRepositoryInterface $favoritesRepository)
    {
        $this->favoritesRepository = $favoritesRepository;
    }

    /**
     * Add favorite model.
     *
     * @return Model $favorite
     */
    public function addFavorite(Model $model): ?Model
    {
        try {
            $payload = [
                'favorable_type' => \get_class($model),
                'favorable_id' => $model->id,
                'user_id' => Auth::id(),
            ];

            $favorite = $this->favoritesRepository->updateGetModel($payload, $payload);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $favorite;
    }

    /**
     * Delete favorite store.
     *
     * @return bool $deleted
     */
    public function deleteFavorite(Model $model): ?bool
    {
        try {
            $deleted = $this->favoritesRepository->deleteByColumn([
                'favorable_type' => \get_class($model),
                'favorable_id' => $model->id,
                'user_id' => Auth::id(),
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }
}
