    <div class="card full-height">
        <div class="card-body py-0 px-0">
            <div class="row ">

                <div class="col-sm-7 col-xl-8">
                    <h4 class="mb-1 mb-sm-0">Customer Information</h4>
                    <p class="mb-0 font-weight-normal">
                        Estimate ID: {{$estimate->id ?? 'Unknown ID'}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Detail Service Type: @if($estimate->detilType == 1) Shop Detail @elseif($estimate->detailType == 2) Mobile Detail @endif
                    </p>

                    <p class="mb-0 font-weight-normal">
                        Service Date: @if($estimate->status == 7) <mark>{{\Carbon\Carbon::parse($estimate->dateofService)->format('m-d-Y')}}</mark>  <i class="fad fa-calendar-alt"></i> @else {{\Carbon\Carbon::parse($estimate->dateofService)->format('m-d-Y')}} @endif
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Arrival Window: @if($estimate->arrivalTime){{\Carbon\Carbon::parse($estimate->arrivalTime)->format('H:i')}} to {{\Carbon\Carbon::parse($estimate->arrivalTime)->addHours(3)->format('H:i')}}@else TBD @endif
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Name: {{$customer->firstName ?? 'Unknown Customer'}} {{$customer->lastName ?? ''}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Phone: {{$customer->phoneNumber ?? ''}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Email: {{$customer->email ?? ''}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Address: {{$customer->address ?? ''}}
                    </p>
                </div>

                <div class="col-xl-4 text-right">
                    <a href=";javascript" data-toggle="modal" data-target="#customerEditModal"><i class="fas fa-edit"></i></a>
                </div>
            </div>
        </div>
    </div>
