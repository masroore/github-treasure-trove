@extends('layouts.loggedOut')

@section('page-title', __('Customer Estimate'))
@section('customer-info', __($estimate->customer->firstName.' '.$estimate->customer->lastName))
@section('estimate-number', __('Estimate ID: '.$estimate->eid))
@section('page-heading', __('New Invoice'))

@section('styles')

@stop

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-xl-12 text-center">
            <img src="/assets/img/logo1.png" alt="logo"  height="125px" width="300px"/>
        </div>
    </div>

    <div class="row p-10 mb-3">
        <div class="col-xl-12">
            {{$estimate->customer->firstName ?? '' }} {{$estimate->customer->lastName ?? ''}} I would like to thank you for contacting Xtreme Reflection for the perfection of your @if($estimate->vehicle) {{$estimate->vehicle->vehicleInfo->colorInfo->description}} {{$estimate->vehicle->vehicleInfo->year ?? ''}} {{$estimate->vehicle->vehicleInfo->make ?? ''}} {{$estimate->vehicle->vehicleInfo->model ?? ''}}@else vehicle  @endif.
            We have slated our schedule for {{ \Carbon\Carbon::parse($estimate->dateofService)->format('m/d/Y') ?? '' }} arrival time @if($estimate->arrivalTime){{\Carbon\Carbon::parse($estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($estimate->arrivalTime)->addHours(3)->format('H:i')}}@else to be determined @endif and plan to give your vehicle the care you expect.
            Please review the packages below and select the package that best fits your needs.
        </div>
    </div>

    <div class="row">

        <div class="col-xl-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Description</th>
                        <th>List</th>
                        <th>Charged</th>
                        <th>Deposit</th>
                        <th>Available Addons</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($estimate->packages as $packages)
                        <tr>

                            <td style="width: 30%">
                                <h6>{{$packages->package->description}}</h6>
                                <div class="col-xl-12">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            @if($packages->package->includes)
                                            @php
                                                $array = explode(',', $packages->package->includes);
                                               $packageItems = \Vanguard\packageItem::whereIn('packageId', $array)->get();
                                            @endphp
                                            <small>

                                                    @foreach($packageItems as $item)

                                                       <span class="badge badge-primary">{{$item->desc->description}}</span>
                                                    @endforeach

                                                @endif</small>

                                                @php
                                                     $packageItems = \Vanguard\packageItem::where('packageId', $packages->package->id)->get();
                                                @endphp
                                                <small>
                                                    @if($packageItems)
                                                        @foreach($packageItems as $item)

                                                            <span class="badge badge-success" >{{$item->desc->description}}</span>
                                                        @endforeach

                                                    @endif</small>

                                        </div>
                                    </div>
                                    @if($packages->addOnService)
                                        <table class="table table-sm">
                                            <tr>
                                                <th><h6>Add on Services</h6></th>
                                            </tr>
                                            @foreach($packages->addOnService as $aos)
                                                <tr>
                                                    <td>
                                                        @if($aos->serviceId == 0) {{$aos->description ?? ''}}  @else {{$aos->service->description  }} @endif - <small>List Price: ${{$aos->service->charge ?? '0.00'}}  Charged: {{$aos->price ?? '0.00'}} </small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>
                            </td>
                            <td>${{$packages->listPrice ?? ''}}</td>
                            <td>${{$packages->chargedPrice ?? ''}}</td>
                            <td>${{$packages->deposit ?? ''}}</td>
                            <td style="width: 50%">
                                <?php
                                $array = explode(',', $packages->package->upsale);
                                $addons = \Vanguard\Services::whereIn('id', $array)->get();
                                ?>
                                <ul class="list-group">
                                    @foreach($addons as $row)

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <!--
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="service" value="{{$row->id}}" class="form-check-input" data-id="{{$row->id}}" data-packageid="{{$packages->id}}" >
                                            </div>
                                            -->
                                            {{$row->description}}
                                            <span class="badge badge-primary">+ ${{$row->charge}}</span>
                                        </li>

                                    @endforeach
                                </ul>


                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><a href="/customerSignatureBody/{{$packages->id}}/{{$estimate->id}}"><button class="btn btn-success btn-block">Approve Package # {{$loop->iteration}}</button></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('estimate.partials.modalCustomerSignature')

@stop

@section('scripts')

    <script>
        $("#customerSignatureModal").on("show.bs.modal", function(e) {
            // AJAX request
            $.ajax({
                url: '/estimate/customerSignatureBody',
                type: 'get',
                success: function(response){
                    // Add response in Modal body
                    $('#customerApproval').html(response);


                }
            });
        });
    </script>

    <script>
        $('input[name=service]').change(function (item) {
            var id = $(this).data('id');
            var packageid = $(this).data('packageid');
            console.log(packageid);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            // AJAX request
            /*
            $.ajax({
                url: '/workorder/serviceComplete/'+ id,
                type: 'get',
                success: function(response){

                }
            });
             */
        });
    </script>
@stop
