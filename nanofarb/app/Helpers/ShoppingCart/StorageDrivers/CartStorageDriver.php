<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:02.
 */

namespace App\Helpers\ShoppingCart\StorageDrivers;

interface CartStorageDriver
{
    /**
     * Returns list of product ids.
     *
     * @return int[]
     */
    public function get();

    /**
     * Adds $amount product (s) with id $id.
     */
    public function add(int $id, int $amount = 1, ?int $color = null): void;

    /**
     * Update count product in cart.
     */
    public function update(int $id, int $amount, int $color): bool;

    /**
     * Removes $amount product (s) with id $id
     * If $amount is null, then the whole product is removed
     * Returns false if nothing has changed.
     */
    public function remove(int $id, ?int $amount = null, ?int $color = null): bool;

    /**
     * Get the total number of items in the cart.
     * So if you've added 2 books and 1 shirt,
     * it will return 3 items.
     *
     * @return int
     */
    //public function count(): int;

    /**
     * Get the calculated total of all items in the cart,
     * given there price and quantity.
     *
     * @return int
     */
    //public function total(): int;

    /**
     * Clear the cart
     * Returns false if cart was empty.
     */
    public function clear(): bool;
}
