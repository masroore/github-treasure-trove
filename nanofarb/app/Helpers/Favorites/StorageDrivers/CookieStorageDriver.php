<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:18.
 */

namespace App\Helpers\Favorite\StorageDrivers;

use Cookie;
use Exception;

class CookieStorageDriver implements FavoriteStorageDriver
{
    /** @var string */
    const COOKIE_NAME = 'favorites';

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

    public function add(int $id): void
    {
        $this->items[$id] = $id;

        $this->updateCookies();
    }

    public function remove(int $id): bool
    {
        if (is_array($this->items) && ($index = array_search($id, $this->items)) !== false) {
            unset($this->items[$index]);
            $this->updateCookies();

            return true;
        }

        return false;
    }

    public function clear(): bool
    {
        $this->items = [];
        $this->updateCookies();

        return true;
    }

    protected function updateCookies(): void
    {
        Cookie::queue(self::COOKIE_NAME, json_encode($this->items), self::LIFETIME);
    }
}
