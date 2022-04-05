@if($workOrder->estimate->detailType == 2)

    @if($workOrder->status == 1)
        <div class="row mb-4">
            <div class="col">
                <a href="/workorder/techenroute/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Tech Enroute</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>

    @elseif($workOrder->status == 2)
        <div class="row mb-4">
            <div class="col">
                <a href="/workrder/techarrive/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Tech Arrived</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>
    @elseif($workOrder->status == 3)
        <div class="row mb-4">
            <div class="col">
                <a href="/workrder/vehicleinspection/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Inspection</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>
    @elseif($workOrder->status == 4)
        <div class="row mb-4">
            <div class="col">
                <a href="/workrder/customerapproval/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Customer Approval</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>
    @elseif($workOrder->status == 5)
        <div class="row mb-4">
            <div class="col">
                <a href="/workrder/working/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Working</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>
    @elseif($workOrder->status == 6)
        <div class="row mb-4">
            <div class="col">
                <a href="/workrder/customerinspection/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Customer Inspection</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>
    @elseif($workOrder->status == 7)
        <div class="row mb-4">
            <div class="col">
                <a href="/workrder/invoice/{{$workOrder->id}}" ><button type="button" class="btn btn-primary" style="width: 100%">Update To Complete</button></a>
            </div>
            <div class="col">
                <button type="button"  class="btn btn-danger" style="width: 100%">Cancel</button>
            </div>
        </div>
    @elseif($workOrder->status == 8)
        <div class="row mb-4 text-center">
            <h2>Work Order Has Been Completed</h2>
        </div>
    @endif
@else


@endif
