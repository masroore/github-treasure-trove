<div class="col-xl-4 col-sm-12">
    <h2>Pending Jobs</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">

            <div class="list-group">

                @foreach($workorders->where('status', '<', 8) as $wo)
                    <a href="/workorder/{{$wo->id}}/show" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$wo->estimate->customer->firstName ?? 'Missing Customer Info'}} {{$wo->estimate->customer->lastName ?? 'Missing Customer Info'}} - {{$wo->estimate->customer->phoneNumber ?? 'Missing Contact Info'}}</h5>
                           
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{\Carbon\Carbon::parse($wo->estimate->dateofService)->format('m-d-Y')}}</h5>
                            <small>Arrival Time: {{\Carbon\Carbon::parse($wo->estimate->arrivalTime)->format('H:i')}} - {{\Carbon\Carbon::parse($wo->estimate->arrivalTime)->addHours(4)->format('H:i')}} </small>
                        </div>
                        <p class="mb-1">{{$wo->estimate->vehicle->vehicleInfo->year ?? ''}} {{$wo->estimate->vehicle->vehicleInfo->make ?? ''}} {{$wo->estimate->vehicle->vehicleInfo->model ?? ''}} {{$wo->estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}</p>
                        <small>Last Updated: {{\Carbon\Carbon::parse($wo->updated_at)->format('m-d-Y H:i')}}</small>
                        <small>Job Total: ${{$wo->totalCharge}}</small>
                    </a>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>

