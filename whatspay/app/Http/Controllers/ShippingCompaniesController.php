<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\ShippingCompaniesService;
use Exception;
use Illuminate\Http\Request;

class ShippingCompaniesController extends BaseController
{
    protected $shippingCompaniesService;

    public function __construct(ShippingCompaniesService $shippingCompaniesService)
    {
        $this->shippingCompaniesService = $shippingCompaniesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(Request $request)
    {
        try {
            $companies = $this->shippingCompaniesService->getAll($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($companies, 'Categories found');
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
            $companies = $this->shippingCompaniesService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($companies, 'Shipping Company created');
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
            $companies = $this->shippingCompaniesService->show($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($companies, 'Companies found');
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
            $this->shippingCompaniesService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Company updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            $this->shippingCompaniesService->destroy($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Company deleted.');
    }

    public function status(Request $request, $id)
    {
        try {
            $this->shippingCompaniesService->status($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Status Updated');
    }
}
