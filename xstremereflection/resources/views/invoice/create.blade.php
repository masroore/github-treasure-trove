@extends('layouts.default')

@section('page-title', __('New Invoice'))
@section('page-heading', __('New Invoice'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-6 grid-margin stretch-card">
            @include('estimate.partials.customer')
        </div>
        <div class="col-6 grid-margin stretch-card">
            @include('estimate.partials.serviceInfo')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('estimate.partials.charges')
        </div>
    </div>

    <!-- begin theme-panel -->
    <div class="theme-panel active">
        <a   class="theme-collapse-btn"> <span class="text-primary"><i class="fas fa-money-bill-alt "></i> </span> </a>
        <div class="theme-panel-content">
            <ul class="theme-list clearfix">
                <li class="active text-success"> <span class="display-4" id="subTotal"> $100.00  </span>&nbsp;</li>

            </ul>
        </div>
    </div>
    <!-- end theme-panel -->


@stop

@include('invoice.partials.itemModal')


@section('scripts')
<script>
    function listPriceUpdate() {
        var id = document.getElementById("packageId").value;

        $.get("/packageData/"+ id, function(data){
            var package = JSON.parse(data);

            document.getElementById('listPrice').innerHTML = package.cost;


        });
    }

    function discountUpdate() {
        var discount = document.getElementById("discount").value;
        var discountType = document.getElementById("discount").value;

        if(discountType = 1){
           var discountTotal = discount / 100;

           var newPrice = listPriceUpdate.cost - discountTotal;

            document.getElementById('packageTotals').innerHTML = newPrice;
        }else if(discountType = 2){

        }
    }
</script>


@stop
