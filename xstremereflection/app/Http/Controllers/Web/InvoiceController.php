<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Estimate;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\InvoicePackage;
use Vanguard\InvoicePayment;
use Vanguard\InvoiceService;
use Vanguard\Package;

use Vanguard\WorkOrder;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function estimateConvert($id): void
    {
        $estimate = Estimate::findOrFail($id);

        $newInvoice = Invoice::create([
            'companyId' => Auth()->user()->companyId,
            'customerId' => $estimate->customerId,
            'detailType' => $estimate->detailType,
            'serviceAddress' => $estimate->serviceAddress,
            'arrivalTime' => $estimate->arrivalTime,
            'dateofService' => $estimate->dateofService,
            'status' => 1,

        ]);

        foreach ($estimate->packages as $package) {
            $ip = InvoicePackage::create([
                'invoiceId' => $newInvoice->id,
                'packageId' => $package->packageId,
                'qty' => $package->quanity,
                'discount' => $package->discount,
                'discountType' => $package->discountType,
                'total' => $package->chargedPrice,
            ]);
        }

        foreach ($estimate->services as $service) {
            $ip = InvoiceService::create([
                'invoiceId' => $newInvoice->id,
                'serviceId' => $service->serviceId,
                'qty' => $service->quanity,
                'discount' => $service->discount,
                'discountType' => $service->discountType,
                'total' => $service->chargedPrice,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cid)
    {
        $customer = Customer::find($cid);
        $packages = Package::where('companyId', 0)->orWhere('companyId', Auth()->user()->company_Id)->get();

        return view('invoice.create', compact('packages', 'customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $workorder = WorkOrder::find($id);
        $estimate = Estimate::find($workorder->estimateId);
        $invoice = new Invoice();

        $invoice->companyId = Auth()->user()->companyId;
        $invoice->customerId = $workorder->estimate->customerId;
        $invoice->estimateId = $workorder->estimate->id;
        $invoice->workOrderId = $workorder->id;
        $invoice->detailType = $workorder->estimate->detailType;
        $invoice->dateofService = $workorder->estimate->dateofService;
        $invoice->total = $workorder->totalCharge;
        $invoice->deposit = $workorder->estimate->deposit;
        $invoice->status = 1;
        $invoice->save();

        $workorder->invoiceId = $invoice->id;
        $estimate->invoiceId = $invoice->id;

        $workorder->save();
        $estimate->save();

        return back()->with('success', 'Invoice Created.');
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
        $invoice = Invoice::find($id);

        return view('invoice.summary2', compact('invoice'));
    }

    public function paymentModal($id)
    {
        $invoice = Invoice::find($id);

        return view('invoice.partials.modalPaymentBody', compact('invoice'));
    }

    public function payment(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        $payment = new InvoicePayment();
        $payment->invoiceId = $id;
        $payment->pmtAmount = $request->pmtAmount;
        $payment->save();

        $newTotalPaid = $invoice->totalPaid + $request->pmtAmount;

        $invoice->totalPaid = $newTotalPaid;
        $invoice->save();

        if ($invoice->total <= $invoice->totalPaid) {
            $invoice->status = 99;
            $invoice->save();
        }

        return back()->with('success', 'Payment added to invoice.');
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
}
