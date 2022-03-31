@extends('layouts.app')

@section('content')
<style type="text/css">
        .error {
    color: red;
}
</style>
        <!-- Start Feature Product -->
        <section class="categories-slider-area bg__white">
            <div class="container">
                <div class="row flex-row-reverse">
                    <!-- Start Left Feature -->
                    <div class="col-lg-12 col-xl-12 col-md-12 col-xs-12">
                        <!-- Start Slider Area -->
                        <div class="slider__container slider--one">
                            <div class="slider__activation__wrap owl-carousel owl-theme">
                                <!-- Start Single Slide -->
                                <div class="slide slider__full--screen slider-height-inherit slider-text-right" style="background: rgba(0, 0, 0, 0) url(images/products/10000256-mockup.jpg) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-10 col-xl-8 ms-auto col-md-12 col-xs-12">
                                                <div class="slider__inner">
                                                    <h1>Featured <span class="text--theme">Collection</span></h1>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slide -->
                                <!-- Start Single Slide -->
                                <div class="slide slider__full--screen slider-height-inherit  slider-text-left" style="background: rgba(0, 0, 0, 0) url(images/products/10000119-mockup.jpg) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-8 col-xl-8 col-md-12 col-xs-12">
                                                <div class="slider__inner">
                                                    <h1>Latest <span class="text--theme">Collection</span></h1>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slide -->
                            </div>
                        </div>
                        <!-- Start Slider Area -->
                    </div>
                   
                </div>
            </div>
        </section>
      
      

        
        <!-- Start Our Product Area -->
        <section class="htc__product__area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-style-tab">
                      
                            <div class="tab-content another-product-style">
                                <div class="tab-pane active" id="home9">
                                    <div class="product-slider-active2">
                                        <div class="row">

                                            @if(!empty($products))
                                                @foreach($products as $product)
                                                    <div class="col-lg-4 single__pro col-xl-4 cat--1 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="product">
                                                            <div class="product__inner">
                                                                <div class="pro__thumb">
                                                                    <a href="{{url('product-details/'.$product->id)}}">
                                                                        <img src="images/products/{{$product->image}}" alt="product images">
                                                                    </a>
                                                                </div>
                                                                <div class="product__hover__info">
                                                                    <ul class="product__action">
                                                                        <li><a data-bs-toggle="modal" data-bs-target="#productModal_{{$product->id}}" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                                        <li><a title="Add TO Cart" href="{{route('cart')}}"><span class="ti-shopping-cart"></span></a></li>
                                                                       
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product__details">
                                                                <h2><a href="{{url('product-details/'.$product->id)}}">{{$product->name}}</a></h2>
                                                                <ul class="product__price">
                                                                    <li class="old__price">${{$product->base_price}}</li>
                                                                    <li class="new__price">${{$product->sale_price}}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <?php 

                                                    // Code to get options data
                                                    $option_detail_array = [];
                                                    $options = $product->options;
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

                                                     <!-- Modal -->
                                                    <div class="modal fade" id="productModal_{{$product->id}}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal__container" role="document">
                                                            <div class="modal-content">



                                                                <div class="modal-header">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <form style="z-index: 1000 !important;" name="product_{{$product->id}}" id="product_{{$product->id}}" action="#">

                                                                        @csrf


                                                                    <div class="modal-product">
                                                                        <!-- Start product images -->
                                                                        <div class="product-images">
                                                                            <div class="main-image images">
                                                                                <img alt="big images" src="images/products/{{$product->image}}">
                                                                            </div>
                                                                        </div>
                                                                        <!-- end product images -->
                                                                        <div class="product-info">
                                                                            <h1>{{$product->name}}</h1>
                                                                            <div class="price-box-3">
                                                                                <div class="s-price-box">
                                                                                    <span class="new-price">${{$product->base_price}}</span>
                                                                                    <span class="old-price">${{$product->sale_price}}</span>
                                                                                </div>
                                                                            </div>

                                                                            
                                                                            <div class="quick-desc">
                                                                                <label>Quantity</label>
                                                                                <select class="themes-select-all-2" name="quantity_{{$product->id}}" id="quantity_{{$product->id}}">
                                                                                    <?php for($i=1;$i<=15;$i++){?>
                                                                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                                    <?php }?>
                                                                                </select>
                                                                            </div>

                                                                            <?php 
                                                                                $options_js_array = [];
                                                                                if(!empty($option_detail_array)){
                                                                                    foreach ($option_detail_array as $option_detail_data) {

                                                                                            $is_required = App\Models\ProductOption::where('option_id',$option_detail_data['id'])->where('product_id', $product->id)->pluck('required')->first();
                                                                                        ?>
                                                                                            <div class="quick-desc">
                                                                                                <label><?php echo $option_detail_data["name"]?><span><?php echo ($is_required && $is_required==1) ? '*(required)' : '';?></span></label>
                                                                                               <input  class="<?php echo ($is_required && $is_required==1) ? 'required' : '';?>"  id="option_value_<?php echo $option_detail_data["id"]?>_{{$product->id}}" type="text" name="option_<?php echo $option_detail_data["id"]?>_{{$product->id}}">
                                                                                            </div>



                                                                                        <?php 

                                                                                        $options_js_array[] = $option_detail_data["id"];
                                                                                    }
                                                                                }
                                                                            ?>

                                                                            <div style="display: none;" class="alert alert-primary" id="alert_{{$product->id}}" role="alert">
                                                                             
                                                                            </div> 

                                                                            <input type="hidden" name="options_ids_{{$product->id}}" id="options_ids_{{$product->id}}" value="<?php echo json_encode($options_js_array);?>">

                                                                           <div class="quick-desc">
                                                                            <label>Zipcode</label>
                                                                                <input type="text" name="pincode_{{$product->id}}" id="pincode_{{$product->id}}">
                                                                                <span style="clear:both" id="msg_{{$product->id}}"></span>
                                                                                <br>
                                                                                <button onclick="return checkProductAvailabe('{{$product->id}}')" style="margin-top: 5px;" type="button">Check Availability</button>
                                                                            </div>


                                                                        
                                                                            
                                                                            <div id="cart_btn_{{$product->id}}" class="addtocart-btn">
                                                                                 <button type="submit" id="btn_{{$product->id}}" name="submit">Add To Cart</button>
                                                                            </div>


                                                                           

                                                                        </div><!-- .product-info -->
                                                                    </div><!-- .modal-product -->

                                                                </form>


                                                                </div><!-- .modal-body -->



                                                            </div><!-- .modal-content -->
                                                        </div><!-- .modal-dialog -->
                                                    </div>
                                                    <!-- END Modal -->



                                                @endforeach


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

                                                <hr style="margin-top:20px;">
                                                {{$products->links()}}

                                            @endif

                                           
                                        </div>
                                    </div>
                                </div>
                               
                               
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Our Product Area -->


<style type="text/css">
    
    .modal {
  overflow-y:auto;
}
</style>



@endsection


