<div class="card full-height">
    <div class="card-body py-0">

            @if($estimate->vehicle)
            <div class="row ">
                <div class="col-xl-12">
                    <h4 class="mb-1 mb-sm-0">Vehicle Information</h4>
                    <p class="mb-0 font-weight-normal d-none d-sm-block">
                        VIN Number: {!! $estimate->vehicle->vehicleInfo->vin ?? '<a data-toggle="modal" data-target="#vehicleModalUpdate"><i class="fad fa-sort-numeric-up-alt"></i></a>' !!}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Vehicle Year: {{$estimate->vehicle->vehicleInfo->year}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Vehicle Make: {{$estimate->vehicle->vehicleInfo->make}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Vehicle Model/Style: {{$estimate->vehicle->vehicleInfo->model}} - {{$estimate->vehicle->vehicleInfo->style}}
                    </p>
                    <p class="mb-0 font-weight-normal">
                        Vehicle Color: {{$estimate->vehicle->vehicleInfo->colorInfo->description ?? ''}}
                    </p>
                </div>
            </div>
            @else
                <div class="row">
                    <h4 class="mb-1 mb-sm-0">Vehicle Information</h4>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="button"  class="btn btn-primary" style="width: 100%" data-toggle="modal" data-target="#vehicleModal">Add New Vehicle</button>
                    </div>
                </div>

            @endif



    </div>
</div>
