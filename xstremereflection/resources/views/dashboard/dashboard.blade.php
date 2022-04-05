@extends('layouts.dashboard')

@section('page-title', __('Dashboard'))
@section('page-heading', __('Dashboard'))

@section('styles')
<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@stop


@section('content')
    @include('partials.messages')

    <div class="page-inner mt--5">
        @include('dashboard.partials.overallStats')

            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Total income & spend statistics</div>
                        <div class="row py-3">
                            <div class="col-md-4 d-flex flex-column justify-content-around">
                                <div>
                                    <h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
                                    <h3 class="fw-bold">${{number_format($invoiceTotal)}}</h3>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-uppercase text-danger op-8">Total Outstanding</h6>
                                    <h3 class="fw-bold">${{number_format($invoiceOutstanding)}}</h3>
                                </div>
                            </div>
                            <div class="col-md-8" >
                                <div id="chart-container">
                                    <div class="pull-in">
                                       <div id="chart" style="height: 200px;"> {!! $chart->container() !!} </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @include('dashboard.partials.estimateHistory')
            @include('dashboard.partials.estimates')
        </div>

@stop

@section('modals')
    @include('estimate.partials.modalLeads')
    @include('estimate.partials.modalEstimates')
    @include('estimate.partials.modalWorkOrders')
    @include('estimate.partials.modalInvoice')
    @include('dashboard.partials.modalUpdateEstimate')
    @include('dashboard.partials.modalUpdateWorkOrder')
@stop

@section('scripts')
    <script>
        Circles.create({
            id:'circles-1',
            radius:45,
            value:{{$leads}},
            maxValue:10,
            width:7,
            text: {{$leads}},
            colors:['#f1f1f1', '#000034'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })

        Circles.create({
            id:'circles-2',
            radius:45,
            value:{{$estimate ?? 0}},
            maxValue:10,
            width:7,
            text: {{$estimate ?? 0}},
            colors:['#f1f1f1', '#2BB930'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })

        Circles.create({
            id:'circles-3',
            radius:45,
            value:{{$workorder ?? 0}},
            maxValue:5,
            width:7,
            text: {{$workorder ?? 0}},
            colors:['#f1f1f1', '#ff6700'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })

        Circles.create({
            id:'circles-4',
            radius:45,
            value:{{$unpaidInvoices ?? 0}},
            maxValue:5,
            width:7,
            text: {{$unpaidInvoices ?? 0}},
            colors:['#f1f1f1', '#F25961'],
            duration:400,
            wrpClass:'circles-wrp',
            textClass:'circles-text',
            styleWrapper:true,
            styleText:true
        })



        $('#lineChart').sparkline([105,103,123,100,95,105,115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });
        @if(1 == 1)
        //Notify
        $.notify({
            icon: 'flaticon-alarm-1',
            title: 'Free Schedule',
            message: 'You have no work scheduled for today',
        },{
            type: 'success',
            placement: {
                from: "bottom",
                align: "right"
            },
            time: 5000,
        });
        @endif
    </script>

    <script>
        $("#updateEstimateModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function(response){
                    // Add response in Modal body
                    $('#updateEstimateModal .modal-body').html(response);

                    $('#datepicker-popup-1').datepicker({
                        todayHighlight: true,
                    });

                    $( "#newDateForm" ).hide();

                    function showForm() {

                        $( "#newDateForm" ).show();
                    }
                }
            });
        });

        $("#updateWorkOrderModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: link,
                type: 'get',
                success: function(response){
                    // Add response in Modal body
                    $('#updateWorkOrderModal .modal-body').html(response);

                    $('#datepicker-popup-1').datepicker({
                        todayHighlight: true,
                    });

                    $( "#newDateForm" ).hide();

                    function showForm() {

                        $( "#newDateForm" ).show();
                    }
                }
            });
        });

        $("#leadsModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: '/company/leads',
                type: 'get',
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
                success: function(response){
                    // Add response in Modal body
                    $('#leadsModal .modal-body').html(response);
                },
                complete: function () {
                    $("#loader").hide();
                }
            });
        });

        $("#estimatesModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: '/company/estimates',
                type: 'get',
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
                success: function(response){
                    // Add response in Modal body
                    $('#estimatesModal .modal-body').html(response);
                },
                complete: function () {
                    $("#loader").hide();
                }
            });
        });

        $("#workorderModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: '/company/workorders',
                type: 'get',
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
                success: function(response){
                    // Add response in Modal body
                    $('#workorderModal .modal-body').html(response);
                },
                complete: function () {
                    $("#loader").hide();
                }
            });
        });

        $("#invoiceModal").on("shown.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");

            // AJAX request
            $.ajax({
                url: '/company/invoices',
                type: 'get',
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
                success: function(response){
                    // Add response in Modal body
                    $('#invoiceModal .modal-body').html(response);
                },
                complete: function () {
                    $("#loader").hide();
                }
            });
        });

        function showForm() {

            $( "#newDateForm" ).show();
        }

    </script>

    {!! $chart->script() !!}
@stop
