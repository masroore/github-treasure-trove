<div class="modal fade admin-query" id="Item_Details">
    <div class="modal-dialog modal_1200px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('product.Details') }}<span class="view_product_name"></span></h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col-xl-6">
                            <img src="{{ asset($product->image_source) }}" id="view_product_image" style="height:200px;">
                        </div>

                        <div class="col-xl-6">
                            <p>{{__('product.Product Name')}} : <span>{{ $product->name }}</span></p>
                            <p>{{__('product.Price')}} : <span>{{single_price($product->price)}}</span></p>
                            <p>{{__('product.Regular Price')}} : <span>{{ single_price($product->total_regular_price) }}</span></p>
                            <p>{{__('product.Total Purchase Product')}} : <span>{{ single_price($product->total_purchase_price) }}</span></p>
                        </div>
                        @if (count($product->combo_products) > 0)
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead id="variant_section_head">
                                        <tr>
                                        <th scope="col">{{__('product.Image')}}</th>
                                        <th scope="col">{{__('product.Name')}}</th>
                                        <th scope="col">{{__('product.Category')}}</th>
                                        <th scope="col">{{__('product.Brand')}}</th>
                                        <th scope="col">{{__('product.QTY')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($product->combo_products as $key => $comboProduct)
                                            <tr class="variant_row_lists">
                                                <td>
                                                    @if (@$comboProduct->productSku->product->product_type == "Single")
                                                        <img style="height:70px;" src="{{ asset(@$comboProduct->productSku->product->image_source) }}"></td>
                                                    @else
                                                        <img style="height:70px;" src="{{ asset(@$comboProduct->productSku->product_variation->image_source) }}"></td>
                                                    @endif
                                                <td>
                                                   <input type="text" value="{{ @$comboProduct->productSku->product->product_name }}" readonly class="primary_input_field">
                                                </td>
                                                <td>
                                                   <input type="text" value="{{ @$comboProduct->productSku->product->category->name }}" readonly class="primary_input_field">
                                                </td>
                                                <td>
                                                   <input type="text" value="{{ @$comboProduct->productSku->product->brand->name }}" readonly class="primary_input_field">
                                                </td>
                                                <td>
                                                   <input type="text" value="{{ $comboProduct->product_qty }}" readonly class="primary_input_field">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="col-xl-12">
                            <label class="primary_input_label" for="">{{__('product.Description')}}</label>
                            <p id="view_product_description">
                                @php
                                    echo $product->description;
                                @endphp
                            </p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
