@extends('layouts.frontend')

@section('content')

<div class="container">
    @include('includes.cart_links')    
    <div class="row mx-0 mb-5">

        <table class="col-12 table cart-table-wrapper">
            <thead>
                <tr>
                    <th scope="col" width="400">ADDED ITEMS</th>
                    <th scope="col" class="text-center" width="90">Size</th>
                    <th scope="col" class="text-center" width="200">Quantity</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell" width="90">Unit Price</th>
                    <th scope="col" class="text-center" width="90">total</th>
                    <th width="40" class="p-0"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="prod-cart-info-wrapper">
                        <div class="d-flex flex-wrap">
                            <img src="frontend_assets/img/base_layout/prod-img.jpg" width="90" height="90">
                            <a href="#" title="" class="link-no-style prod-cart-info">
                                <div class="category">Welcome sign</div>
                                <div class="title">Wedding acrylic</div>
                                <div class="text">Text Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consectev</div>
                            </a>
                        </div>
                    </td>
                    <td class="text-center" width="98">
                        <div class="d-lg-none cart-label">size</div>
                        <b>S</b>
                    </td>
                    <td class="text-center">
                        <div class="custom-qtd-input">
                            <a href="javascript:;" class="qtd-less" rel="nofollow">-</a>
                            <input type="text" name="qtd" value="1">
                            <a href="javascript:;" class="qtd-more" rel="nofollow">+</a>
                        </div>
                    </td>
                    <td class="text-center d-none d-lg-table-cell">50$</td>
                    <td class="text-center">
                        <div class="d-lg-none cart-label">total</div>
                        <b>50$</b>
                    </td>
                    <td class="text-center p-0"><a href="#" title="Remove" class="cart-remove-prod"><i class="far fa-times-circle"></i></a></td>
                </tr>
                <tr>
                    <td class="prod-cart-info-wrapper">
                        <div class="d-flex flex-wrap">
                            <img src="frontend_assets/img/base_layout/prod-img.jpg" width="90" height="90">
                            <a href="#" title="" class="link-no-style prod-cart-info">
                                <div class="category">Welcome sign</div>
                                <div class="title">Wedding acrylic</div>
                                <div class="text">Text Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consectev</div>
                            </a>
                        </div>
                    </td>
                    <td class="text-center" width="98">
                        <div class="d-lg-none cart-label">size</div>
                        <b>S</b>
                    </td>
                    <td class="text-center">
                        <div class="custom-qtd-input">
                            <a href="javascript:;" class="qtd-less" rel="nofollow">-</a>
                            <input type="text" name="qtd" value="1">
                            <a href="javascript:;" class="qtd-more" rel="nofollow">+</a>
                        </div>
                    </td>
                    <td class="text-center d-none d-lg-table-cell">50$</td>
                    <td class="text-center">
                        <div class="d-lg-none cart-label">total</div>
                        <b>50$</b>
                    </td>
                    <td class="text-center p-0"><a href="#" title="Remove" class="cart-remove-prod"><i class="far fa-times-circle"></i></a></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div class="promo-code-title">Promocode</div>
                        <div class="d-flex flex-wrap promo-code-wrapper">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="promoInput" placeholder="Insert here your PromoCode">
                                <label for="promoInput">Insert here your PromoCode</label>
                            </div>
                            <a href="#" title="Promocode" class="btn btn-small btn-dark px-2">Activate</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center promo-code-added">
                            <i class="fa fa-check-circle"></i>
                            <div class="title">Birthday10</div>
                            <a href="#" title="Remove" class="ml-auto promo-code-remove"><i class="far fa-times-circle"></i></a>
                        </div>
                    </td>
                    <td colspan="2" class="d-none d-lg-table-cell"></td>
                    <td colspan="3">
                        <div class="order-summary-wrapper">
                            <div class="d-flex mb-2"><span class="mr-auto">Total price</span>300$</div>
                            <div class="d-flex mb-3"><span class="mr-auto">Promocode</span>-10%</div>
                            <div class="d-flex order-summary-total"><span class="mr-auto">Total price</span><span class="value">270$</span></div>
                            <a href="javascript:void(0)" title="Delivery" class="btn btn-primary text-uppercase w-100 mb-2">Proceed to checkout</a>
                            <a href="javascript:void(0)" title="Continue shopping" class="btn btn-outline-secondary text-uppercase w-100">Continue shopping</a>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
      <?php /*
        <table class="col-12 table cart-table-wrapper">
            <thead>
                <tr>
                    <th scope="col" width="400">ADDED ITEMS</th>                    
                    <th scope="col" class="text-center" width="200">Quantity</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell" width="90">Options</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell" width="90">Delivery Time</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell" width="90">Shipping Price</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell" width="90">Unit Price</th>
                    <th scope="col" class="text-center" width="90">total</th>
                    <th width="40" class="p-0"></th>
                </tr>
            </thead>
            <tbody id="cart_items_list_tr">
                @php 
                    $grand_total = 0;
                @endphp

                @if(!empty($cartItems))
                    @php
                        $total_amount = 0;
                    @endphp
                    @foreach($cartItems as $item)

                        <tr id="tr_{{$item->product_id}}">
                            <td class="prod-cart-info-wrapper">
                                <div class="d-flex flex-wrap">
                                    <img src="images/products/{{$item->image}}" width="90" height="90">
                                    <a href="{{url('product-details/'.$item->product_id)}}" title="" class="link-no-style prod-cart-info">
                                        <!-- <div class="category">Welcome sign</div> -->
                                        <div class="title product-name">{{$item->name}}</div>
                                        <!-- <div class="text">Text Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consectev</div> -->
                                    </a>
                                </div>
                            </td>
                           <!--  <td class="text-center" width="98">
                                <div class="d-lg-none cart-label">size</div>
                                <b>S</b>
                            </td> -->
                            <td class="text-center">
                                <div class="custom-qtd-input">
                                    <a href="javascript:;" class="qtd-less change_qty" rel="nofollow" id="{{$item->product_id}}">-</a>
                                    <input type="text" id="qty_p_current_{{$item->product_id}}" name="qtd" value="{{$item->quantity}}">
                                    <a href="javascript:;" class="qtd-more change_qty" id="{{$item->product_id}}" rel="nofollow">+</a>
                                </div>
                            </td>
                            @php
                                $total_amount += ($item->unit_price * $item->quantity); 
                            @endphp

                            <td>                                                
                            @php 
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
                            @endphp
                            </td>
                            <td>
                                                
                            @php
                                $deliveryTimeName = '';
                                $productData = App\Models\Product::with('delivery_time')->where('id',$item->product_id)->first();
                            @endphp
                            @if(isset($productData->delivery_time))

                                @php
                                    $productTimes = $productData->delivery_time->toArray();

                                @endphp

                             
                                @if(isset($productTimes) && !empty($productTimes))
                                            <div class="quick-desc">
                                               <select onchange="deliveryTimePrice('{{$item->product_id}}', this.value)" style="padding:5px;" class="form-control" name="delivery_time_{{$item->product_id}}" id="delivery_time_{{$item->product_id}}">
                                                    <option value="">Select Delivery Time</option>
                                                    @foreach ($productTimes as $productTime)

                                                        <?php 
                                                            $deliveryTimeName = App\Models\ShippingDeliveryTime::where('id',$productTime["shipping_delivery_times_id"])
                                                            ->pluck('name')
                                                            ->first();
                                                            ?>
                                                         
                                                        <option <?php echo (isset($item["product_delivery_time_id"]) && ($item["product_delivery_time_id"]==$productTime["id"])) ? 'selected' : '';?> value="<?php echo $productTime["id"];?>">{{$deliveryTimeName}}</option>
                                                   @endforeach
                                                </select>                                              
                                                <br>
                                                <div style="display:none" id="deliveryprice_{{$item->product_id}}"></div>
                                            </div>
                                       
                                @endif
                            @endif


                            </td>
                            <td><span id="shipping_price_{{$item->product_id}}">{{(isset($item->shipping_zone_price) && $item->shipping_zone_price!='') ? $item->shipping_zone_price.'$' : '0.00'}}</span></td>

                            <td class="text-center d-none d-lg-table-cell product-price">{{$item->unit_price}}$<span style="display: none" id="price_product_{{$item->product_id}}">{{$item->unit_price}}</span></td>

                            <td class="text-center">
                                <div class="d-lg-none cart-label">total</div>
                                <b><span class="product-subtotal" id="total_{{$item->product_id}}">{{($item->unit_price * $item->quantity) + $item->shipping_zone_price}}</span>$
                                    <?php $grand_total += (floatval($item->unit_price) * $item->quantity) + floatval($item->shipping_zone_price); ?>
                                </b>
                            </td>
                            <td class="text-center p-0"><a onclick="removeFromCart('{{$item->product_id}}')" href="javascript:void(0)" title="Remove" class="cart-remove-prod"><i class="far fa-times-circle"></i></a></td>
                        </tr>
                    @endforeach    
                @endif
                
                @if(count($cartItems)==0)
                    <tr>
                        <th colspan="8">No Item in the cart</th>
                    </tr>
                @endif    
                
            </tbody>
            <tfoot>
                <tr>
                    <td>
                       <!--  <div class="promo-code-title">Promocode</div>
                        <div class="d-flex flex-wrap promo-code-wrapper">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="promoInput" placeholder="Insert here your PromoCode">
                                <label for="promoInput">Insert here your PromoCode</label>
                            </div>
                            <a href="#" title="Promocode" class="btn btn-small btn-dark px-2">Activate</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center promo-code-added">
                            <i class="fa fa-check-circle"></i>
                            <div class="title">Birthday10</div>
                            <a href="#" title="Remove" class="ml-auto promo-code-remove"><i class="far fa-times-circle"></i></a>
                        </div> -->
                    </td>
                    <td colspan="2" class="d-none d-lg-table-cell"></td>
                    <td colspan="5">
                        <div class="order-summary-wrapper">
                            <div class="d-flex mb-2"><span class="mr-auto"><b>Total price</b></span><b><span class="value" id="grand_total_price">{{$grand_total}}</span>$</b></div>
                            <!-- <div class="d-flex mb-3"><span class="mr-auto" id="promocode">Promocode</span>-0%</div> -->
                            <!-- <div class="d-flex order-summary-total"><span class="mr-auto">Total price</span><span class="value">270$</span></div> -->
                            <a href="{{route('delivery')}}" title="Delivery" class="btn btn-primary text-uppercase w-100 mb-2">Proceed to checkout</a>
                            <a href="{{route('store')}}" title="Continue shopping" class="btn btn-outline-secondary text-uppercase w-100">Continue shopping</a>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>

    */?>

    </div>
</div>
@endsection