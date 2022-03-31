@extends('layouts.app')


<style type="text/css">
    .dec.qtybutton{
        cursor: pointer !important;
    }

     .inc.qtybutton{
        cursor: pointer !important;
    }
    .error {
    color: red;
}
</style>
@section('content')
<!-- cart-main-area start -->
                <section class="htc__product__details pb--100 bg__white">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6 col-md-12 col-12">
                                <div class="product__details__container">
                                    <div class="product__big__images">
                                        <div class="portfolio-full-image tab-content">
                                            <div role="tabpanel" class="tab-pane fade show active product-video-position" id="img-tab-1">
                                                <img src="/images/products/{{$productdetails->image}}" alt="full-image">
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 col-md-12 col-12 smt-30 xmt-30">
                                <div class="htc__product__details__inner">

                                    <form style="z-index: 1000 !important;" method="post" name="product_{{$productdetails->id}}" id="product_{{$productdetails->id}}" action="#">
                                     
                                        <div class="pro__detl__title">
                                            <h2>{{$productdetails->name}}</h2>
                                        </div>
                                       
                                        <ul class="pro__dtl__prize">
                                            <li class="old__prize">${{$productdetails->base_price}}</li>
                                            <li>${{$productdetails->sale_price}}</li>
                                        </ul>
                                       

                                        @csrf

                                        <div class="product-action-wrap">
                                            <div class="prodict-statas"><span>Quantity :</span></div>
                                            <div class="product-quantity">
                                                
                                                    <div class="product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <input class="cart-plus-minus-box" type="text" name="quantity_{{$productdetails->id}}" value="1">
                                                        <div class="dec qtybutton">-</div><div class="inc qtybutton">+</div></div>
                                                    </div>
                                            </div>
                                        </div>

                                         <?php 

                                        // Code to get options data
                                        $option_detail_array = [];
                                        $options = $productdetails->options;
                                        if(!empty($options)){
                                            $options_data = $options->toArray();
                                            $index = 0;
                                            foreach ($options_data as $option_data) {
                                                $option_details = App\Models\Option::where('id',$option_data["option_id"])->get()->first();

                                                if(!empty($option_details) && isset($option_details->type) && $option_details->type=='input'){
                                                    $option_detail_array[$index]["id"] =  $option_details->id;
                                                    $option_detail_array[$index]["name"] =  $option_details->name;

                                                    $index++;
                                                }
                                            }
                                        }

                                        ?>


                                        <?php 
                                            $options_js_array = [];
                                            if(!empty($option_detail_array)){
                                                foreach ($option_detail_array as $option_detail_data) {
                                                    
                                                    $is_required = App\Models\ProductOption::where('option_id',$option_detail_data['id'])->where('product_id', $productdetails->id)->pluck('required')->first();

                                               
                                                    ?>
                                                        <div class="quick-desc">
                                                            <label><?php echo $option_detail_data["name"]?><span><?php echo ($is_required && $is_required==1) ? '*(required)' : '';?></span></label>
                                                           <input class="<?php echo ($is_required && $is_required==1) ? 'required' : '';?>" id="option_value_<?php echo $option_detail_data["id"]?>_{{$productdetails->id}}" type="text" name="option_<?php echo $option_detail_data["id"]?>_{{$productdetails->id}}">


                                                        </div>



                                                    <?php 

                                                    $options_js_array[] = $option_detail_data["id"];
                                                }
                                            }
                                        ?>

                                        <div style="display: none;" class="alert alert-primary" id="alert_{{$productdetails->id}}" role="alert">
                                                                                 
                                        </div> 

                                        <input type="hidden" name="options_ids_{{$productdetails->id}}" id="options_ids_{{$productdetails->id}}" value="<?php echo json_encode($options_js_array);?>">

                                        <div class="quick-desc">
                                        <label>Zipcode</label>
                                            <input type="text" name="pincode_{{$productdetails->id}}" id="pincode_{{$productdetails->id}}">
                                            <span style="clear:both" id="msg_{{$productdetails->id}}"></span>
                                            <br>
                                            <button onclick="return checkProductAvailabe('{{$productdetails->id}}')" style="margin-top: 5px;" type="button">Check Availability</button>
                                        </div>
                                         <button type="submit" id="btn_{{$productdetails->id}}" name="submit">Add To Cart</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                                                                            
                            function checkProductAvailabe(productId){
                                $("#msg_"+productId).text('');

                                var url = '/productavailability';
                                var pincode = $("#pincode_"+productId).val();
                                if(pincode==''){
                                  alert('Please enter pincode to check product availability');
                                  return false;
                                }
                                
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    data: {
                                        "_token": $('meta[name="_token"]').attr('content'),
                                        "product_id": productId,
                                        "pincode": pincode
                                    },
                                    dataType: 'JSON',
                                    success: function(message) {
                                        $("#msg_"+productId).text(message.msg);
                                       
                                    }
                                });
                              }
                        </script>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h2>Description</h2>
                                <br>
                                <div class="product__details__tab__content">
                                        <div class="product__description__wrap">
                                            {!!$productdetails->description!!}
                                        </div>
                                    
                    
                                    </div>
                                    <!-- End Single Content -->
                            </div>
                    </div>
                </div>

                    </div>
                </section>

       @endsection
@section('ext_js')
    
@endsection