<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\IndustriesService;
use Exception;

class Industries extends BaseController
{
    /**
     * @var
     */
    protected $industriesService;

    /**
     * AddressController constructor.
     *
     * @param AddressService $industriesService
     */
    public function __construct(IndustriesService $industriesService)
    {
        $this->industriesService = $industriesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index()
    {
        try {
            $industries = $this->industriesService->all();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($industries, 'Data found.');
    }

    public function show($slug)
    {
        try {
            $industry = $this->industriesService->show($slug);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($industry, 'Data found.');
    }
}
