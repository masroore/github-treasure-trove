<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealGroupDetails;
use App\Models\DealGroups;
use App\Services\DealService;
use Illuminate\Http\Request;

class DealController extends BaseController
{
    /**
     * @var DealService
     */
    protected $dealservice;

    public function __construct(DealService $dealservice)
    {
        $this->dealservice = $dealservice;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $deals = $this->dealservice->index($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deals, 'Data found ');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $deal = $this->dealservice->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deal, 'Deal Created Successfully ');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Deal $deal)
    {
        try {
            $deal = $this->dealservice->view($deal);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deal, 'Data found ');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Deal $deal)
    {
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $deal = $this->dealservice->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deal, 'Deal Updated Successfully ');
    }

    /**
     * @param Deal $deal
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($deal)
    {
//        dd($deal);
        try {
            $deal = $this->dealservice->destroy($deal);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deal, 'Deal Deleted Successfully ');
    }

    /**
     * @param DealGroups $deal
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupDelete($deal)
    {
        try {
            $deal = $this->dealservice->groupDelete($deal);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deal, 'Group Deleted Successfully');
    }

    /**
     * @param DealGroupDetails $deal
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function choiceDelete($deal)
    {
        try {
            $deal = $this->dealservice->choiceDelete($deal);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($deal, 'choice Deleted Successfully ');
    }
}
