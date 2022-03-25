<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        try {
            $addresses = $this->categoryService->getAll();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Categories found');
    }

    /**
     * Display a listing of Categories of Store.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function storeCategory()
    {
        try {
            $addresses = $this->categoryService->getAll();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Categories found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(Request $request)
    {
        try {
            $address = $this->categoryService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($address, 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function show($categoryid)
    {
        try {
            $addresses = $this->categoryService->show($categoryid);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Categories found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function edit($id)
    {

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
            $this->categoryService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            $address = $this->categoryService->destroy($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Category deleted.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destorybulk(Request $request)
    {
        try {
            $address = $this->categoryService->destorybulk($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Category deleted.');
    }

    /**
     * Change status of the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $updated = $this->categoryService->changeStatus($request, $id);
            if (true === $updated) {
                return $this->sendResponse([], 'Status changed.');
            }

            return $this->sendError('Status not changed.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function productMigration(Request $request)
    {
        try {
            $this->categoryService->productMigration($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Successfully Migrated.');
    }
}
