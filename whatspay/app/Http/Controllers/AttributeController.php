<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImagesTrait;
use App\Services\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    use ImagesTrait;
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index($id)
    {
        try {
            $attributes = $this->attributeService->index($id);
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
            $attribute = $this->attributeService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($attribute, 'Attribute created.');
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
            $attributes = $this->attributeService->show($id);
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
            $attribute = $this->attributeService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($attribute, 'Attribute updated Successfully.');
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
            $this->attributeService->destroy($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Attribute deleted.');
    }
}
