<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:02.
 */

namespace App\Helpers\Favorite\StorageDrivers;

interface FavoriteStorageDriver
{
    public function get(): array;

    public function add(int $id): void;

    public function remove(int $id): bool;

    public function clear(): bool;
}
