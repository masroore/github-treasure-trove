@extends('layouts.dashboard')

@section('page-title', __('Customer Estimate'))
@section('customer-info', __($customer->firstName.' '.$customer->lastName))
@section('estimate-number', __('Estimate ID: '.$estimate->eid))
@section('page-heading', __('New Invoice'))
@section('ceramic', __(($estimate->ceramic ? 'Ceramic Install' : '')))
@if($estimate->status == 4)
    @section('back-ground', __('bg-dark-gradient'))
@elseif($estimate->status >= 5 && $estimate->status <= 8)
    @section('back-ground', __('bg-danger-gradient'))
@elseif($estimate->status == 0)
    @section('back-ground', __('bg-warning-gradient'))
@else
    @section('back-ground', __('bg-primary-gradient'))
@endif

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('style')

    <style>

        @import url(https://fonts.googleapis.com/css?family=Roboto:300,400);

        body {
            height: 100%;
            padding: 0px;
            margin: 0px;
            background: #333;
            font-family: 'Roboto', sans-serif !important;
            font-size: 1em;
        }

        h1 {
            font-family: 'Roboto', sans-serif;
            font-size: 30px;
            color: #999;
            font-weight: 300;
            margin-bottom: 55px;
            margin-top: 45px;
            text-transform: uppercase;
        }

        h1 small {
            display: block;
            font-size: 18px;
            text-transform: none;
            letter-spacing: 1.5px;
            margin-top: 12px;
        }

        .row {
            max-width: 950px;
            margin: 0 auto;
        }

        .btn {
            white-space: normal;
        }

        .button-wrap {
            position: relative;
            text-align: center;

        .btn {
            font-family: 'Roboto', sans-serif;
            box-shadow: 0 0 15px 5px rgba(0, 0, 0, 0.5);
            border-radius: 0px;
            border-color: #222;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 1.1em;
            font-weight: 400;
            letter-spacing: 1px;

        small {
            font-size: 0.8rem;
            letter-spacing: normal;
            text-transform: none;
        }

        }
        }


        /** SPINNER CREATION **/

        .loader {
            position: relative;
            text-align: center;
            margin: 15px auto 35px auto;
            z-index: 9999;
            display: block;
            width: 80px;
            height: 80px;
            border: 10px solid rgba(0, 0, 0, .3);
            border-radius: 50%;
            border-top-color: #000;
            animation: spin 1s ease-in-out infinite;
            -webkit-animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }


        /** MODAL STYLING **/

        .modal-content {
            border-radius: 0px;
            box-shadow: 0 0 20px 8px rgba(0, 0, 0, 0.7);
        }

        .modal-backdrop.show {
            opacity: 0.75;
        }

        .loader-txt {

        p {
            font-size: 13px;
            color: #666;

        small {
            font-size: 11.5px;
            color: #999;
        }

        }
        }

        #output {
            padding: 25px 15px;
            background: #222;
            border: 1px solid #222;
            max-width: 350px;
            margin: 35px auto;
            font-family: 'Roboto', sans-serif !important;

        p.subtle {
            color: #555;
            font-style: italic;
            font-family: 'Roboto', sans-serif !important;
        }

        h4 {
            font-weight: 300 !important;
            font-size: 1.1em;
            font-family: 'Roboto', sans-serif !important;
        }

        p {
            font-family: 'Roboto', sans-serif !important;
            font-size: 0.9em;

        b {
            text-transform: uppercase;
            text-decoration: underline;
        }

        }
        }
    </style>

@stop

@section('content')

    @if($estimate->status == 8)
        <div class="row mb-4">
            <div class="col">
                <a href="/estimate/restore/{{$estimate->id}}">
                    <button type="button" class="btn btn-danger" style="width: 100%">Restore</button>
                </a>
            </div>
        </div>
    @elseif($estimate->status != 4)
        <div class="row mb-4">
            @if($estimate->customer->email)
                <div class="col">
                    <a href="/estimate/mail/{{$estimate->id}}">
                        <button type="button" class="btn btn-primary" style="width: 100%">Send Email for Approval
                        </button>
                    </a>
                </div>
            @endif
            @if($estimate->customer->phoneNumber)
                <div class="col">
                    <a href="#">
                        <button type="button" class="btn btn-primary" style="width: 100%" disabled>Send Text for
                            Approval
                        </button>
                    </a>
                </div>
            @endif
            @if($estimate->approvedPackage)
                <div class="col">
                    @if($estimate->workorder)
                        <a href="/workorder/{{$estimate->workorder->id}}/show">
                            <button type="button" class="btn btn-success" style="width: 100%">View The Work Order
                            </button>
                        </a>

                    @else
                        <a href="/estimate/workOrder/{{$estimate->id}}">
                            <button type="button" class="btn btn-primary" style="width: 100%">Convert to Work Order
                            </button>
                        </a>

                    @endif
                </div>
            @endif
            <div class="col">

                    <button type="button" class="btn btn-danger" style="width: 100%" onclick="voidEstimate()">Void</button>

            </div>
        </div>
    @elseif($estimate->status == 4 && $estimate->workorder->status != 8)
        <div class="row mb-3">
            <div class="col">
                <a href="/estimate/clearselectedpackage/{{$estimate->id}}">
                    <button type="button" class="btn btn-primary" style="width: 100%">Allow Edit of Accepted Package
                    </button>
                </a>
            </div>
            <div class="col">
                <a href="/estimate/void/{{$estimate->id}}">
                    <button type="button" class="btn btn-danger" style="width: 100%">Void</button>
                </a>
            </div>
        </div>


    @endif

    <div class="row mb-3">
        <div class="col">
            <div class="dropdown">
                <button class="btn btn-primary btn-block dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/estimate/{{$estimate->id}}/pdf">PDF Estimate Customer Copy</a>
                    <a class="dropdown-item" href="/upsale/{{$estimate->id}}/pdf">PDF Upsale Detailer Copy</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xl-9">
            <div class="row">
                <div class="col-sm-12 col-xl-6">
                    @include('estimate.partials.customer')
                </div>
                <div class="col-sm-12 col-xl-6">
                    @include('estimate.partials.serviceInfo')
                </div>
            </div>

            <div class="row">
                @include('estimate.partials.problem')
            </div>

            <div class="row">
                <div class="col-xl-12">
                    @include('estimate.partials.charges')
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-3">
            <div class="row">
                <div class="col-xl-12">
                    @include('estimate.partials.totals')
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    @include('estimate.partials.notes')
                </div>
            </div>
        </div>
    </div>


    <!--
    <!-- begin theme-panel ->
    <div class="theme-panel active">
        <a   class="theme-collapse-btn"> <span class="text-primary"><i class="fas fa-money-bill-alt "></i> </span> </a>
        <div class="theme-panel-content">
            <ul class="theme-list clearfix">
                <li class="active text-danger"> <span class="display-4" id="subTotal">$ {{ number_format($estimate->total, 2, '.', '') ?? '0.00'}} </span>&nbsp;</li>

            </ul>
        </div>
    </div>
    -->

@stop

@include('invoice.partials.itemModal')
@include('invoice.partials.vehicleModal')
@include('estimate.partials.modalServices')
@include('estimate.partials.modalAddService')
@include('estimate.partials.modalNote')
@include('estimate.partials.updatePackageModal')
@include('estimate.partials.modalCustomerEdit')
@include('estimate.partials.modalVehicleUpdate')
@include('estimate.partials.modalUpsaleRecommendations')


@section('scripts')

    <script>
        $('#customerEditModal').on('shown.bs.modal', function () {

            $('#datepicker-popup').datepicker({
                todayHighlight: true,
            });


            $('#customerForm').load('/customer/edit/form/{{$estimate->id}}', function () {
                $("#newCustomer").hide();

                $('.select').select2({
                    dropdownParent: $('#customerModal .modal-content'),
                    theme: "bootstrap"
                });
            });
        });
    </script>

    <script>
        $('#summernote').summernote({
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            tabsize: 2,
            height: 50
        });
    </script>

    <script>

        function listPriceUpdate() {
            var id = document.getElementById("packageId").value;

            $.get("/packageData/" + id, function (data) {
                var package = JSON.parse(data);

                document.getElementById('listPrice').innerHTML = package.cost;


            });
        }

        function discountUpdate() {
            var discount = document.getElementById("discount").value;
            var discountType = document.getElementById("discount").value;

            if (discountType = 1) {
                var discountTotal = discount / 100;

                var newPrice = listPriceUpdate.cost - discountTotal;

                document.getElementById('packageTotals').innerHTML = newPrice;
            } else if (discountType = 2) {

            }
        }

        $('#vehicleModal').on('shown.bs.modal', function () {

            $("#new").hide();

        });

        function vehicleUpdate() {
            var vehicleId = document.getElementById("vehicleId").value;

            if (vehicleId == 0) {

                $("#new").show();
                $("#addCustomerVehicle").hide();
            } else {
                console.log('Existing Customer')
                $("#new").hide();
                $("#addCustomerVehicle").show();
            }

        }

        function vinUpdate() {
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
    </script>

    <script>
        $("#servicesModal").on("shown.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function (response) {
                    // Add response in Modal body
                    $('#services').html(response);


                }
            });
        });

        function vinUpdate() {
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

        $("#updatePackageModal").on("shown.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function (response) {
                    // Add response in Modal body
                    $('#updatePackage').html(response);


                }
            });
        });

        $("#upsaleRecommendationModal").on("shown.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function (response) {
                    // Add response in Modal body
                    $('#upsaleRecommendation').html(response);


                }
            });
        });

        $("#addServicesModal").on("shown.bs.modal", function (e) {
            var id = $(e.relatedTarget).data("id");
            $("#addCustomServiceForm").hide();
            $('#serviceForm').attr('action', '/estimate/package/addservice/' + id);

        });

        function serviceUpdate() {
            var serviceType = document.getElementById("serviceId").value;
            console.log(serviceType);
            if (serviceType == 0) {

                $("#addCustomServiceForm").show();
            } else {
                $("#addCustomServiceForm").hide();

            }
        }

        function selectedPackage(e) {
            var id = $("input[name='package']:checked").val();

            Swal.fire({
                title: '<strong>Confirm Selection</strong>',
                icon: 'warning',
                html:
                    'You have selected to approve a package for the customer. By doing this you will create a new work order and invoice. Are you sure you would like to proceed?',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Proceed!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText:
                    '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
// AJAX request
                        $.ajax({
                            url: '/estimate/selectpackage/{{$estimate->id}}/' + id,
                            type: 'get',
                            success: function (response) {
                                Swal.fire('Saved!', '', 'success')
                            }
                        });

                    }else if(result.dismiss === Swal.DismissReason.cancel){

                        Swal.fire({
                            title: 'Nothing Accepted',
                            text: "No changes have been made and package was deselected.",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok!'
                        }).then((result) => {
                            if(result.isConfirmed){
                                window.location.reload(true);
                            }
                            }

                        )
                    }
                }
            )
        }

        function voidEstimate(e) {
            Swal.fire({
                title: '<strong>Confirm Selection</strong>',
                icon: 'error',
                html:
                    'You have selected to void this estimate are you sure this is what you want to do?',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Proceed!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText:
                    '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
// AJAX request
                        $.ajax({
                            url: '/estimate/void/{{$estimate->id}}',
                            type: 'get',
                            success: function (response) {
                                Swal.fire('Saved!', '', 'success')
                                window.location.reload(true);
                            }
                        });

                    }else if(result.dismiss === Swal.DismissReason.cancel){


                    }
                }
            )
        }


        $("#servicesModal").on("hidden.bs.modal", function () {
            $("#servicesModal .modal-body").html("<div class=\"d-flex justify-content-center\" id=\"servicesSpinner\">\n" +
                "                    <div class=\"spinner-border text-warning\" style=\"width: 6rem; height: 6rem;\" role=\"status\">\n" +
                "                        <span class=\"sr-only text-center\">Loading...</span>\n" +
                "                    </div>\n" +
                "                </div>");
        });
    </script>




@stop
