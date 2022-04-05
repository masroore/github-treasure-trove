<div class="row mb-2">
    <a href="/workorder/addServices/{{$workOrder->id}}" class="btn btn-primary btn-block">Add Services From Package</a>
</div>

<div class="row mb-2">
    <a class="btn btn-warning btn-block" href="/estimate/{{$workOrder->estimate->id}}/pdf">PDF Estimate Customer Copy</a>
</div>

<div class="row mb-2">
    <a class="btn btn-warning btn-block" href="/upsale/{{$workOrder->estimate->id}}/pdf">PDF Upsale Detailer Copy</a>
</div>

<div class="row mb-2">
    <a class="btn btn-info btn-block" href="/invoice/{{$workOrder->invoiceId}}">View Invoice</a>
</div>

<div class="row mb-2">
    <a class="btn btn-success btn-block" data-toggle="modal"
       data-target="#warrantyModal" >Add Warranty Code</a>
</div>

@if($workOrder->invoiceId)
    <div class="row mb-2">
        <a class="btn btn-success btn-block" data-toggle="modal" data-link="/invoice/{{$workOrder->invoiceId}}/paymentModal"
           data-target="#paymentModal" >Add Payment</a>
    </div>
@else
    <div class="row mb-2">
        <a class="btn btn-danger btn-block" href="/invoice/{{$workOrder->id}}/create"  >Create Invoice</a>
    </div>
@endif


