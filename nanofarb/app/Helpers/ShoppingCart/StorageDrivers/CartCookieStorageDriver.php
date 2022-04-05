<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:18.
 */

namespace App\Helpers\ShoppingCart\StorageDrivers;

use Cookie;
use Exception;

class CartCookieStorageDriver implements CartStorageDriver
{
    /** @var string */
    const COOKIE_NAME = 'cart';

    const LIFETIME = 129600;

    /** @var null|array */
    protected $items;

    /**
     * CartCookieStorageDriver constructor.
     */
    public function __construct()
    {
        if ($this->items === null) {
            $cookie = Cookie::get(self::COOKIE_NAME, '');

            try {
                $this->items = json_decode($cookie, true);
            } catch (Exception $exception) {
                $this->items = [];
            }
        }
    }

    /**
     * Returns list of product ids.
     *
     * @return int[]
     */
    public function get(): array
    {
        return $this->items ?? [];
    }

    /**
     * Adds $amount product (s) with id $id.
     */
    public function add(int $id, int $amount = 1, ?int $color = null): void
    {
        $oldAmount = $this->items[$id] ?? 0;
        $newAmount = $oldAmount + $amount;

        $this->items[$id] = $newAmount;

        $this->updateCookies();
    }

    public function update(int $id, int $amount = 1, ?int $color = null): bool
    {
        if ($amount < 1) {
            if ($this->items !== null) {
                unset($this->items[$id]);
            }
        } else {
            $this->items[$id] = $amount;
        }

        $this->updateCookies();

        return true;
    }

    /**
     * Removes $amount product (s) with id $id
     * If $amount is null, then the whole product is removed
     * Returns false if nothing has changed.
     */
    public function remove(int $id, ?int $amount = null, ?int $color = null): bool
    {
        $oldAmount = $this->items[$id] ?? null;

        if ($oldAmount === null) {
            return false;
        }

        if ($amount === null || $amount >= $oldAmount) {
            unset($this->items[$id]);
        } else {
            $newAmount = $oldAmount - $amount;
            $this->items[$id] = $newAmount;
        }

        $this->updateCookies();

        return true;
    }

    /**
     * Clear the cart
     * Returns false if cart was empty.
     */
    public function clear(): bool
    {
        if (empty($this->items)) {
            return false;
        }

        $this->items = [];
        $this->updateCookies();

        return true;
    }

    protected function updateCookies(): void
    {
        Cookie::queue(self::COOKIE_NAME, json_encode($this->items), self::LIFETIME);
    }
}
