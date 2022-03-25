<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Slug;
use App\Services\PublicService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicController extends BaseController
{
    /**
     * @var PublicService
     */
    private $publicService;

    public function __construct(PublicService $publicService)
    {
        $this->publicService = $publicService;
    }

    /**
     * home page stores listing.
     *
     * @return JsonResponse
     */
    public function homeListing()
    {
        try {
            $stores = $this->publicService->homeListing();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, 'Store Data');
    }

    /**
     * search for store.
     *
     * @return JsonResponse
     */
    public function search($keyword)
    {
        try {
            $stores = $this->publicService->search($keyword);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, 'Store Data');
    }

    /**
     * stores by specific industry.
     *
     * @param $slug
     *
     * @return JsonResponse
     */
    public function storesByIndustry(Slug $slug)
    {
        try {
            $store = $this->publicService->storesByIndustry($slug->slugable_id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($store, 'Store Data');
    }

    /**
     * get store by business url.
     *
     * @param $url
     *
     * @return JsonResponse
     */
    public function getStore($url)
    {
        try {
            $store = $this->publicService->getStore($url);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($store, 'Store Data.');
    }

    public function getBranch($url, Request $request)
    {
        try {
            $branch = $this->publicService->getBranch($url, $request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($branch, 'Branch Data.');
    }

    /**
     * get store by slug.
     *
     * @param $slug
     *
     * @return JsonResponse
     */
    /*public function showStore($slug) {
        try {
            $store = $this->publicService->showStore($slug);
        } catch(Exception $e){
            return $this->sendError($e->getMessage(), []);
        }
        return $this->sendResponse($store, 'Store Data');
    }*/

    /**
     * get store categories by store id.
     *
     * @param $store
     *
     * @return JsonResponse
     */
    public function storeCategories($store)
    {
        try {
            $categories = $this->publicService->storeCategories($store);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($categories, 'Store Category.');
    }

    /**
     * get store category products by store id and category id.
     *
     * @param $store
     * @param $category
     *
     * @return JsonResponse
     */
    public function categoryProducts($store, $category)
    {
        try {
            $products = $this->publicService->categoryProducts($store, $category);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($products, 'Store Category.');
    }
}
