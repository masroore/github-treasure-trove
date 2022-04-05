<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Company;

use Vanguard\Estimate;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\WorkOrder;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function leads()
    {
        $leads = Estimate::where('status', 0)->where('companyId', Auth()->user()->companyId)->get();

        return view('estimate.partials.modalLeadsBody', compact('leads'));
    }

    public function estimates()
    {
        $estimates = Estimate::where('status', 1)->where('companyId', Auth()->user()->companyId)->get();

        return view('estimate.partials.modalEstimateBody', compact('estimates'));
    }

    public function workorders()
    {
        $workOrders = WorkOrder::where('status', 1)->where('companyId', Auth()->user()->companyId)->get();

        return view('estimate.partials.modalWorkOrdersBody', compact('workOrders'));
    }

    public function invoices()
    {
        $invoices = Invoice::where('status', 1)->where('companyId', Auth()->user()->companyId)->get();

        return view('estimate.partials.modalInvoiceBody', compact('invoices'));
    }
}
