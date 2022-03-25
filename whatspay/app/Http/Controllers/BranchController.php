<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends BaseController
{
    /**
     * @var
     */
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    /**
     * Display a listing of the branches.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(Request $request)
    {
        try {
            $branches = $this->branchService->getAll($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($branches, __('store.branches.found'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(Request $request)
    {
        try {
            $branches = $this->branchService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($branches, __('store.branches.found'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $branch = $this->branchService->show($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($branch, __('store.success.found'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->branchService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('store.success.found'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $this->branchService->destroy($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('store.success.found'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function status(Request $request, $id)
    {
        try {
            $this->branchService->status($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('store.success.found'));
    }

    /**
     * update branch settings.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function settings(Request $request, $id)
    {
        try {
            $this->branchService->updateSettings($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Branch settings updated.');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTimings(Request $request, $id)
    {
        try {
            $this->branchService->storeTimings($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse([], 'Branch Timings updated.');
    }
}
