<div class="col-xl-12 col-sm-12">
    <h2>Unpaid Invoices</h2>
    <div class="card">
        <div class="card-body py-0 px-0 px-sm-3">

            <div class="list-group">

                @foreach($invoices as $row)
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">

                            <h5 class="mb-1">{{$row->estimate->customer->firstName ?? 'Missing Customer Info'}} {{$row->estimate->customer->lastName ?? ''}}</h5>

                            <a class="btn btn-primary" href="/invoice/{{$row->id ?? ''}}">View Invoice</a>

                        </div>
                        <p class="mb-1">{{$row->estimate->vehicle->vehicleInfo->year ?? ''}} {{$row->estimate->vehicle->vehicleInfo->make ?? ''}} {{$row->estimate->vehicle->vehicleInfo->model ?? ''}} {{$row->estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}</p>
                        <small>Last Updated: {{\Carbon\Carbon::parse($row->updated_at)->format('m-d-Y H:i')}}</small>

                    </a>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
