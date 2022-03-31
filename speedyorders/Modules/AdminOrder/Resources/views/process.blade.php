@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<style type="text/css">
    #wrapper{
        min-height: 1100px !important;
    }
</style>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order Details</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Order ID</span>
                                    </td>
                                    <td>{{ $order->uuid }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Order Received</span>
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Payment Method</span>
                                    </td>
                                    <td>{{ $order->payment_method }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Comment</span>
                                    </td>
                                    <td>{{ $order->comment }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Customer Details</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Full Name</span>
                                    </td>
                                    <td>{{ $order->first_name.' '.$order->last_name }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Address</span>
                                    </td>
                                    <td>{{ $order->address_1 }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Email</span>
                                    </td>
                                    <td>{{ $order->email }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Phone</span>
                                    </td>
                                    <td>{{ $order->phone }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-bordered">
                              <thead>
                                 <tr>
                                    <td style="width:5%;"><b>Product ID</b></td>
                                    <td style="width:10%;"><b>Product</b></td>                                    
                                    <td style="width:7%;" class="text-right"><b>Quantity</b></td>
                                    <td style="width:7%;" class="text-right"><b>Unit Price</b></td>
                                    <td style="width:10%;" class="text-right"><b>Total</b></td>
                                    <td style="width:5%;"><b>Single</b></td>
                                     <td style="width:5%;"><b>Combo</b></td> 
                                     <td style="width:20%;"><b>Package</b></td>
                                    <td style="width:20%;"><b>Delivery Time</b></td>
                                 </tr>
                              </thead>
                              <tbody>
                                   <?php

                                     $subTotal = 0;
                                     $totalTax=0;
                                     $totalShipping=0;

                                     // define all the selected fields
                                     $productIds = [];
                                     $productNames = [];
                                     $productUnitPrices = [];
                                     $productQuantities = [];
                                     $productTotals = [];
                                     $productSingle = [];
                                     $productCombos = [];
                                     ?>

                                  @forelse($order->orderedProducts as $orderedProduct)
                                  <?php

                                        $productDeliveryTimePackage = '';
                                        $deliveryTimes = [];

                                        $productDeliveryTimedata = App\Models\ProductDeliveryTime::where('products_id',$orderedProduct->product->id)->get();

                                        if(!empty($productDeliveryTimedata)){
                                            foreach($productDeliveryTimedata as $timeData){
                                                $productDeliveryTimePackage = $timeData->shipping_packages_id;
                                                $productDeliveryTimeGroup = $timeData->shipping_zone_groups_id;

                                                array_push($deliveryTimes, $timeData->shipping_delivery_times_id);
                                            }
                                        }


                                      

                                       $individualTotal = $orderedProduct->quantity*$orderedProduct->price;
                                       $subTotal += $individualTotal;
                                       $totalTax += $orderedProduct->tax;
                                       $totalShipping += $orderedProduct->shipping_price;

                                       $productIds[] = $orderedProduct->product->id;
                                       $productNames[] = $orderedProduct->product->name;                                       
                                       $productUnitPrices[] = $orderedProduct->price;    
                                       $productQuantities[] = $orderedProduct->quantity;
                                       $productTotals[] = $individualTotal;

                                       
                                       

                                   ?>
                                 <tr>
                                    <td>{{ $orderedProduct->product->id }}</td>
                                    <td>
                                       {{ $orderedProduct->product->name }}

                                       @if(count($orderedProduct->orderProductOptions)>0)
                                            <p><b>Variant</b></p>
                                            @foreach($orderedProduct->orderProductOptions ??[] as $orderProductOption)

                                                @php
                                                    //print_R($orderProductOption->productOption);
                                                @endphp

                                                @if(isset($orderProductOption->productOption))
                                                    <p>[{{$orderProductOption->productOption->option->name }} : {{($orderProductOption->productOption->option->type == "select" && isset($orderProductOption->productOptionValue->optionValue->name)) ? $orderProductOption->productOptionValue->optionValue->name:$orderProductOption->value}} ]</p>
                                                @endif
                                            @endforeach
                                       @endif
                                    </td>                                  
                                    <td class="text-right">{{ $orderedProduct->quantity }}</td>
                                    <td class="text-right">${{ $orderedProduct->price }}</td>
                                    <td class="text-right">${{ $individualTotal }}</td>
                                    <td>
                                        <input type="checkbox" onclick="getProductPackages('{{$orderedProduct->product->id}}', '{{$order->shipping_postcode}}')" name="order_product_single[]" id="order_product_single_{{$orderedProduct->product->id}}"></td>

                                    <td>
                                        <input type="checkbox" onclick="resetPackages('{{$orderedProduct->product->id}}')"  name="order_product_combo[]" id="order_product_combo_{{$orderedProduct->product->id}}">
                                    </td>
                                    
                                    <td>
                                       
                                    <?php 

                                    $groups_array = $product_packages_array = array();
                                    $groups = App\Models\ProductDeliveryTime::where('products_id',$orderedProduct->product->id)->get();

                                    
                                    //echo "<pre>";
                                    //print_r($groups->toArray());
                                    //echo "</pre>";
                                    $shipping_postcode = (isset($order->shipping_postcode)) ? $order->shipping_postcode : '';

                                    $packages = array();
                                       if(!empty($groups)){
                                            $group_final_array  = $groups->toArray();

                                            $groups_array = array_unique(array_column($group_final_array, 'shipping_zone_groups_id'));

                                            $product_packages_array = array_unique(array_column($group_final_array, 'shipping_packages_id'));

                                            if($shipping_postcode && $shipping_postcode!=''){
                                                $packages = App\Models\ShippingZonePrice::leftjoin('shipping_packages','shipping_packages.id','=','shipping_zone_prices.shipping_packages_id')
                                                        ->leftjoin('shipping_delivery_times','shipping_delivery_times.id','=','shipping_zone_prices.shipping_delivery_times_id');

                                                        if($groups_array && !empty($groups_array) && $groups_array[0]!=null){        
                                                            $packages = $packages->whereIn('shipping_zone_groups_id',$groups_array);
                                                        }   
                                                        
                                                        if($shipping_postcode && $shipping_postcode !='' && empty($groups_array)){        
                                                                $packages = $packages->where('zip_code', $shipping_postcode);
                                                        }

                                                        $packages = $packages->get(['shipping_packages_id as id','shipping_packages.package_name','shipping_delivery_times.name']);
                                            }
                                       } 
                                   ?>

                                   <input type="hidden" name="product_zones_{{$orderedProduct->product->id}}" value="{{json_encode($groups_array)}}">


                                        <div id="packages_{{$orderedProduct->product->id}}">
                                           
                                            <select onchange="getPackageDeliveryTimes(this.value,'{{$orderedProduct->product->id}}', '{{$order->shipping_postcode}}')" class="form-control" name="single_product_package[]" required>
                                                @if(!empty($packages))
                                                    <option value="">Select Package</option>
                                                        @foreach($packages as $package_data)
                                                            @if(in_array($package_data->id, $product_packages_array))
                                                                <option {{(isset($productDeliveryTimePackage) && $productDeliveryTimePackage==$package_data->id) ? 'selected' : ''}} value="{{$package_data->id}}">{{$package_data->package_name}}</option>
                                                            @endif
                                                        @endforeach
                                                @endif
                                                
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div id="delivery_time_{{$orderedProduct->product->id}}">
                                             <select class="form-control" name="single_product_deliverytime[]">
                                                @if(!empty($orderedProduct->product->delivery_time))
                                                    <option value="">Select Delivery Time</option>
                                                    @foreach($orderedProduct->product->delivery_time as $timedetails)
                                                        <option {{(isset($orderedProduct) && $orderedProduct->shipping_delivery_times_id == $timedetails->shipping_delivery_times_id) ? 'selected' : ''}} value="{{$timedetails->shipping_delivery_times_id}}">{{ucfirst($timedetails->delivery_time_name->name)}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </td>

                                 </tr>
                                 @empty
                                 <tr>
                                     No data found
                                 </tr>
                                 @endforelse
                              </tbody>
                           </table>

                        </div>

                         <div class="row">
                               <div class="col-md-12">  
                                <button type="button" id="" onclick="showSelectedDetails()" class="btn btn-primary pull-right">Continue Shipping</button>
                               </div>
                           </div>
                    </div>


                </div>

              
            </div>

             <div style="display:none" class="col-md-12" id="step_2_div">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive" id="step_2_data">
                        
                        </div>

                         <div class="row">
                            <div class="col-md-8">
                            </div>
                                <?php /*
                                <div class="payment_options col-md-3">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <input class="i-checks" type="radio"  name="payment_option" value="stripe">
                                            <label for="payment_option" style="color:#000000;">Stripe</label>
                                             <input class="i-checks" type="radio" name="payment_option" value="paypal">
                                            <label for="payment_option" style="color:#000000;">Paypal</label>
                                             <input class="i-checks" checked type="radio" name="payment_option" value="offline">
                                            <label for="payment_option" style="color:#000000;">Offline</label>
                                        </div>
                                    </div>
                                </div>*/?>
                               <div class="col-md-4">  
                                <button type="button" id="" onclick="processOrderDetails()" class="btn btn-primary pull-right">Mark as Fulfill</button>
                               </div>
                           </div>
                    </div>


                </div>
            </div>

        </div>

        <br>
    </div>
@endsection

@section('ext_js')
<script type="text/javascript">
const productsIds = '<?php echo json_encode($productIds)?>';
const productNames = '<?php echo json_encode($productNames)?>';
const productUnitPrices = '<?php echo json_encode($productUnitPrices)?>';
const productQuantities = '<?php echo json_encode($productQuantities)?>';
const productTotals = '<?php echo json_encode($productTotals)?>';
const orderId = '<?php echo $order_id?>';
function showSelectedDetails(){

    var listSingle = $("input[name='order_product_single[]']").map(function () {
        if(this.checked){
            return 1;
        } else{
            return 0;
        }
    }).get();
    
    var listCombo = $("input[name='order_product_combo[]']").map(function () {
        if(this.checked){
            return 1;
        } else{
            return 0;
        }
    }).get();

    var listPackages = $("select[name='single_product_package[]']").map(function () {
        return this.value;
    }).get();

    var listDeliveryTimes = $("select[name='single_product_deliverytime[]']").map(function () {
        return this.value;
    }).get();

    var url = "{{ route('admin.orders.steptwo.html') }}";

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            "orderId" : orderId,
            "productsIds": productsIds,
            "productNames" : productNames,
            "productUnitPrices" : productUnitPrices,
            "productQuantities" : productQuantities,
            "productTotals" : productTotals,
            "listSingle" : listSingle,
            "listCombo" : listCombo,
            "listPackages" : listPackages,
            "listDeliveryTimes" : listDeliveryTimes
        },
        dataType: 'JSON',
        success: function(data) {
        $("#step_2_div").show();
           $("#step_2_data").html(data.html);
        }
    });
}

function processOrderDetails(){

    var listSingle = $("input[name='order_product_single[]']").map(function () {
        if(this.checked){
            return 1;
        } else{
            return 0;
        }
    }).get();
    
    var listCombo = $("input[name='order_product_combo[]']").map(function () {
        if(this.checked){
            return 1;
        } else{
            return 0;
        }
    }).get();

    var listPackages = $("select[name='single_product_package[]']").map(function () {
        return this.value;
    }).get();

    var listDeliveryTimes = $("select[name='single_product_deliverytime[]']").map(function () {
        return this.value;
    }).get();

    var url = "{{ route('admin.orders.steptwo.process') }}";

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            "orderId" : orderId,
            "productsIds": productsIds,
            "productNames" : productNames,
            "productUnitPrices" : productUnitPrices,
            "productQuantities" : productQuantities,
            "productTotals" : productTotals,
            "listSingle" : listSingle,
            "listCombo" : listCombo,
            "listPackages" : listPackages,
            "listDeliveryTimes" : listDeliveryTimes,
            "package_length" : $("#package_length").val(),
            "package_width" : $("#package_width").val(),
            "package_height" : $("#package_height").val(),
            "package_weight" : $("#package_weight").val(),
            "package_size_unit" : $("#package_size_unit").val(),
            "package_weight_unit" : $("#package_weight_unit").val(),
        },
        dataType: 'JSON',
        success: function(data) {
            alert('Order successfull processed at shipstation');
           window.location = "{{ route('admin.orders.index') }}";
        }
    });
}

function makePayment(){

    return false;
    //window.location = "{{ route('admin.orders.stripe') }}";


    /*var listSingle = $("input[name='order_product_single[]']").map(function () {
            return 1;
    }).get();
    
    var listPackages = $("select[name='single_product_package[]']").map(function () {
        return this.value;
    }).get();

    var listDeliveryTimes = $("select[name='single_product_deliverytime[]']").map(function () {
        return this.value;
    }).get();

    var url = "{{ route('admin.orders.steptwo.process') }}";

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            "orderId" : orderId,
            "productsIds": productsIds,
            "productNames" : productNames,
            "productUnitPrices" : productUnitPrices,
            "productQuantities" : productQuantities,
            "productTotals" : productTotals,
            "listSingle" : listSingle,
            "listPackages" : listPackages,
            "listDeliveryTimes" : listDeliveryTimes
        },
        dataType: 'JSON',
        success: function(data) {
            alert('Order successfull processed at shipstation');
           window.location = "{{ route('admin.orders.index') }}";
        }
    });*/
}
        

function getPackageDeliveryTimes(packageId, productId,shipping_postcode){
        var url = '{{ route('admin.orders.product.deliverytime') }}';
        var groups = $('#groups_'+productId).val();
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "productId": productId,
                "packageId": packageId,
                "groups" : groups,
                "shipping_postcode" : shipping_postcode
            },
            dataType: 'JSON',
            success: function(data) {
               $("#delivery_time_"+productId).html(data.html);
            }
        });
    

    
}

function getProductPackages(productId, shipping_postcode){
    var checkoboxId = "order_product_single_"+productId;
    var checkoboxIdCombo = "order_product_combo_"+productId;
    var productZones = "product_zones_"+productId;


    if($("#"+checkoboxId).prop("checked")){
        $("#"+checkoboxIdCombo).attr("checked", false)
        var url = '{{ route('admin.orders.product.packages') }}';

        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "productId": productId,
                "orderId" : orderId,
                "shipping_postcode" : shipping_postcode,
                "selectname" : "single_product_package_"+productId,
                "productZones" : productZones
            },
            dataType: 'JSON',
            success: function(data) {
               $("#packages_"+productId).html(data.html);
                $("#delivery_time_"+productId).html(data.deliveryHtml);

               
            }
        });
    } else {
        $("#packages_"+product_id).html('<select style="visibility:hidden" name="single_product_package[]"></select>');
    }

    
}


function resetPackages(product_id){
    var checkoboxIdSingle = "order_product_single_"+product_id;

    $("#packages_"+product_id).html('<select style="visibility:hidden" name="single_product_package[]"></select>');
    $("#delivery_time_"+product_id).html('<select style="visibility:hidden" name="single_product_deliverytime[]"></select>');
    $("#"+checkoboxIdSingle).attr("checked", false);
}
        
</script>
@endsection
