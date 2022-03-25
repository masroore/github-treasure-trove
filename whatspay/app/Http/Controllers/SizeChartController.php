<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\SizeChartService;
use Exception;
use Illuminate\Http\Request;

class SizeChartController extends BaseController
{
    /**
     * @var
     */
    protected $sizeChartService;

    /**
     * SiseChartController constructor.
     */
    public function __construct(SizeChartService $sizeChartService)
    {
        $this->sizeChartService = $sizeChartService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(Request $request)
    {
        try {
            $get_data = $this->sizeChartService->getAll($request);
            if ($get_data) {
                return $this->sendResponse([$get_data], __('sizechart.success.found'));
            }

            return $this->sendError(__('sizechart.error.found'), []);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(Request $request)
    {
        try {
            $size_chart = $this->sizeChartService->store($request);
            if ($size_chart) {
                return $this->sendResponse([], __('sizechart.success.added'));
            }

            return $this->sendError(__('sizechart.error.added'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
            $get_data = $this->sizeChartService->show($request, $id);
            if (true === $get_data) {
                return $this->sendResponse([], __('sizechart.success.found'));
            }

            return $this->sendError(__('sizechart.error.found'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
            $updated = $this->sizeChartService->update($request, $id);
            if (true === $updated) {
                return $this->sendResponse([], __('sizechart.success.updated'));
            }

            return $this->sendError(__('sizechart.error.updated'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
            $updated = $this->sizeChartService->changeStatus($request, $id);
            if (true === $updated) {
                return $this->sendResponse([], __('sizechart.success.status'));
            }

            return $this->sendError(__('sizechart.error.status'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
            $deleted = $this->sizeChartService->destroy($id);

            if (true === $deleted) {
                return $this->sendResponse([], __('sizechart.success.deleted'));
            }

            return $this->sendError(__('sizechart.error.deleted'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
