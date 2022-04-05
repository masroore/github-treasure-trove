<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:18.
 */

namespace App\Helpers\Favorite\StorageDrivers;

use App\Models\Shop\Product;

class EloquentStorageDriver implements FavoriteStorageDriver
{
    protected $user;

    protected $items;

    protected $favorites;

    /**
     * CartEloquentStorageDriver constructor.
     */
    public function __construct()
    {
        $this->user = auth()->user();
        $this->favorites = $this->user->productFavorites;
    }

    /**
     * Returns list of product ids.
     *
     * @return int[]
     */
    public function get(): array
    {
        if ($this->items === null) {
            $this->items = $this->favorites->pluck('id')->toArray();
        }

        return $this->items;
    }

    public function add(int $id): void
    {
        if ($existingProduct = $this->user->productFavorites->where('id', $id)->first()) {
            // ...
        } elseif ($product = Product::find($id)) {
            $this->user->productFavorites()->attach($id);

            $this->items[] = $id;
        }
    }

    public function remove(int $id): bool
    {
        if ($existingProduct = $this->user->productFavorites->where('id', $id)->first()) {
            $this->user->productFavorites()->detach($id);

            if (is_array($this->items) && ($index = array_search($id, $this->items)) !== false) {
                unset($this->items[$index]);
            }

            return true;
        }

        return false;
    }

    public function clear(): bool
    {
        $this->items = [];
        $this->user->productFavorites()->detach();

        return true;
    }
}
