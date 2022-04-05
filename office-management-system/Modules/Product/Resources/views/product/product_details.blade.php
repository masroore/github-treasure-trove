
<div class="modal fade admin-query" id="Item_Details">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $product->product_name }} {{ __('product.Details') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="products_view_left text-center mb-35">
                                <div class="products_image mb-25">
                                    @if ($product->image_source)
                                        <img src="{{ asset($product->image_source) }}" alt="">
                                        @else
                                        <img src="{{ asset('public/backEnd/img/no_image.png') }}" alt="">
                                    @endif

                                </div>
                                @if($product->product_type != 'Service')
                                <div class="stock_count mt-4 mb-15">
                                    <span>{{__('product.In Stock')}}: </span>
                                    <div class="stock_number">
                                        @php
                                            $p = $product->skus->all();
                                             $total = 0;
                                            foreach($p as $v){
                                                $total += $v->stocks->sum('stock');
                                            }
                                        @endphp
                                    {{ $total }} {{@$product->unit_type->name}}
                                    </div>
                                </div>
                                <a class="primary_btn" href="{{route('add_opening_stock_create')}}" target="_blank"> <i class="ti-plus mr-1"></i> {{__('product.Add More')}}</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="products_view_right mb-35">
                                <div class="products_details_list">
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Product Name')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{ $product->product_name }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.SKU')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{ $product->skus->first()->sku }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Product Type')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{$product->product_type}}</span>
                                    </div>
                                    @if($product->product_type != 'Service')
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Category')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{@$product->category->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Brand')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{@$product->brand->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Barcode Type')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{@ $product->skus->first()->barcode_type }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Product Quantity')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{ @$product->skus->first()->stocks->sum('stock') }} {{@$product->unit_type->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Alert Quantity')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{ @$product->skus->first()->alert_quantity }} {{@$product->unit_type->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Product Unit')}} </span>
                                            <span>:</span>
                                        </span>
                                        <span>{{@$product->unit_type->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Unit Cost')}} </span>
                                            <span>:</span>
                                        </span>
                                        @php
                                        $purchase_price = $product->skus->first()->purchase_price ? $product->skus->first()->purchase_price : 0
                                        @endphp
                                        <span>{{single_price($purchase_price)}}</span>
                                    </div>

                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Min Selling Price')}} </span>
                                            <span>:</span>
                                        </span>
                                        @php
                                        $min_selling_price = $product->skus->first()->min_selling_price ? $product->skus->first()->min_selling_price : 0
                                        @endphp
                                        <span>{{single_price($min_selling_price)}}</span>
                                    </div>
                                    @endif
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            @if($product->product_type != 'Service')
                                            <span>{{__('product.Selling Price')}} </span>
                                            @else
                                            <span>{{__('product.Hourly Rate')}} </span>
                                            @endif
                                            <span>:</span>
                                        </span>
                                        @php
                                        $selling_price = $product->skus->first()->selling_price ? $product->skus->first()->selling_price : 0
                                        @endphp
                                        <span>{{single_price($selling_price)}}</span>
                                    </div>
                                     @if($product->product_type != 'Service')
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('product.Product Tax')}} </span>
                                            <span>:</span>
                                        </span>

                                        <span>{{ $product->skus->first()->tax }} %</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span class="d-flex align-items-center justify-content-between">
                                            <span>{{__('inventory.Branch')}} </span>
                                            <span>:</span>
                                        </span>

                                        @foreach ($product->skus->first()->stocks as $stock)
                                            <span>{{ $stock->houseable->name }};</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (count($product->variations) > 0)
                            <div class="col-12 mb-40">
                                <!-- content  -->
                                <div class="QA_section3 QA_section_heading_custom">
                                    <div class="box_header m-0">
                                            <div class="main-title d-flex mb-10">
                                                <h3 class="mb-0">{{__('product.Variant Items')}} <span class="f_s_12 f_w_500 theme_text2 ml-15" >({{ count($product->variations) }} {{__('product.Variant')}} )</span> </h3>
                                            </div>
                                        </div>
                                    <div class="QA_table QA_table4">
                                        <!-- table-responsive -->
                                        <div class="table-responsive">
                                            <table class="table  shadow_none pb-0 ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{__('product.Product Image')}}</th>
                                                        @foreach($variants as $key=>$variant_value)
                                                            @if(in_array($variant_value->id,$product_variant_type))
                                                                <th scope="col">{{$variant_value->name}}</th>
                                                            @endif
                                                        @endforeach
                                                        <th scope="col">{{__('product.SKU')}}</th>
                                                        <th scope="col">{{__('product.Selling Price')}}</th>
                                                        <th scope="col">{{__('product.Min Selling Price')}}</th>
                                                        <th scope="col">{{__('product.In Stock')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->variations as $key => $product_variation_value)
                                                        <tr>
                                                            <th class="nowrap text-center">
                                                                <div class="tab_thumb">
                                                                    <img src="{{ asset($product_variation_value->image_source ?? 'public/backEnd/img/no_image.png') }}" alt="">
                                                                </div>
                                                            </th>
                                                            @foreach($variant_values as $key=>$variant_value)
                                                                @if(in_array($variant_value['id'],json_decode($product_variation_value->variant_value_id)))
                                                                    <td class="nowrap text-center">{{$variant_value['value']}}</td>
                                                                @endif
                                                            @endforeach
                                                            <td class=" text-center">{{$product_variation_value->product_sku->sku}}</td>
                                                            <td class="text-center">{{single_price($product_variation_value->product_sku->selling_price)}}</td>
                                                            <td class="text-center">{{single_price($product_variation_value->product_sku->min_selling_price)}}</td>
                                                            <td class="text-center">{{$product_variation_value->product_sku->stocks->sum('stock')}} {{@$product->unit_type->name}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--/ content  -->
                            </div>
                        @endif
                        <div class="col-12 mt-40 mb-20">
                            <h4 class="f_s_14 f_w_500 mb_10">{{__('product.Description')}}:</h4>
                            <p class="f_w_400" >
                                {!! $product->description !!}
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
