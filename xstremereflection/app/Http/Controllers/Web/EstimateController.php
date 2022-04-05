<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\In;
use Notification;
use PDF;
use Vanguard\AddOnService;
use Vanguard\Customer;
use Vanguard\CustomerVehicle;
use Vanguard\Estimate;
use Vanguard\EstimatePackage;
use Vanguard\EstimateService;
use Vanguard\EstimateTracking;
use Vanguard\EstimateVehicle;

use Vanguard\Events\CustomerApprovedEstimateEvent;
use Vanguard\Events\NewEstimateCreatedEvent;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\Mail\AcceptedEstimateEmail;
use Vanguard\Mail\EstimateMailable;
use Vanguard\Mail\RescheduleReminder;
use Vanguard\Package;
use Vanguard\packageItem;
use Vanguard\Services;
use Vanguard\User;
use Vanguard\VehicleColor;
use Vanguard\VehicleCondition;
use Vanguard\WorkOrder;
use Vanguard\WorkOrderServices;
use Vanguard\WorkOrderTracking;

class EstimateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['customerReview', 'uploadSignature']]);
    }

    public function index()
    {
        $estimates = Estimate::with('workorder')
            ->where('companyID', Auth()->user()->companyId)
            ->where('status', '!=', 4)
            ->where('status', '!=', 6)
            ->orderBy('dateofService', 'desc')->get();

        return view('estimate.index', compact('estimates'));
    }

    public function uploadSignature(Request $request, $pid, $eid)
    {
        $invoice = Invoice::where('estimateId', $eid)->get();

        if (count($invoice)) {
            // dd('Invoice Exists');
            return back()->with('error', 'This estimate has already been approved please contact the shop');
        }
        $file = $request->signed;

        $package = EstimatePackage::find($pid);
        $package->approved = 1;
        $package->save();

        $estimate = Estimate::find($eid);
        // Update estimate to approved
        $estimate->approvedPackage = $pid;
        $estimate->signed = Carbon::now();
        $estimate->total = $package->chargedPrice;
        $estimate->deposit = $package->deposit;
        $estimate->save();

        //TODO work on making event work as intended ..... event(new CustomerApprovedEstimateEvent($file, $estimate));

        $customer = Customer::find($estimate->customerId);

        //Check if work order already exists and not create a new one if one does.

        $workorder = WorkOrder::where('estimateId', $estimate->id)->first();

        if (!$workorder) {
            // Create New Work Order
            $workorder = new WorkOrder();
            $workorder->companyId = $estimate->companyId;
            $workorder->estimateId = $estimate->id;
            $workorder->totalCharge = $estimate->total;
            $workorder->status = 1;
            $workorder->save();

            //Update estimate with new work order ID

            $estimate = Estimate::find($estimate->id);
            $estimate->workOrderId = $workorder->id;
            $estimate->save();

            //Add Services to work order
            if ($estimate->approvedPackage) {
                $array = explode(',', $estimate->acceptedPackage->package->includes);
                $services = packageItem::whereIn('packageId', $array)->get();

                foreach ($services as $service) {
                    $estimateService = new WorkOrderServices();
                    $estimateService->estimateId = $estimate->id;
                    $estimateService->workOrderId = $workorder->id;
                    $estimateService->qty = 1;
                    $estimateService->serviceId = $service->serviceId;
                    $estimateService->listPrice = $service->desc->charge;
                    $estimateService->chargedPrice = 0;
                    $estimateService->status = 1;
                    $estimateService->save();
                }
                $addons = AddOnService::where('packageId', $estimate->acceptedPackage)->get();

                foreach ($addons as $row) {
                    $estimateService = new WorkOrderServices();
                    $estimateService->estimateId = $estimate->id;
                    $estimateService->workOrderId = $workorder->id;
                    $estimateService->qty = 1;
                    $estimateService->serviceId = $row->serviceId;
                    $estimateService->listPrice = $row->desc->charge;
                    $estimateService->chargedPrice = $row->chargedPrice;
                    $estimateService->status = 1;
                    $estimateService->save();
                }
            }
        }

        //Update tracking of the work order.

        $wtracking = new WorkOrderTracking();
        $wtracking->workOrderId = $workorder->id;
        $wtracking->note = 'Estimate ' . $estimate->eid . ' approved by customer and work order created.';
        $wtracking->save();

        //Check for invoice already created...
        $invoice->where('estimateId', $estimate->id)->first();

        if (count($invoice)) {
        } else {
            // Create New Invoice
            $invoice = new Invoice();

            $invoice->companyId = $estimate->companyId;
            $invoice->customerId = $workorder->estimate->customerId;
            $invoice->estimateId = $workorder->estimate->id;
            $invoice->workOrderId = $workorder->id;
            $invoice->detailType = $workorder->estimate->detailType;
            $invoice->dateofService = $workorder->estimate->dateofService;
            $invoice->total = $workorder->totalCharge;
            $invoice->deposit = $estimate->deposit;
            $invoice->status = 1;
            $invoice->save();
        }

        //Update workorder with new invoice ID.

        $workorder->invoiceId = $invoice->id;
        $workorder->save();

        // Update estimate with new invoice ID.
        $estimate->invoiceId = $invoice->id;
        $estimate->save();

        //Send notification to customer and company admin that the estimate has been approved.
        if ($estimate->customer->email) {
            Mail::to([$estimate->customer->email, $estimate->company->email])->send(new AcceptedEstimateEmail($estimate));
            $userSchema = User::where('companyId', $estimate->companyId);

            if (Mail::failures()) {
                $tracking = new EstimateTracking();
                $tracking->estimateId = $estimate->id;
                $tracking->note = 'Customer approved and signed email was not sent.';
                $tracking->save();
            } else {
                $tracking = new EstimateTracking();
                $tracking->estimateId = $estimate->id;
                $tracking->note = 'You have successfully accepted the package and signed your estimate we attempted to email you a copy, unfortunately the email did not go through. One of our representative will contact you shortly..';
                $tracking->save();
            }
        }

        if ($invoice->deposit > 0) {
            $amount = $invoice->deposit * 100;
            $paymentDescription = 'Detail Deposit';
            if ($invoice->company->acceptPayment == 1) {
                return view('estimate.payment', compact('invoice', 'amount', 'customer', 'paymentDescription'))->with('success', 'You have successfully accepted the package and signed your estimate a copy will be emailed to you. One of our representative will contact you shortly.');
            }

            return view('invoice.summary', compact('invoice'));
        }

        return view('invoice.summary', compact('invoice'));
    }

    public function approved()
    {
        $estimates = Estimate::with('workorder')
            ->where('companyID', Auth()->user()->companyId)
            ->where('status', 4)
            ->orderBy('dateofService', 'desc')->get();

        return view('estimate.index', compact('estimates'));
    }

    public function canceled()
    {
        $estimates = Estimate::with('workorder')
            ->where('companyID', Auth()->user()->companyId)
            ->where('status', 6)
            ->orderBy('dateofService', 'desc')->get();

        return view('estimate.index', compact('estimates'));
    }

    public function estimateEmail(\Nexmo\Client $nexmo, $id)
    {
        $estimate = Estimate::with('customer', 'services', 'packages')->find($id);

        Mail::to([$estimate->customer->email])->send(new EstimateMailable($estimate));

        if (Mail::failures()) {
            $tracking = new EstimateTracking();
            $tracking->estimateId = $estimate->id;
            $tracking->note = 'Estimate email failed to send.';
            $tracking->save();

            return back()->with('error', 'The mail was not sent to the customer.');
        }
        $tracking = new EstimateTracking();
        $tracking->estimateId = $estimate->id;
        $tracking->note = 'Estimate emailed to the customer.';
        $tracking->save();
        /*
        if($estimate->customer->phoneNumber)
        {
            $text = 'Your detail estimate is available at https://www.detaildex.com/estimate/customerReview/'.$estimate->id.'/'.$estimate->customerCode;
            $message = $nexmo->message()->send([
                'to' => '1'.$estimate->customer->phoneNumber,
                'from' => '13147750809',
                'text' => $text
            ]);
        }
        */

        return back()->with('success', 'Email has been sent.');
    }

    public function upsalePdf($id)
    {
        $estimate = Estimate::find($id);
        $customer = $estimate->customer;

        view()->share('customer', $customer);
        view()->share('estimate', $estimate);

        $pdf = PDF::loadView('estimate.pdf.upsale')->setPaper('a4', 'landscape');

        return $pdf->stream('estimate_' . $estimate->id . '.pdf');

        //return view('estimate.pdf.upsale', compact('estimate', 'customer'));
    }

    public function store(Request $request)
    {
        // Check if Date of Service is completed to determine if estimate is a lead or estimate
        if ($request->dateofService) {
            $serviceDate = date('Y-m-d', strtotime($request->dateofService));
            $status = 1;
        } else {
            $serviceDate = null;
            $status = 0;
        }
        if ($request->arrivalTime == 0) {
            $arrivalTime = $request->arrivalTime;
        } else {
            $arrivalTime = null;
        }

        // Get count of estimate to build estimate id
        $estimates = Estimate::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->get();
        $index = count($estimates) + 1;

        //Build estimate ID
        $eid = Auth()->user()->companyId . '-' . Carbon::now()->format('y') . '-' . $index;

        //Check if customer exists in customer database and return error;
        if ($request->customer == 0) {
            $validatedData = $request->validate([
                'email' => 'required_without_all:phoneNumber|sometimes:customers|max:255',
                'phoneNumber' => 'required_without_all:email|sometimes:customers|max:255',
            ]);
            $customer = new Customer();

            $customer->companyId = Auth()->user()->companyId;
            $customer->firstName = $request->firstName;
            $customer->lastName = $request->lastName;
            $customer->phoneNumber = $request->phoneNumber;
            $customer->email = $request->email;
            $customer->address = $request->address;

            $customer->save();

        // TODO New Customer Created Event
        } else {
            $customer = Customer::find($request->customer);
        }

        //Create the estimate
        $estimate = new Estimate();
        $estimate->companyId = Auth()->user()->companyId;
        $estimate->eid = $eid;
        $estimate->detailType = $request->detailType;
        $estimate->customerId = $customer->id;
        $estimate->dateofService = $serviceDate;
        $estimate->arrivalTime = $arrivalTime;
        $estimate->status = $status;
        $estimate->ndp = $request->ndp;
        $estimate->ceramic = $request->ceramic;
        $estimate->save();

        event(new NewEstimateCreatedEvent($estimate));

        return redirect()->route('estimate.show', ['id' => $estimate->id]);
    }

    public function addPackage(Request $request, $id)
    {
        $package = Package::find($request->packageId);
        //dd($request->quanity);
        if ($request->discountType == 1) {
            //PERCENT DISCOUNT//
            $discountPercent = $request->discount / 100;
            $discountTotal = $package->cost * $discountPercent;

            $chargedPrice = $package->cost - $discountTotal;
        } elseif ($request->discountType == 2) {
            //CASH DISCOUNT//
            $chargedPrice = $package->cost - $request->discount;
        } else {
            $chargedPrice = $package->cost;
        }

        //dd($chargedPrice);

        $epackage = new EstimatePackage();

        $epackage->estimateId = $id;
        $epackage->companyId = Auth()->user()->companyId;
        $epackage->quanity = $request->quanity;
        $epackage->packageId = $request->packageId;
        $epackage->discount = $request->discount;
        $epackage->discountType = $request->discountType;
        $epackage->listPrice = $package->cost;
        $epackage->deposit = $request->deposit;
        $epackage->chargedPrice = $chargedPrice;

        $epackage->save();
        /*
        if($package->includes){
            $array = explode(',', $package->includes);
            foreach ($array as $include)
            {
                $services = packageItem::where('packageId', $include)->get();
                foreach ($services as $service){
                    $s = Services::find($service->serviceId);

                    $estimateService = new EstimateService;
                    $estimateService->estimateId = $id;
                    $estimateService->quanity = 1;
                    $estimateService->serviceId = $s->id;
                    $estimateService->listPrice = $s->charge;
                    $estimateService->chargedPrice = 0;
                    $estimateService->status = 1;
                    $estimateService->save();
                }

                $services = packageItem::where('packageId', $package->id)->get();
                foreach ($services as $service){
                    $s = Services::find($service->serviceId);

                    $estimateService = new EstimateService;
                    $estimateService->estimateId = $id;
                    $estimateService->quanity = 1;
                    $estimateService->serviceId = $s->id;
                    $estimateService->listPrice = $s->charge;
                    $estimateService->chargedPrice = 0;
                    $estimateService->status = 1;
                    $estimateService->save();
                }
            }
        }else{
            $services = packageItem::where('packageId', $package->id)->get();
            foreach ($services as $service){
                $s = Services::find($service->serviceId);

                $estimateService = new EstimateService;
                $estimateService->estimateId = $id;
                $estimateService->quanity = 1;
                $estimateService->serviceId = $s->id;
                $estimateService->listPrice = $s->charge;
                $estimateService->chargedPrice = 0;
                $estimateService->status = 1;
                $estimateService->save();
            }

        }
        */

        return redirect()->route('estimate.show', ['id' => $id])->with('success', 'Package added successfully.');
    }

    public function customerEditForm($eid)
    {
        $customers = Customer::where('companyId', Auth()->user()->companyId)->get();
        $estimate = Estimate::find($eid);

        return view('estimate.partials.modalCustomerEditForm', compact('customers', 'estimate'));
    }

    public function customerEdit(Request $request, $id)
    {
        if ($request->dateofService) {
            $serviceDate = date('Y-m-d', strtotime($request->dateofService));
            $status = 1;
        } else {
            $serviceDate = null;
            $status = 0;
        }

        $estimate = Estimate::find($id);

        $estimate->customerId = $request->customer;
        $estimate->dateofService = $serviceDate;
        $estimate->detailType = $request->detailType;
        $estimate->arrivalTime = $request->arrivalTime;
        $estimate->update();

        $etracking = new EstimateTracking();
        $etracking->estimateId = $id;
        $etracking->note = 'Estimate details have been edited.';
        $etracking->save();

        return back()->with('success', 'Estimate updated successfully.');
    }

    public function estimateCancel($id)
    {
        $estimate = Estimate::find($id);
        $estimate->status = 6;
        $estimate->save();

        $etracking = new EstimateTracking();
        $etracking->estimateId = $id;
        $etracking->status = 6;
        $etracking->note = 'Customer canceled the estimate / work Order';
        $etracking->save();

        $workOrder = WorkOrder::where('estimateId', $id)->first();

        if ($workOrder) {
            $workOrder->status = 9;
            $workOrder->save();

            $wtracking = new EstimateTracking();
            $wtracking->estimateId = $id;
            $wtracking->status = 6;
            $wtracking->note = 'Customer canceled the estimate / work Order';
            $wtracking->save();
        }

        $invoice = Invoice::where('estimateId', $id)->first();

        if ($invoice) {
            $invoice->status = 98;
            $invoice->save();
        }

        return back()->withErrors('Customer Canceled Job');
    }

    public function updateDate(Request $request, $id)
    {
        $estimate = Estimate::find($id);

        $estimate->dateofService = Carbon::parse($request->dateofService)->format('Y-m-d');
        $estimate->arrivalTime = $request->arrivalTime;
        $estimate->Save();

        $estimateStatus = new EstimateTracking();
        $estimateStatus->estimateId = $id;
        $estimateStatus->status = 4;
        $estimateStatus->note = 'Rescheduled and sent to work order.';
        $estimateStatus->save();

        $wo = WorkOrder::where('estimateId', $id)->first();

        //TODO Look to see if work order date needs updated

        if ($wo) {
            $wo->status = 1;
            $wo->save();

            $workOrderStatus = new WorkOrderTracking();
            $workOrderStatus->workOrderId = $wo->id;
            $workOrderStatus->status = 1;
            $workOrderStatus->note = 'Work order has been rescheduled.';
            $workOrderStatus->save();
        }

        return back()->with('success', 'Date of Service and time have been updated.');
    }

    public function rescheduleEmail($id)
    {
        $estimate = Estimate::find($id);

        Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new RescheduleReminder($estimate));

        if (Mail::failures()) {
            return back()->with('error', 'Mail was not delivered.');
        }

        return back()->with('success', 'Reminder mail was sent..');
        $tracking = new EstimateTracking();
        $tracking->estimateId = $id;
        $tracking->note = 'Reminder Email Sent.';
        $tracking->save();
    }

    public function estimateMakeWorkOrder($id)
    {
        $estimate = Estimate::find($id);
        $estimate->status = 4;
        $estimate->save();

        if ($estimate->workorder) {
            return redirect()->route('workorder.show', ['id' => $estimate->workorder->id])->with('success', 'The workorder already existed you are viewing it now.');
        }
        $wo = new WorkOrder();
        $wo->companyId = Auth()->user()->companyId;
        $wo->estimateId = $id;
        $wo->totalCharge = $estimate->total;
        $wo->status = 1;
        $wo->save();

        $tracking = new EstimateTracking();
        $tracking->estimateId = $id;
        $tracking->note = 'Estimate approved and work order created.';
        $tracking->save();

        $wtracking = new WorkOrderTracking();
        $wtracking->workOrderId = $wo->id;
        $wtracking->note = 'Estimate approved and work order created.';
        $wtracking->save();

        if ($estimate->approvedPackage) {
            $array = explode(',', $estimate->acceptedPackage->package->includes);
            $services = packageItem::whereIn('packageId', $array)->orWhere('packageId', $estimate->acceptedPackage->package->id)->get();

            foreach ($services as $service) {
                $estimateService = new WorkOrderServices();
                $estimateService->estimateId = $estimate->id;
                $estimateService->workOrderId = $wo->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $service->serviceId;
                $estimateService->listPrice = $service->desc->charge;
                $estimateService->chargedPrice = 0;
                $estimateService->status = 1;
                $estimateService->save();
            }
            $addons = AddOnService::where('packageId', $estimate->approvedPackage)->get();

            foreach ($addons as $row) {
                $estimateService = new WorkOrderServices();
                $estimateService->estimateId = $estimate->id;
                $estimateService->workOrderId = $wo->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $row->serviceId;
                $estimateService->listPrice = $row->service->charge;
                $estimateService->chargedPrice = $row->price;
                $estimateService->status = 1;
                $estimateService->save();
            }
        }

        //Check if invoice exists...

        $invoice = Invoice::where('estimateId', $id)->first();

        if (!$invoice) {
            $invoice = new Invoice();

            $invoice->companyId = Auth()->user()->companyId;
            $invoice->customerId = $wo->estimate->customerId;
            $invoice->estimateId = $wo->estimate->id;
            $invoice->workOrderId = $wo->id;
            $invoice->detailType = $wo->estimate->detailType;
            $invoice->dateofService = $wo->estimate->dateofService;
            $invoice->total = $wo->totalCharge;
            $invoice->deposit = $estimate->deposit;
            $invoice->status = 1;
            $invoice->save();
        }

        $wo->invoiceId = $invoice->id;
        $wo->save();

        $estimate->invoiceId = $invoice->id;
        $estimate->save();

        return redirect()->route('workorder.show', ['id' => $wo->id])->with('success', 'You have created a new work order.');
    }

    public function addPackageService(Request $request, $id)
    {
        $package = EstimatePackage::find($id);

        if ($request->serviceId == 0) {
            if ($request->discountType == 1) {
                //PERCENT DISCOUNT//
                $discountPercent = $request->discount / 100;
                $discountTotal = $request->price * $discountPercent;

                $chargedPrice = $request->price - $discountTotal;
            } elseif ($request->discountType == 2) {
                //CASH DISCOUNT//
                $chargedPrice = $request->price - $request->discount;
            } else {
                $chargedPrice = $request->price;
            }

            $addService = new AddOnService();
            $addService->packageId = $id;
            $addService->serviceid = $request->serviceId;
            $addService->price = $chargedPrice;
            $addService->show = $request->show;

            $addService->save();
        } else {
            $service = Services::find($request->serviceId);

            if ($request->discountType == 1) {
                //PERCENT DISCOUNT//
                $discountPercent = $request->discount / 100;
                $discountTotal = $service->charge * $discountPercent;

                $chargedPrice = $service->charge - $discountTotal;
            } elseif ($request->discountType == 2) {
                //CASH DISCOUNT//
                $chargedPrice = $service->charge - $request->discount;
            } else {
                $chargedPrice = $service->charge;
            }

            $addService = new AddOnService();
            $addService->packageId = $id;
            $addService->serviceid = $request->serviceId;
            $addService->price = $chargedPrice;
            $addService->show = $request->show;

            $addService->save();
        }

        $newPackagePrice = $package->chargedPrice + $chargedPrice;
        $newListPrice = $package->listPrice + $service->charge;

        $package->chargedPrice = $newPackagePrice;
        $package->listPrice = $newListPrice;
        $package->save();

        return back()->with('success', 'Added new service to package.');
    }

    public function pdf($id)
    {
        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo', 'vehicle.vehicleInfo.colorInfo', 'vehicle.vehicleInfo.condition')->find($id);
        $customer = Customer::find($estimate->customerId);

        $estimateTotal = 0;
        $downPmt = 0;
        if ($estimate->approvedPackage) {
            if ($estimate->packages) {
                foreach ($estimate->packages as $package) {
                    $estimateTotal = $estimateTotal + $package->chargedPrice;
                }
            }

            if ($estimate->services) {
                foreach ($estimate->services as $service) {
                    $estimateTotal = $estimateTotal + $service->chargedPrice;
                }
                foreach ($estimate->services->where('requiresDownPayment', 1) as $service) {
                    $downPmt = $downPmt + $service->chargedPrice;
                }
            }

            $estimate->total = $estimateTotal;
            $estimate->deposit = $downPmt;
            $estimate->save();
        }

        view()->share('customer', $customer);
        view()->share('estimate', $estimate);
        view()->share('estimateTotal', $estimateTotal);

        $pdf = PDF::loadView('estimate.pdf.estimate');

        //return $pdf->stream('estimate.pdf');

        return view('estimate.pdf.estimate', compact('customer', 'estimate', 'estimateTotal'));
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
        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo', 'vehicle.vehicleInfo.colorInfo', 'vehicle.vehicleInfo.condition')->find($id);
        $customer = Customer::find($estimate->customerId);
        $colors = VehicleColor::get();
        $conditions = VehicleCondition::get();

        if (Auth()->user()->companyId != $estimate->companyId) {
            return view('layouts.403');
        }

        $packages = Package::where('companyId', 0)->orWhere('companyId', Auth()->user()->companyId)->get();

        $estimateTotal = 0;
        $downPmt = 0;
        if ($estimate->approvedPackage) {
            if ($estimate->packages) {
                foreach ($estimate->packages as $package) {
                    $estimateTotal = $estimateTotal + $package->chargedPrice;
                }
            }

            if ($estimate->services) {
                foreach ($estimate->services as $service) {
                    $estimateTotal = $estimateTotal + $service->chargedPrice;
                }
                foreach ($estimate->services->where('requiresDownPayment', 1) as $service) {
                    $downPmt = $downPmt + $service->chargedPrice;
                }
            }

            $estimate->save();
        }
        $services = Services::where('company_id', 0)->orWhere('company_id', Auth()->user()->companyId)->get();

        return view('estimate.create', compact('packages', 'customer', 'estimate', 'estimateTotal', 'colors', 'conditions', 'services'));
    }

    public function customerReview($id, $code)
    {
        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo', 'vehicle.vehicleInfo.colorInfo', 'vehicle.vehicleInfo.condition')->find($id);

        $tracking = new EstimateTracking();
        $tracking->estimateId = $estimate->id;
        $tracking->note = 'Customer has viewed the estimate.';
        $tracking->save();

        return view('estimate.customerReview', compact('estimate'));
    }

    public function destroyPackage($id)
    {
        $package = EstimatePackage::find($id);
        $package->addOnService()->delete();
        $package->delete();

        return back()->with('success', 'Package removed from estimate.');
    }

    public function addVehicle(Request $request, $cid, $eid)
    {
        //dd($eid);
        if ($request->vehicleId == 0) {
            $customerVehicle = new CustomerVehicle();

            $customerVehicle->customerId = $cid;
            $customerVehicle->vin = $request->vin;
            $customerVehicle->year = $request->year;
            $customerVehicle->make = $request->make;
            $customerVehicle->model = $request->model;
            $customerVehicle->trim = $request->trim;
            $customerVehicle->style = $request->style;
            $customerVehicle->color = $request->color;
            $customerVehicle->customerCondition = $request->condition;
            $customerVehicle->save();

            $estimateVehicle = new EstimateVehicle();
            $estimateVehicle->estimateId = $eid;
            $estimateVehicle->customerVehicleId = $customerVehicle->id;
            $estimateVehicle->save();

            return back();
        }
        $estimateVehicle = new EstimateVehicle();
        $estimateVehicle->estimateId = $eid;
        $estimateVehicle->customerVehicleId = $request->vehicleId;
        $estimateVehicle->save();

        return back();
    }

    public function estimateRescheduleModal($id)
    {
        $estimate = Estimate::find($id);

        return view('dashboard.partials.modalUpdateEstimateBody', compact('estimate'));
    }

    public function voidEstimate($id)
    {
        $estimate = Estimate::find($id);
        $estimate->status = 8;
        $estimate->save();

        $etracking = new EstimateTracking();
        $etracking->estimateId = $id;
        $etracking->status = 8;
        $etracking->note = 'This estimate has been voided';
        $etracking->save();

        $workOrder = WorkOrder::where('estimateId', $id)->first();

        if ($workOrder) {
            $workOrder->status = 9;
            $workOrder->save();

            $wtracking = new EstimateTracking();
            $wtracking->estimateId = $id;
            $wtracking->status = 6;
            $wtracking->note = 'The estimate was voided.';
            $wtracking->save();
        }

        $invoice = Invoice::where('estimateId', $id)->first();

        if ($invoice) {
            $invoice->status = 98;
            $invoice->save();
        }

        return back()->with('success', 'Estimate Voided.');
    }

    public function upsaleRecommendationModal($id)
    {
        $packages = EstimatePackage::find($id);
        $estimate = EstimatePackage::where('id', $packages->estimateId)->first();
        //dd($packages);
        return view('estimate.partials.modalUpsaleRecommendationBody', compact('packages', 'estimate'));
    }

    public function clearSelectedPackage($id)
    {
        //Update the estimate back to an estimate.
        $estimate = Estimate::find($id);
        $estimate->approvedPackage = null;
        $estimate->status = 1;
        $estimate->save();

        //get the workorder and remove services then delete

        $wo = WorkOrder::where('estimateId', $id)->first();
        $wos = WorkOrderServices::where('workOrderId', $wo->id)->get();
        foreach ($wos as $row) {
            $row->delete();
        }
        $wo->delete();

        //Find and delete the invoice.
        $invoice = Invoice::where('estimateId', $id)->first();
        $invoice->delete();

        $etracking = new EstimateTracking();
        $etracking->estimateId = $id;
        $etracking->status = 1;
        $etracking->note = 'Removed approved package and returned to estimate.';
        $etracking->save();

        return back()->with('success', 'Selected package cleared.');
    }

    public function addWarrantyCode(Request $request, $id)
    {
        //Find and update estimate
        $estimate = Estimate::find($id);
        $estimate->warrantyCode = $request->warrantyCode;
        $estimate->save();

        $etracking = new EstimateTracking();
        $etracking->estimateId = $id;
        $etracking->note = 'Added warranty code.';
        $etracking->save();

        return back()->with('success', 'Warranty code has been added to the estimate.');
    }

    public function nextServiceEmail(): void
    {
        $date = Carbon::today()->subDays(30);
        $estimates = Estimate::whereNull('nextServiceEmail')->get();

        dd($estimates);
    }
}
