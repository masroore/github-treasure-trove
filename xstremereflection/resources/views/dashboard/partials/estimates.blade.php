<div class="col-md-6">
    <div class="card full-height">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">Estimates</div>
                <div class="card-tools">
                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach($estimates->whereIn('status', [0, 1, 7]) as $estimate)
                <div class="d-flex">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-info"> {{substr($estimate->customer->firstName, 0, 1)}}{{substr($estimate->customer->lastName, 0, 1)}} </span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">{{$estimate->customer->firstName}} {{$estimate->customer->lastName}} @if($estimate->status == 0) <span class="text-warning pl-3">Sales Lead</span>  @elseif($estimate->status == 7) <span class="text-danger pl-3">Needs Rescheduled</span> @elseif($estimate->approvedPackage) <span class="text-success pl-3">Customer Approved</span> @else <span class="text-info pl-3">Estimate</span> @endif </h6>
                        @if($estimate->customer->phoneNumber) <a href="tel:{{ substr($estimate->customer->phoneNumber, 0, 3).'-'.substr($estimate->customer->phoneNumber, 3, 3).'-'.substr($estimate->customer->phoneNumber,6)  }}">  <span class="text-muted">  {{ '('.substr($estimate->customer->phoneNumber, 0, 3).') '.substr($estimate->customer->phoneNumber, 3, 3).'-'.substr($estimate->customer->phoneNumber,6)  }} </span> </a> @else <span class="text-muted"> No Phone Number Available</span> @endif <br />
                        <span class="text-muted"> {{$estimate->vehicle->vehicleInfo->year ?? ''}} {{$estimate->vehicle->vehicleInfo->make ?? ''}} {{$estimate->vehicle->vehicleInfo->model ?? ''}}</span>
                    </div>
                    <div class="float-right pt-1">
                        <small class="text-muted">{{\Carbon\Carbon::parse($estimate->updated_at)->format('M d h:i A')}}</small>
                    </div>
                </div>
                <div class="separator-dashed"></div>
            @endforeach

        </div>
    </div>
</div>
