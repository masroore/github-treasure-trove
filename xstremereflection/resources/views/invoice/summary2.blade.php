@extends('layouts.defaultNoNav')

@section('page-title', __('New Invoice'))
@section('page-heading', __('New Invoice'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')

    <div class="row align-items-center">
        <div class="col">
            <h6 class="page-pretitle">
                Payments
            </h6>
            <h4 class="page-title">Invoice #FDS9876KD</h4>
        </div>
        <div class="col-auto">
            <a href="#" class="btn btn-light btn-border">
                Download
            </a>
            <a href="#" class="btn btn-primary ml-2">
                Pay
            </a>
        </div>
    </div>

    <div class="page-divider"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-invoice">
                <div class="card-header">
                    <div class="invoice-header">
                        <h3 class="invoice-title">
                            Invoice
                        </h3>
                        <div class="invoice-logo">
                            <img src="{{$invoice->customer->company->logo}}" alt="company logo">
                        </div>
                    </div>
                    <div class="invoice-desc">
                        4663 State Route 784<br/>
                        South Shore Ky 41175<br />
                        (740) 821-5531
                    </div>
                </div>
                <div class="card-body">
                    <div class="separator-solid"></div>
                    <div class="row">
                        <div class="col-md-4 info-invoice">
                            <h5 class="sub">Date</h5>
                            <p>{{\Carbon\Carbon::parse($invoice->created_at)->format('M d, Y')}}</p>
                        </div>
                        <div class="col-md-4 info-invoice">
                            <h5 class="sub">Invoice ID</h5>
                            <p>#FDS9876KD</p>
                        </div>
                        <div class="col-md-4 info-invoice">
                            <h5 class="sub">Invoice To</h5>
                            <p>
                                {{$invoice->customer->firstName}} {{$invoice->customer->lastName}}<br/>
                                {{$invoice->customer->address}}
                            </p>
                        </div>
                    </div>
                    @if($invoice->estimate->vehicle)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-detail">
                                <div class="invoice-top">
                                    <h3 class="title"><strong>Vehicle Summary</strong></h3>
                                </div>
                                <div class="invoice-item">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <td class="text-center"><strong>VIN</strong></td>
                                                <td class="text-center"><strong>YEAR</strong></td>
                                                <td class="text-right"><strong>MAKE</strong></td>
                                                <td class="text-right"><strong>MODEL</strong></td>
                                                <td class="text-right"><strong>COLOR</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-center">{{$invoice->estimate->vehicle->vehicleInfo->vin ?? 'VIN not provided at time of estimate.'}}</td>
                                                <td class="text-center">{{$invoice->estimate->vehicle->vehicleInfo->year ?? ''}}</td>
                                                <td class="text-right">{{$invoice->estimate->vehicle->vehicleInfo->make ?? ''}}</td>
                                                <td class="text-right">{{$invoice->estimate->vehicle->vehicleInfo->model ?? ''}} - {{$invoice->estimate->vehicle->vehicleInfo->style ?? ''}}</td>
                                                <td class="text-right">{{$invoice->estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="separator-solid  mb-3"></div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-detail">
                                <div class="invoice-top">
                                    <h3 class="title"><strong>Invoiced Estimates Summary</strong></h3>
                                </div>
                                <div class="invoice-item">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <td class="text-center"><strong>Estimate ID</strong></td>
                                                <td class="text-center"><strong>List Price</strong></td>
                                                <td class="text-right"><strong>Total</strong></td>
                                                <td class="text-right"><strong>Deposit</strong></td>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{$invoice->estimate->id ?? ''}}</td>
                                                <td class="text-center">{{$invoice->estimate->listPrice ?? ''}}</td>
                                                <td class="text-center">{{$invoice->total ?? ''}}</td>
                                                <td class="text-right @if($invoice->totalPaid >= $invoice->deposit) bg-success @endif" >{{$invoice->deposit ?? ''}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="separator-solid  mb-3"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-detail">
                                <div class="invoice-top">
                                    <h3 class="title"><strong>Payment Summary</strong></h3>
                                </div>
                                <div class="invoice-item">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <td class="text-center"><strong>Payment Date</strong></td>
                                                <td class="text-center"><strong>Total Payment</strong></td>
                                                <td class="text-right"><strong>Balance</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $totalPaid = 0;
                                            $balance = $invoice->total;
                                            ?>
                                            @foreach($invoice->payments as $pmt)
                                            <tr>
                                                <td>{{number_format($pmt->pmtAmount, 2)}}</td>
                                                <td class="text-center"><?php
                                                    $totalPaid = $totalPaid + $pmt->pmtAmount;
                                                    ?>
                                                    {{number_format($totalPaid, 2)}}</td>
                                                <td class="text-center"><?php
                                                    $balance = $balance - $pmt->pmtAmount;
                                                    ?>
                                                    {{number_format($balance, 2)}}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="separator-solid  mb-3"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-7 col-md-5 mb-3 mb-md-0 transfer-to">

                            <div class="account-transfer">
                                <h5 class="sub">Total Invoice</h5>
                                <div class="price">${{number_format($invoice->total, 2)}}</div>

                            </div>
                        </div>
                        <div class="col-sm-5 col-md-7 transfer-total">
                            <h5 class="sub">Total Balance</h5>
                            <div class="price">${{number_format($balance, 2)}}</div>

                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <h6 class="text-uppercase mt-4 mb-3 fw-bold">
                        Notes
                    </h6>
                    <p class="text-muted mb-0">
                        We really appreciate your business and if there's anything else we can do, please let us know! Also, should you need us to add VAT or anything else to this order, it's super easy since this is a template, so just ask!
                    </p>
                </div>
            </div>
        </div>

@stop


@section('scripts')


@stop
