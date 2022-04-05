<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:17.
 */

namespace App\Helpers\ShoppingCart;

use App\Helpers\ShoppingCart\StorageDrivers\CartStorageDriver;
use Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Session;

class Cart
{
    protected $app;

    protected $config;

    protected $storageClass;

    protected $storage;

    protected $currentUserId;

    /**
     * Cart constructor.
     *
     * @param null $app
     */
    public function __construct($app = null)
    {
        if (!$app) {
            $app = app();   //Fallback when $app is not given
        }

        $this->app = $app;

        $this->config = $this->app['config'];
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
        if ($defaultStorageDriverName = $this->config->get('shopping-cart.default')) {
            return $this->storage($defaultStorageDriverName);
        }

        throw new Exception('Shopping cart default storage is not set!');
    }

    /**
     * Returns list of product ids.
     */
    public function merge(array $storageNames, bool $clearAfterMerge = true): array
    {
        $storageNames = array_unique($storageNames);
        if (count($storageNames) > 1) {
            $firstStorageName = $storageNames[0];

            $firstStorageClass = $this->prepareStorageClass($firstStorageName);
            $firstStorage = $this->app->make($firstStorageClass);

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
//            Log::info($firstStorage->get());
            return $firstStorage->get();
        }

        return [];
    }

    public function getIds()
    {
//        dd($this->get()->products->toArray());
//        dd(count($this->get()->products->toArray()));
        return $this->get();
//        dd($this->get());
//        $ids = [];
//        foreach ($this->get()->products as $key => $item)
//        {
////            dd($item);
//            $ids[] = [
//                'id' => $item['id'],
//                'value_id' => $item['pivot']['value_id']
//
//            ];
//        }
//        dd($ids);
//        return $ids;
//        return array_keys($this->get());
    }

    /**
     * Returns list of product ids.
     *
     * @return int[]
     */
    public function get()
    {
        return $this->getStorage()->get();
    }

    /**
     * Adds $amount product (s) with id $id.
     */
    public function add(int $id, int $amount = 1, ?int $color = null): void
    {
        $this->getStorage()->add($id, $amount, $color);
    }

    public function update(int $id, int $amount = 1, ?int $color = null): bool
    {
        return $this->getStorage()->update($id, $amount, $color);
    }

    /**
     * Removes $amount product (s) with id $id
     * If $amount is null, then the whole product is removed
     * Returns false if nothing has changed.
     */
    public function remove(int $id, ?int $amount = null, ?int $color = null): bool
    {
        return $this->getStorage()->remove($id, $amount, $color);
    }

    /**
     * Clear the cart
     * Returns false if cart was empty.
     */
    public function clear(): bool
    {
        return $this->getStorage()->clear();
    }

    /**
     * Get the total number of items in the cart.
     * So if you've added 2 books and 1 shirt,
     * it will return 3 items.
     */
    public function count(): int
    {
//        return array_sum($this->get()->products->toArray());
//        Log::info($this->get()->products->toArray());
        if ($this->get()) {
            return count($this->get());
        }

        return 0;
    }

    /**
     * Get the total number of unique items in the cart.
     * So if you've added 2 books and 1 shirt,
     * it will return 2 items.
     */
    public function uniqueCount(): int
    {
        return count($this->get());
    }

    /**
     * Get the calculated total of all items in the cart,
     * given there price and quantity.
     */
    public function total(): int
    {
        return 0; // TODO
    }

    /**
     * @param mixed $currentUserId
     */
    public function setCurrentUserId($currentUserId): self
    {
        $this->currentUserId = $currentUserId;

        Session::put('cart_user_id', $currentUserId);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentUserId(?int $defaultId = null)
    {
        return $this->currentUserId ?: Auth::id() ?: Session::get('cart_user_id', $defaultId);
    }

    /**
     * @return \App\Helpers\ShoppingCart\CartStorageDriver
     */
    protected function getStorage(): CartStorageDriver
    {
        if ($this->storage === null) {
            $this->setDefaultStorage();
        }

        if ($this->storage === null) {
            throw new Exception('Shopping cart storage is not set!');
        }

        return $this->storage;
    }

    protected function prepareStorageClass(string $storageDriverName): string
    {
        $storageClass = $this->config->get("shopping-cart.storage_drivers.$storageDriverName");

        if (!class_exists($storageClass)) {
            throw new Exception("Class '$storageClass' not found");
        }

        return $storageClass;
    }
}
