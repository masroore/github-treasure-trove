<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\ProductLabelsService;
use Exception;
use Illuminate\Http\Request;

class ProductLabelsController extends BaseController
{
    protected $productlabelsService;

    public function __construct(ProductLabelsService $productlabelsService)
    {
        $this->productlabelsService = $productlabelsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        try {
            $addresses = $this->productlabelsService->getAll();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Label found');
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
            $address = $this->productlabelsService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($address, 'Label created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function show($id)
    {
        try {
            $addresses = $this->productlabelsService->show($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Label found');
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
            $this->productlabelsService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Label updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy($id)
    {
        try {
            $address = $this->productlabelsService->destroy($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Label deleted.');
    }
}
