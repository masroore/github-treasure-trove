<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Services\OrdersService;
use http\Exception;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * @var Orders
     */
    protected $orderService;

    /**
     * @param Orders $orderService
     */
    public function __construct(OrdersService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ordersStore(Request $request)
    {
        try {
            $order = $this->orderService->ordersStore($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order, 'Data Found');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $order = $this->orderService->view();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order, 'Data Found');
    }

    public function create()
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $order = $this->orderService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order, 'Order Created');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $order = $this->orderService->show($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order, 'Data Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
            $order = $this->orderService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order, 'Order Deleted Successfully');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $order = $this->orderService->destroy($id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], $order, 'Order Deleted Successfully');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusUpdate(Request $request)
    {
        try {
            $order = $this->orderService->statusUpdate($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], 'Order Status Updated Successfully', $order);
    }

    public function orderFliter(Request $request)
    {
        try {
            $order = $this->orderService->orderFliter($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order, 'Order Status Updated Successfully');
    }
}
