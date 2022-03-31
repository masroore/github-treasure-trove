@extends('layouts.app')

@section('content')
<!-- cart-main-area start -->
<div class="cart-main-area bg__white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="#">               
                    <div class="table-content table-responsive">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th style="width:5%" class="product-thumbnail">Image</th>
                                    <th style="width:12%"  class="product-name">Product</th>
                                    <th style="width:8%"  class="product-price">Price</th>
                                    <th style="width:5%"  class="product-quantity">Quantity</th>
                                    <th style="width:15%"  class="product-options">Options</th>
                                    <th style="width:10%"  class="product-options">Delivery Time</th>
                                    <th style="width:5%"  class="product-options">Shipping Price</th>
                                    <th style="width:5%" >Total</th>
                                    <th style="width:5%"  class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $grand_total = 0;?>
                                @if(!empty($cartItems))
                                    @php
                                        $total_amount = 0;
                                    @endphp
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="product-thumbnail"><a href="{{url('product-details/'.$item->product_id)}}"><img src="images/products/{{$item->image}}" alt="product img" /></a></td>
                                            <td class="product-name"><a href="{{url('product-details/'.$item->product_id)}}">{{$item->name}}</a></td>
                                            <td class="product-price"><span class="amount">${{$item->unit_price}}</span> <span style="display: none" id="price_product_{{$item->product_id}}">{{$item->unit_price}}</span></td>
                                            <td class="product-quantity" id="qty_product_{{$item->product_id}}">{{$item->quantity}}</td>

                                            @php
                                                $total_amount += ($item->unit_price * $item->quantity); 
                                            @endphp

                                             <td>                                                
                                                <?php 
                                                    $options_data = App\Models\TempProductOptionValue::leftjoin('options','options.id','=','temp_product_option_value.option_id')
                                                                ->where('product_id', $item->product_id)
                                                                ->where('php_session_id', $php_session_id)
                                                                ->select(['options.name','temp_product_option_value.option_value'])
                                                                ->get();
                                                    if(!empty($options_data)){
                                                        foreach($options_data as $option_data){
                                                            if($option_data->option_value!=''){
                                                                echo "<b>".$option_data->name."</b> : ".$option_data->option_value."<br>";
                                                            }
                                                        }
                                                    } 
                                                ?>
                                            </td>
                                            <td>
                                                
                                                <?php 

                                                $productData = App\Models\Product::with('delivery_time')->where('id',$item->product_id)->first();

                                                if(isset($productData->delivery_time)){
                                                $productTimes = $productData->delivery_time->toArray();

                                                 
                                                    if(isset($productTimes) && !empty($productTimes)){
                                                       
                                                            ?>
                                                                <div class="quick-desc">
                                                                     <?php /* foreach ($productTimes as $productTime) {
                                                                                // get delivery time name
                                                                                $deliveryTimeName = App\Models\ShippingDeliveryTime::where('id',$productTime["shipping_delivery_times_id"])->pluck('name')->first();

                                                                            ?>

                                                                                <input style="width:10px" <?php echo (isset($item["product_delivery_time_id"]) && ($item["product_delivery_time_id"]==$productTime["id"])) ? 'checked' : '';?> type="radio" onselect="deliveryTimePrice('{{$item->product_id}}', this.value)" name="delivery_time_{{$item->product_id}}" value="<?php echo $productTime["id"];?>"><?php

                                                                             echo $deliveryTimeName;
                                                                         }*/?>
                                                                   
                                                                  
                                                                   <select onchange="deliveryTimePrice('{{$item->product_id}}', this.value)" class="themes-select-all-2" name="delivery_time_{{$item->product_id}}" id="delivery_time_{{$item->product_id}}">
                                                                        <option value="">Select Delivery Time</option>
                                                                        <?php  foreach ($productTimes as $productTime) {
                                                                                // get delivery time name
                                                                                $deliveryTimeName = App\Models\ShippingDeliveryTime::where('id',$productTime["shipping_delivery_times_id"])->pluck('name')->first();

                                                                                #echo $deliveryTimeNameData["product_delivery_time_id"];
                                                                             

                                                                            ?>
                                                                            <option <?php echo (isset($item["product_delivery_time_id"]) && ($item["product_delivery_time_id"]==$productTime["id"])) ? 'selected' : '';?> value="<?php echo $productTime["id"];?>"><?php

                                                                             echo $deliveryTimeName;?></option>
                                                                        <?php }?>
                                                                    </select>


                                                                  
                                                                    <br>
                                                                    <div style="display:none" id="deliveryprice_{{$item->product_id}}"></div>
                                                                </div>



                                                            <?php 
                                                    }
                                                }
                                                ?>


                                            </td>
                                            <td><span id="shipping_price_{{$item->product_id}}">{{(isset($item->shipping_zone_price) && $item->shipping_zone_price!='') ? '$'.$item->shipping_zone_price : '0.00'}}</span></td>
                                            <td class="">$<span class="product-subtotal" id="total_{{$item->product_id}}">{{($item->unit_price * $item->quantity) + $item->shipping_zone_price}} <?php $grand_total += (floatval($item->unit_price) * $item->quantity) + floatval($item->shipping_zone_price); ?></span></td>
                                           
                                            <td class="product-remove"><a href="#"  onclick="removeFromCart('{{$item->product_id}}')"><i class="ti-trash"></i></a></td>
                                        </tr>
                                    @endforeach    
                                @endif
                                @if(count($cartItems)==0)
                                    <tr>
                                        <th colspan="9">No Item in the cart</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-7 col-xs-12">
                            
                        </div>
                        <div class="col-md-4 col-sm-5 col-xs-12">
                            <div class="">
                                @if(count($cartItems)>0)
                                <h2>Cart Totals</h2>
                                <br>
                                <table cellpadding="10" cellspacing="10">
                                    <tbody>
                                      
                                        <tr class="order-total">
                                            <th>Total&nbsp;&nbsp;&nbsp;</th>
                                            <td>
                                                <strong><span class="amount" id="grand_total">${{$grand_total}}</span></strong>
                                            </td>
                                        </tr>                                           
                                    </tbody>
                                </table>
                                <br>
                                
                                    <div class="wc-proceed-to-checkout">
                                        <a href="{{route('checkout')}}">Proceed to Checkout</a>
                                    </div>
                                @endif    
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->
       @endsection
@section('ext_js')
    
@endsection