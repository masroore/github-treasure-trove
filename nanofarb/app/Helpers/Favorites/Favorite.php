<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:17.
 */

namespace App\Helpers\Favorites;

use App\Helpers\Favorite\StorageDrivers\CookieStorageDriver;
use App\Helpers\Favorite\StorageDrivers\EloquentStorageDriver;
use App\Helpers\Favorite\StorageDrivers\FavoriteStorageDriver;
use Exception;

class Favorite
{
    protected $app;

    protected $storageClass;

    protected $storage;

    public static $storageDrivers = [
        'cookie' => CookieStorageDriver::class,
        'eloquent' => EloquentStorageDriver::class,
    ];

    public function __construct($app = null)
    {
        if (!$app) {
            $app = app();   //Fallback when $app is not given
        }

        $this->app = $app;
    }

    /**
     * @return \App\Helpers\ShoppingCart\Favorite
     */
    public function storage(string $storageDriverName): self
    {
        $storageClass = $this->prepareStorageClass($storageDriverName);

        if ($this->storageClass !== $storageClass) {
            $this->storageClass = $storageClass;

            $this->storage = $this->app->make($this->storageClass);
        }

        if ($this->storage === null) {
            $this->storage = $this->app->make($storageClass);
        }

        return $this;
    }

    /**
     * @return \App\Helpers\ShoppingCart\Favorite
     */
    public function setDefaultStorage()
    {
        if ($defaultStorageDriverName = 'cookie') {
            return $this->storage($defaultStorageDriverName);
        }

        throw new Exception('Favorites default storage is not set!');
    }

    /**
     * Returns list of product ids.
     */
    public function merge(array $storageNames, bool $clearAfterMerge = true): array
    {
        $storageNames = array_unique($storageNames);
        $firstStorageName = $storageNames[0];

        $firstStorageClass = $this->prepareStorageClass($firstStorageName);
        $firstStorage = $this->app->make($firstStorageClass);

        if (count($storageNames) > 1) {
            foreach ($storageNames as $storageName) {
                if ($storageName !== $firstStorageName) {
                    $storageClass = $this->prepareStorageClass($storageName);
                    $storage = $this->app->make($storageClass);

                    $items = $storage->get();
                    $clearAfterMerge ? $storage->clear() : null;
                    foreach ($items as $id => $amount) {
                        $firstStorage->add($id, $amount);
                    }
                }
            }
        }

        return $firstStorage->get();
    }

    /**
     * Returns list of product ids.
     *
     * @return int[]
     */
    public function get(): array
    {
        return $this->getStorage()->get();
    }

    /**
     * @return bool
     */
    public function is(int $id)
    {
        return in_array($id, $this->get());
    }

    public function toggle($id): void
    {
        if ($this->is($id)) {
            $this->remove($id);
        } else {
            $this->add($id);
        }
    }

    /**
     * Adds $amount product (s) with id $id.
     */
    public function add(int $id): void
    {
        $this->getStorage()->add($id);
    }

    public function remove(int $id): bool
    {
        return $this->getStorage()->remove($id);
    }

    /**
     * Clear the cart
     * Returns false if cart was empty.
     */
    public function clear(): bool
    {
        return $this->getStorage()->clear();
    }

    public function count(): int
    {
        return count($this->get());
    }

    /**
     * @return \App\Helpers\ShoppingCart\CartStorageDriver
     */
    protected function getStorage(): FavoriteStorageDriver
    {
        if ($this->storage === null) {
            $this->setDefaultStorage();
        }

        if ($this->storage === null) {
            throw new Exception('Favorites storage is not set!');
        }

        return $this->storage;
    }

    protected function prepareStorageClass(string $storageDriverName): string
    {
        $storageClass = self::$storageDrivers[$storageDriverName];

        if (!class_exists($storageClass)) {
            throw new Exception("Class '$storageClass' not found");
        }

        return $storageClass;
    }
}
