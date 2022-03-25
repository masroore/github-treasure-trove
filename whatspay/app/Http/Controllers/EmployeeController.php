<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    /**
     * @var
     */
    protected $employeeService;

    /**
     * EmployeeController constructor.
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(Request $request)
    {
        try {
            $employee = $this->employeeService->getAll($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }

        return $this->sendResponse($employee, __('employee.success.found'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function store(Request $request)
    {
        try {
            $employee = $this->employeeService->store($request);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($employee, __('employee.success.added'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    /*public function show(Employee $employee)
    {
        //
    }*/

    public function show(Request $request, $id)
    {
        try {
            $employee = $this->employeeService->show($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($employee, __('employee.success.found'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $updated = $this->employeeService->update($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        if (true === $updated) {
            $updated = 'employee.success.updated';
        } else {
            $updated = 'employee.error.updated';
        }

        return $this->sendResponse([], __($updated));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $this->employeeService->destroy($request, $id);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse([], __('employee.success.deleted'));
    }
}
