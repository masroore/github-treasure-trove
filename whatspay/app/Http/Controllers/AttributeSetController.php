<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\AttributeSetService;
use Exception;
use Illuminate\Http\Request;

class AttributeSetController extends BaseController
{
    protected $attributeSetService;

    public function __construct(AttributeSetService $attributeSetService)
    {
        $this->attributeSetService = $attributeSetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        try {
            $attributes = $this->attributeSetService->index();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($attributes, 'Data found.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(Request $request)
    {
        try {
            $attribute = $this->attributeSetService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($attribute, 'AttributeService set created.');
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
            $attributes = $this->attributeSetService->show($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($attributes, 'Data found.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    // public function edit($id)
    // {
    //     //
    // }

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
            $attribute = $this->attributeSetService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($attribute, 'AttributeService set updated.');
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
            $this->attributeSetService->destroy($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'AttributeService set deleted.');
    }
}
