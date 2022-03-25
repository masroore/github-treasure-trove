<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Products;
use App\Models\Store;
use App\Models\User;
use App\Services\FavoritesService;
use Exception;
use Illuminate\Http\JsonResponse;

class FavoritesController extends BaseController
{
    /**
     * @var
     */
    public $favoritesService;

    /**
     * @var FavoritesService
     */
    public function __construct(FavoritesService $favoritesService)
    {
        $this->favoritesService = $favoritesService;
    }

    /**
     * add favorite store.
     */
    public function addFavoriteStore(Store $store): JsonResponse
    {
        try {
            $this->favoritesService->addFavorite($store);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.default_store_updated'));
    }

    /**
     * delete favorite store.
     */
    public function deleteFavoriteStore(Store $store): JsonResponse
    {
        try {
            $this->favoritesService->deleteFavorite($store);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.default_store_updated'));
    }

    /**
     * get favorite stores.
     */
    public function getFavoriteStores(): JsonResponse
    {
        try {
            $favorite_stores = (new User())->favoriteStores();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($favorite_stores, __('user.success.default_store_updated'));
    }

    /**
     * add product to wish list.
     */
    public function addFavoriteProduct(Products $product): JsonResponse
    {
        try {
            $this->favoritesService->addFavorite($product);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.default_store_updated'));
    }

    /**
     * delete product from wish list.
     */
    public function deleteFavoriteProduct(Products $product): JsonResponse
    {
        try {
            $this->favoritesService->deleteFavorite($product);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('user.success.default_store_updated'));
    }

    /**
     * get user wish list.
     */
    public function getFavoriteProducts(): JsonResponse
    {
        try {
            $favorite_products = (new User())->favoriteProducts();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($favorite_products, __('user.success.default_store_updated'));
    }
}
