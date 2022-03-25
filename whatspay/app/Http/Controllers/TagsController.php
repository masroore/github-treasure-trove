<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\TagsService;
use Exception;
use Illuminate\Http\Request;

class TagsController extends BaseController
{
    protected $tagsService;

    public function __construct(TagsService $tagsService)
    {
        $this->tagsService = $tagsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        try {
            $addresses = $this->tagsService->getAll();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Tags found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(Request $request)
    {
        try {
            $address = $this->tagsService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($address, 'Tags created');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    /*public function show($id)
    {
        try{
            $addresses = $this->tagsService->show($id);
        } catch(Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($addresses, 'Tags found');
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    /*public function update(Request $request, $id) {
        try {
            $this->tagsService->update($request, $id);
        } catch(Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Tags updated');
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    /*public function destroy($id)
    {
        try {
            $this->tagsService->destroy($id);
        } catch(Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Tag deleted.');
    }*/

    public function search($keyword)
    {
        try {
            $tags = $this->tagsService->search($keyword);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($tags, 'Tags found.');
    }
}
