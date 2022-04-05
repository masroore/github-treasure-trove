<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\StoreService;
use Exception;
use Illuminate\Http\jsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class StoreController extends BaseController
{
    /**
     * @var
     */
    protected $storeService;

    /**
     * StoreController constructor.
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return jsonResponse
     */
    public function index()
    {
        try {
            $stores = $this->storeService->getAll();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, 'Store(s) found.');
    }

    /**
     * update store settings.
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id = 0)
    {
        try {
            if ($id > 0) {
                $store = Auth::user()->stores->where('store_id', $id);
                if ($store->isEmpty()) {
                    throw new InvalidArgumentException(__('user.error.empty', ['attribute' => 'Store']));
                }
            } else {
                $id = $request['store_id'];
            }
            switch ($request['purpose']) {
                case 'basic':
                    $stores = $this->storeService
                        ->updateBasic($request, $id);
                    $update_mesg = 'Store Updated.';

                    break;
                case 'contact':
                    $stores = $this->storeService
                        ->updateContact($request, $id);
                    $update_mesg = 'Store contact info updated.';

                    break;
                case 'bank':
                    $stores = $this->storeService
                        ->updateBank($request, $id);
                    $update_mesg = 'Store bank info updated.';

                    break;
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, $update_mesg);
    }

    /**
     * update store settings.
     *
     * @return JsonResponse
     */
    public function settings(Request $request)
    {
        try {
            $this->storeService->updateSettings($request, $request['store_id']);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Store settings updated.');
    }

    /**
     * @return JsonResponse
     */
    public function storeTimings(Request $request)
    {
        try {
            $this->storeService->storeTimings($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Store Timings updated.');
    }

    /**
     * update profile logo.
     *
     * @return JsonResponse
     */
    public function imageUpdate(Request $request)
    {
        try {
            $this->storeService->imageUpdate($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Successfully Updated Business Profile Image');
    }

    /**
     * Create Branch.
     *
     * @return jsonResponse
     */
    public function addBranch(Request $request)
    {
        try {
            $this->storeService->addBranch($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Branch Created.');
    }

    /**
     * Manage Branch.
     *
     * @return jsonResponse
     */
    public function manageBranch(Request $request)
    {
        try {
            $branches = $this->storeService->manageBranch($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($branches, 'Branches found');
    }

    /**
     * Show Branch.
     *
     * @return jsonResponse
     */
    public function showBranch(Request $request, $id)
    {
        try {
            $addresses = $this->storeService->showBranch($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Branch found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return jsonResponse
     */
    public function destroyBranch(Request $request, $id)
    {
        try {
            $address = $this->storeService->destroyBranch($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Branch deleted.');
    }

    /**
     * update Branch settings.
     *
     * @return jsonResponse
     */
    public function updateBranch(Request $request, $id)
    {
        try {
            $stores = $this->storeService
                ->updateBranch($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, 'Branch updated.');
    }

    public function getStore(Request $request)
    {
        try {
            $stores = $this->storeService->getStore($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, 'Store Data.');
    }

    public function getBranch(Request $request)
    {
        try {
            $branch = $this->storeService->getBranch($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($branch, 'Branch Data.');
    }

    public function homeListing()
    {
        try {
            $stores = $this->storeService->homeListing();
//            dd($stores);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($stores, 'Store Data');
    }

    public function viewStore($slug)
    {
        try {
            $store = $this->storeService->viewStore($slug);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($store, 'Store Data');
    }

    public function storesByIndustry($slug)
    {
        try {
            $store = $this->storeService->storesByIndustry($slug);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($store, 'Store Data');
    }

    public function getStoreCategory(Request $request, $id)
    {
        try {
            $categories = $this->storeService->getStoreCategory($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($categories, 'Store Category.');
    }

    public function getStoreProducts(Request $request, $store_id, $category_id)
    {
        try {
            $products = $this->storeService->getStoreProducts($request, $store_id, $category_id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($products, 'Store Category.');
    }

    /**
     * Store listing.
     *
     * @return jsonResponse
     */
    public function listings(Request $request)
    {
        try {
            $stores = Auth::user()->stores;
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([$stores], 'Stores Found.');
    }

    /**
     * Change Store status.
     *
     * @return jsonResponse
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $stores = $this->storeService->changeStatus($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        if (true === $stores) {
            return $this->sendResponse([], 'Status Updated.');
        }

        return $this->sendError('Status not changed.', []);
    }

    /**
     * Create Store.
     *
     * @return jsonResponse
     */
    public function createStore(Request $request)
    {
        try {
            $this->storeService->createStore($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Store Created.');
    }

    /**
     * Soft Delete Stores.
     *
     * @return jsonResponse
     */
    public function delete($ids)
    {
        try {
            $user_id = Auth::user()->id;
            $ids = explode(',', $ids);
            if (!empty($ids)) {
                //$data = $this->storeService->delete($ids, $user_id);
                //return $this->sendResponse($data, 'Store(s) found.');
                if (true === $this->storeService->delete($ids, $user_id)) {
                    return $this->sendResponse([], 'Store Deleted.');
                }

                return $this->sendError('Store(s) not deleted.', []);
            }

            throw new InvalidArgumentException(__('user.error.empty', ['attribute' => 'Store']));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }
    }

    public function notificationview(Request $request)
    {
        try {
            $data = $this->storeService->notificationview($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($data, 'data found Created.');
    }

    public function deletenoti($id)
    {
        try {
            $data = $this->storeService->deletenoti($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Notification Deleted.', $data);
    }

    public function statuChange(Request $request, $id)
    {
        try {
            $data = $this->storeService->statuChange($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($data, 'status changed.');
    }
}
