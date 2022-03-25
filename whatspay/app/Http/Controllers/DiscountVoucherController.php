<?php

namespace App\Http\Controllers;

use App\Models\DiscountVoucher;
use App\Services\DiscountVoucherService;
use http\Exception;
use Illuminate\Http\Request;

class DiscountVoucherController extends BaseController
{
    /**
     * @var DiscountVoucherService
     */
    protected $discountvoucherservice;

    public function __construct(DiscountVoucherService $discountvoucherservice)
    {
        $this->discountvoucherservice = $discountvoucherservice;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $vouchers = $this->discountvoucherservice->viewAll();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($vouchers, 'Available Vouchers ');
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
            $discountvoucher = $this->discountvoucherservice->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($discountvoucher, 'Voucher Added Successfully ');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkVoucher($voucher)
    {
        try {
            $voucher_details = $this->discountvoucherservice->checkVoucher($voucher);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($voucher_details, 'Voucher Details ');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $voucher = $this->discountvoucherservice->view($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($voucher, 'Voucher Details ');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountVoucher $discountVoucher)
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
            $discountvoucher = $this->discountvoucherservice->updateVoucher($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($discountvoucher, 'Voucher Updated Successfully ');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $voucher_delete = $this->discountvoucherservice->destroy($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($voucher_delete, 'Voucher Delete Successfully ');
    }
}
