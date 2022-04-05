<div class="col-xl-12 col-sm-12">
    <h2>Customer Leads</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">

            <div class="list-group">

                @foreach($estimates as $estimate)
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            @if($estimate->status == 7) <h4> Pending Estimates </h4> @endif
                            <h5 class="mb-1">{{$estimate->customer->firstName ?? 'Missing Customer Info'}} {{$estimate->customer->lastName ?? ''}}</h5>
                            <h6>Expires on: {{\Carbon\Carbon::parse($estimate->created_at)->addDays($estimate->days)->format('m-d-Y')}}</h6>
                            <button class="btn btn-primary" data-toggle="modal" data-link="/modal/estimateupdate/{{$estimate->id}}" data-target="#updateEstimateModal">
                                Update
                            </button>

                        </div>
                        <p class="mb-1">{{$estimate->vehicle->vehicleInfo->year ?? ''}} {{$estimate->vehicle->vehicleInfo->make ?? ''}} {{$estimate->vehicle->vehicleInfo->model ?? ''}} {{$estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}</p>
                        <small>Last Updated: {{\Carbon\Carbon::parse($estimate->updated_at)->format('m-d-Y H:i')}}</small>

                    </a>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
