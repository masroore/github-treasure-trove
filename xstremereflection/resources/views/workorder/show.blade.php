@extends('layouts.dashboard')

@section('page-title', __($workOrder->estimate->customer->lastName .' Work Order'))
@section('estimate-number', __('Estimate ID: '.$workOrder->estimate->eid))
@section('page-heading', __($workOrder->estimate->customer->lastName .' Work Order'))
@section('service-date',__('Service Date: ' .($workOrder->estimate->dateofService ? \Carbon\Carbon::parse($workOrder->estimate->dateofService)->format('m-d-Y') : 'Date to Be Determined' )))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')

    <div class="row mb-3">
        @include('workorder.partials.jobStats')
    </div>
    <div class="row">
        <div class="col-xl-9">
            <div class="row">
                <div class="col-xl-12">
                    @include('workorder.partials.statusButtons')
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-xl-12">
                    <a href="/workorder/completed/{{$workOrder->id}}" class="btn btn-success btn-block">Complete Work Order</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-sm--12 grid-margin stretch-card">
                    @include('workorder.partials.customer')
                </div>
                <div class="col-xl-6 col-sm--12 grid-margin stretch-card">
                    @include('workorder.partials.serviceInfo')
                </div>
            </div>
            <div class="row">
                @include('workorder.partials.services')
            </div>
        </div>

        <div class="col-xl-3">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header"><h3>Available Actions</h3></div>
                        <div class="card-body">
                            <div class="col-xl-12">
                                @include('workorder.partials.actionButtons')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    @include('invoice.partials.modalPayment')
    @include('workorder.partials.modalAddWaranty')
@stop
@include('workorder.partials.modalVehicleUpdate')


@section('scripts')
<script>
    function vinUpdate () {
        var vin = document.getElementById("vin").value;

        $.ajax({

            type: 'GET',

            url: '/vin-api/' + vin,

            success: function (data) {
                var vehicle = JSON.parse(data);
                $('#make').attr('value', vehicle.specification.make);
                $('#model').attr('value', vehicle.specification.model);
                $('#trim').attr('value', vehicle.specification.trim_level);
                $('#style').attr('value', vehicle.specification.style);
                $('#year').attr('value', vehicle.specification.year);

                var width = vehicle;

                console.log(width.replace(/[^0-9\.]+/g, ""));

            }

        });
    }

    $('input[name=service]').change(function (item) {
        var id = $(this).data('id');
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        // AJAX request
        $.ajax({
            url: '/workorder/serviceComplete/'+ id,
            type: 'get',
            success: function(response){

            }
        });
    });

    $("#paymentModal").on("shown.bs.modal", function(e) {
        var link = $(e.relatedTarget).data("link");

        // AJAX request
        $.ajax({
            url: link,
            type: 'get',
            success: function(response){
                // Add response in Modal body
                $('#payment').html(response);


            }
        });
    });


</script>
@stop
