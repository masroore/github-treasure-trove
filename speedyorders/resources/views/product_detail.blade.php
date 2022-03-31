@extends('layouts.frontend')

@section('content')


@php

//print_r($productdetails->galleries);
@endphp

<div class="container">

    @if(!empty($productdetails->galleries))
    <div class="prod-detail-main-info pr-0">
        <div class="row">
            
                @if(count($productdetails->galleries) > 0)
                    <div class="col-lg-6 px-0 order-lg-last">
                        <div class="d-flex justify-content-center align-items-center prod-detail-img-wrapper">                    
                            @foreach($productdetails->galleries as $key => $product_gallery_image)
                                @if(isset($product_gallery_image->image) && $product_gallery_image->image!='')
                                    <img style="cursor:pointer;"  class="{{(isset($key) && $key==0) ? 'slick-current slick-active' : ''}} cursor-pointer" src="{{url('images/products/'.$product_gallery_image->image)}}" alt="{{$productdetails->name}}">
                                @endif    
                            @endforeach
                        </div>
                        <div class="d-none d-lg-block prod-detail-thumbs-wrapper">
                            @foreach($productdetails->galleries as $key => $product_gallery_image)
                                @if(isset($product_gallery_image->image) && $product_gallery_image->image!='')
                                    <img style="cursor:pointer;" class="{{(isset($key) && $key==0) ? 'slick-current slick-active' : ''}}  cursor-pointer" src="{{url('images/products/'.$product_gallery_image->image)}}" alt="{{$productdetails->name}}">
                                @endif    
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-lg-6 px-0 order-lg-last text-center" style="margin-top: 80px;">
                        <img style="cursor:pointer;" class="slick-current slick-active cursor-pointer" src="{{url('frontend_assets/img/no-image-available.jpg')}}" alt="{{$productdetails->name}}">
                    </div>
                @endif 
           
            <div class="col-lg-5 offset-lg-1 pr-lg-4 pr-xl-5">
                <h1 class="prod-detail-title">{{$productdetails->name}}</h1>
                <div class="prod-detail-category">{{$category_name}}</div>
                <div class="prod-detail-short-desc">{!!$productdetails->description!!}</div>
            </div>
        </div>
    </div>
    @endif

    <div class="prod-detail-steps-wrapper col-lg-9 col-xl-10 px-0 pr-lg-3 pr-xl-4">
        <div class="prod-detail-step-1">
            <div class="step-header">
                <h2 class="d-md-inline">Step 1</h2>of 2, configure the product and have your budget.
            </div>
            <div class="step-content">
                <h3>Material</h3>
                <div class="row mobile-gutter-16 step-options">
                    <div class="col-6 col-md-3 col-xl-2 block active">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Plexiglas transparent 3/8”</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Plexiglas transparent 3/8”</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Plexiglas transparent 3/8”</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Plexiglas transparent 3/8”</div>
                    </div>
                </div>
            </div>
            <div class="step-content">
                <h3>Formats</h3>
                <div class="row mobile-gutter-16 step-options">
                    <div class="col-6 col-md-3 col-xl-2 block active">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Personalized Format</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">23” x 18” inche</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">20” x 26” inches</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">43” x 18” inches</div>
                    </div>
                </div>
            </div>
            <div class="step-content">
                <div class="row step-options">
                    <div class="col-md-3 col-xl-2">
                        <h3>Width (inches)</h3>
                        <div class="form-floating form-group">
                            <input type="text" class="form-control is-valid" id="prodWidth" placeholder="Width" value="{{$productdetails->width}}">
                            <label for="prodWidth">Width </label>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-2">
                        <h3>Height (inches)</h3>
                        <div class="form-floating form-group">
                            <input type="text" class="form-control is-valid" id="prodHeight" placeholder="Height" value="{{$productdetails->height}}">
                            <label for="prodWidth">Height </label>
                        </div>
                    </div>
                </div>
            </div>
            

               <?php 

                // Code to get options data
                $option_detail_array = [];
                $options = $productdetails->options;
                if(!empty($options)){?>

                    

                        <?php 
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
               

     
                    $options_js_array = [];
                    if(!empty($option_detail_array)){?>
                        <div class="step-content">

                            <h3>Insert Your Text</h3>
                        <?php 
                        foreach ($option_detail_array as $option_detail_data) {
                            
                            $is_required = App\Models\ProductOption::where('option_id',$option_detail_data['id'])->where('product_id', $productdetails->id)->pluck('required')->first();

                            ?>

                            <div class="row form-group align-items-center">
                                <b class="col-4 col-md-2 col-xl-4"><?php echo $option_detail_data["name"]?><span><?php echo ($is_required && $is_required==1) ? '*(required)' : '';?></span></b>
                                <div class="col col-lg-5">
                                    <div class="form-floating">
                                        <input class="form-control <?php echo ($is_required && $is_required==1) ? 'required' : '';?>" id="option_value_<?php echo $option_detail_data["id"]?>_{{$productdetails->id}}" type="text" name="option_<?php echo $option_detail_data["id"]?>_{{$productdetails->id}}" placeholder="Max. 20 characters">
                                         <label for="prodText1">Max. 20 characters </label>
                                    </div>
                                </div>
                            </div>          

                            <?php 

                            $options_js_array[] = $option_detail_data["id"];
                        }?>
                    <input type="hidden" name="options_ids_{{$productdetails->id}}" id="options_ids_{{$productdetails->id}}" value="<?php echo json_encode($options_js_array);?>">

                
                 
            </div>
                    <?php }

                    ?>

                    

                    <?php 
                }
                ?>

                
            <div class="step-content">
                <h3>Print on White</h3>
                <div class="row mobile-gutter-16 step-options">
                    <div class="col-6 col-md-3 col-xl-2 block active">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">None</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Solid print on white</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Isolated white</div>
                    </div>
                </div>
            </div>
            <div class="step-content">
                <h3>Cut</h3>
                <div class="row mobile-gutter-16 step-options">
                    <div class="col-6 col-md-3 col-xl-2 block active">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Rectangle</div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-2 block">
                        <img src="https://via.placeholder.com/364x260" alt="">
                        <div class="label">Special cut</div>
                    </div>
                </div>
            </div>
            <div class="step-content">
                <h3>Varnish - Special Finish</h3>
                <div class="form-floating form-group col-lg-6 px-0">
                    <select name="prodFinish" class="form-control custom-select">
                        <option value="None">None</option>
                        <option value="Varnish">Varnish</option>
                    </select>
                    <label for="prodFinish">Special Finish</label>
                </div>
            </div>
            <div class="step-content">
                <h3>File name</h3>
                <div class="form-floating form-group col-lg-6 px-0">
                    <input type="text" class="form-control" id="fileName" placeholder="Give a name to this project">
                    <label for="fileName">Give a name to this project</label>
                </div>
            </div>
        </div>
        <div class="prod-detail-step-2">
            <div class="step-header">
                <h2 class="d-md-inline">Step 2</h2>of 2, select the price and the delivery date
            </div>
            <div class="step-content border-bottom-0">
                <div class="row align-items-md-end">
                    <div class="col-md-auto">
                        <h3>Quantity</h3>
                        <div class="custom-qtd-input">
                            <a href="javascript:;" class="qtd-less" rel="nofollow">-</a>
                            <input type="text" name="qtd" value="1">
                            <a href="javascript:;" class="qtd-more" rel="nofollow">+</a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-md-end align-items-center flex-wrap grid-price-wrapper">
                            <b>Show grid price</b>
                            <div class="grid-price-options">
                                <a href="javascript:;" rel="nofollow" class="active" id="grid-no-tva">No TVA</a>
                                <a href="javascript:;" rel="nofollow" id="grid-with-tva">With TVA</a>
                            </div>
                        </div>
                        <h3>Other dates</h3>
                        <div class="row mobile-gutter-16 step-options">
                            <div class="col-5  col-xl-3 date-block active">
                                <div class="date">
                                    <b class="d-block">Tuesday</b>
                                    <span>29 / 06</span>
                                </div>
                                <div class="d-flex justify-content-center flex-column price">
                                    <span class="price-no-tva"><b>44,16$</b></span>
                                    <span class="price-with-tva"><b>70,16$</b></span>
                                </div>
                            </div>
                            <div class="col-5  col-xl-3 date-block">
                                <div class="date">
                                    <b class="d-block">Wednesday</b>
                                    <span>30 / 06</span>
                                </div>
                                <div class="d-flex justify-content-center flex-column price">
                                    <span class="price-no-tva"><b>44,16$</b></span>
                                    <span class="price-with-tva"><b>70,16$</b></span>
                                </div>
                            </div>
                            <div class="col-5  col-xl-3 date-block">
                                <div class="date">
                                    <b class="d-block">Thursday</b>
                                    <span>01 / 07</span>
                                </div>
                                <div class="d-flex justify-content-center flex-column price">
                                    <span class="price-no-tva"><b>44,16$</b></span>
                                    <span class="price-with-tva"><b>70,16$</b></span>
                                </div>
                            </div>
                            <div class="col-5  col-xl-3 date-block">
                                <div class="date">
                                    <b class="d-block">Friday</b>
                                    <span>02 / 07</span>
                                </div>
                                <div class="d-flex justify-content-center flex-column price">
                                    <span class="price-no-tva">
                                        <div class="old-price">36,61$</div><b>44,16$</b>
                                    </span>
                                    <span class="price-with-tva">
                                        <div class="old-price">50,61$</div><b>70,16$</b>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row step-content">
                <div class="col-md-6">
                    <div class="promo-code-title">Promocode</div>
                    <div class="d-flex flex-wrap promo-code-wrapper">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="promoInput" placeholder="Insert here your PromoCode">
                            <label for="promoInput">Insert here your PromoCode</label>
                        </div>
                        <a href="#" title="Promocode" class="btn btn-small btn-primary px-2">Activate</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="promo-code-title">Postal Code of the destination</div>
                    <div class="d-flex flex-wrap promo-code-wrapper">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="postalCodeInput" placeholder="Insert here the Postal Code">
                            <label for="postalCodeInput">Insert here the Postal Code</label>
                        </div>
                        <a href="#" title="Postal Code" class="btn btn-small btn-primary px-2">Verify</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-2 ml-md-auto prod-detail-summary">
        <div class="title">RESUME OF THE WORK</div>
        <div class="content">
            <div class="secondary-title">BUDGET</div>
            <div class="d-flex flex-wrap align-items-center info">
                <div class="col-6 col-md-7">Indicative delivery</div>
                <div class="col-6 col-md-5"><b>29/6</b></div>
                <div class="col-6 col-md-7">Net price</div>
                <div class="col-6 col-md-5"><b>44,16$</b></div>
                <div class="col-6 col-md-7">TVA 23%</div>
                <div class="col-6 col-md-5"><b>10,16$</b></div>
            </div>
            <div class="d-flex flex-wrap align-items-center total">
                <div class="col-6 col-md-7">TOTAL BUDGET</div>
                <div class="col-6 col-md-5"><b>54,32$</b></div>
            </div>
            <a href="prod-added.php" title="" class="btn btn-success text-uppercase"><i class="icon-cart mr-2"></i>ADD TO CART</a>
        </div>
    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">We don’t sell only, <span class="color-red">we really care about you.</span></h2>
            <div class="section-title-text">Want to add more beautiful calendars to your cart?</div>
        </div>
    </div>
    <div class="row pt-2 mb-5">
        <a href="#" title="" class="col-md-4 mb-4 card border-0 px-0">
            <img src="https://via.placeholder.com/788x600" class="w-100">
            <div class="info info-floating pt-2 text-center d-flex align-items-center justify-content-center w-100">
                <h3 class="title">Calendars</h3>
            </div>
        </a>
        <a href="#" title="" class="col-md-4 mb-4 card border-0 px-0">
            <img src="https://via.placeholder.com/788x600" class="w-100">
            <div class="info info-floating pt-2 text-center d-flex align-items-center justify-content-center w-100">
                <h3 class="title">Calendars</h3>
            </div>
        </a>
        <a href="#" title="" class="col-md-4 mb-4 card border-0 px-0">
            <img src="https://via.placeholder.com/788x600" class="w-100">
            <div class="info info-floating pt-2 text-center d-flex align-items-center justify-content-center w-100">
                <h3 class="title">Calendars</h3>
            </div>
        </a>
    </div>
</div>
@endsection