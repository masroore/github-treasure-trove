<div class="card full-height">
    <div class="card-body">
        <div class="row ">

            <div class="col-sm-7 col-xl-8">
                <h4 class="mb-1 mb-sm-0">Customer Information</h4>
                <p class="mb-0 font-weight-normal ">
                    Work Order ID: {{$workOrder->estimate->id ?? 'Unknown ID'}}
                </p>
                <p class="mb-0 font-weight-normal ">
                    Detail Service Type: @if($workOrder->estimate->detilType == 1) Shop Detail @elseif($workOrder->estimate->detailType == 2) Mobile Detail @endif
                </p>

                <p class="mb-0 font-weight-normal ">
                    Service Date: {{\Carbon\Carbon::parse($workOrder->estimate->dateofService)->format('m-d-Y')}}
                </p>
                <p class="mb-0 font-weight-normal ">
                    Arrival Window: @if($workOrder->estimate->arrivalTime){{\Carbon\Carbon::parse($workOrder->estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($workOrder->estimate->arrivalTime)->addHours(3)->format('H:i')}}@else TBD @endif
                </p>
                <p class="mb-0 font-weight-normal ">
                    Name: {{$workOrder->estimate->customer->firstName ?? 'Unknown Customer'}} {{$workOrder->estimate->customer->lastName ?? ''}}
                </p>
                <p class="mb-0 font-weight-normal ">
                    Phone: {{$workOrder->estimate->customer->phoneNumber ?? ''}}
                </p>
                <p class="mb-0 font-weight-normal ">
                    Email: {{$workOrder->estimate->customer->email ?? ''}}
                </p>
                <p class="mb-0 font-weight-normal ">
                    Address: {{$workOrder->estimate->customer->address ?? ''}}
                </p>
            </div>

            <div class="col-xl-4 text-right">
                <a href=";javascript" data-toggle="modal" data-target="#customerModal"><i class="fas fa-edit"></i></a>
            </div>
        </div>
    </div>
</div>
