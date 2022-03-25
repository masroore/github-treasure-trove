<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\StoreBrandsService;
use Exception;
use Illuminate\Http\Request;

class StoreBrandsController extends BaseController
{
    protected $storeBrandsService;

    public function __construct(StoreBrandsService $storeBrandsService)
    {
        $this->storeBrandsService = $storeBrandsService;
    }

    public function index(Request $request)
    {
        try {
            $storeBrands = $this->storeBrandsService->getAll($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($storeBrands, 'store brands found');
    }

    public function store(Request $request)
    {
        try {
            $storeBrands = $this->storeBrandsService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($storeBrands, 'store brands found');
    }

    public function updateMultiple(Request $request)
    {
        try {
            $storeBrands = $this->storeBrandsService->updateMultiple($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($storeBrands, 'store brands found');
    }
}
