@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('quotation.Edit Quotation')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{route("quotation.update",$quotation->id)}}" method="POST"enctype="multipart/form-data" id="form">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Select Customer')}} *</label>
                                            <select class="primary_select mb-15 contact_type" name="customer_id">
                                                <option selected disabled>{{__('quotation.Select')}}</option>
                                                @foreach($customers as $customer)
                                                    <option
                                                        value="{{$customer->id}}" {{$quotation->customer_id == $customer->id ? 'selected' : ''}}>{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('purchase.Select Warehouse or Branch')}} *</label>
                                            <select class="primary_select mb-15 house contact_type" name="showroom">
                                                <option value="">{{__('common.Select')}}</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option
                                                        value="warehouse-{{$warehouse->id}}" {{$warehouse->quotations()->exists() && $warehouse->id == $quotation->quotationable_id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                                @endforeach
                                                @foreach($showrooms as $showroom)
                                                    <option
                                                        value="showroom-{{$showroom->id}}" {{$showroom->quotations()->exists() && $showroom->id == $quotation->quotationable_id ? 'selected' : ''}}>{{$showroom->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('showroom')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Reference No')}} *</label>
                                            <input type="text" class="primary_input_field"
                                                   placeholder="{{__('sale.Reference No')}}" name="ref_no"
                                                   value="{{ $quotation->ref_no }}">
                                            <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('quotation.Date') }}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text"
                                                                   name="date" value="{{$quotation->date}}"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('quotation.Valid Till Date') }}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="valid till date" class="primary_input_field primary-input date form-control" id="valid_till_date" type="text" name="valid_till_date" value="{{$quotation->valid_till_date}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Shipping Address')}}</label>
                                            <input type="text" name="shipping_address" class="primary_input_field"
                                                   value="{{$quotation->shipping_address}}"
                                                   placeholder="{{__('quotation.Shipping Address')}}">
                                            <span class="text-danger">{{$errors->first('shipping_address')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-6 col-md- col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Attach Document')}} <span class="text-muted">({{__('quotation.pdf,csv,jpg,png,doc,docx,xlxs,zip')}})</span></label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                       placeholder="Browse file" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">{{__("common.Browse")}} </label>
                                                    <input type="file" class="d-none" name="documents[]"
                                                           id="document_file_1" multiple="multiple">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Discount')}}</label>
                                            <input onkeyup="addTotalDiscount()" name="total_discount"
                                                       type="number" step="0.01"
                                                       value="{{$quotation->discount_amount}}"
                                                       class="primary_input_field billing_inputs total_discount">
                                            <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('quotation.Discount Type')}}</label>
                                            <select class="primary_select mb-15 discount_type" onchange="addTotalDiscount()" id="discount_type" name="discount_type">
                                                <option value="1"@if ($quotation->discount_type == 1) selected @endif>{{ __('quotation.Amount') }}</option>
                                                <option value="2"@if ($quotation->discount_type == 2) selected @endif>{{ __('quotation.Percentage') }}</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('quotation.Select Product')}}</label>
                                            <select class="primary_select mb-15 product_info" id="product_info" name="product">
                                                <option value="1">{{__('quotation.Select Product')}}</option>
                                                @foreach ($allProducts as $product)
                                                    <option value="{{$product->product_id}}-{{ $product->product_type }}">{{$product->product_name}} @if (app('general_setting')->origin == 1 && $product->origin) > {{ __('common.Part Number') }} : {{ $product->origin }} @endif @if ($product->brand_name) > {{ __('product.Brand') }} : {{ $product->brand_name }} @endif @if ($product->model_name) > {{ __('product.Model') }} : {{ $product->model_name }} @endif</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('product_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('quotation.PO')}}</label>
                                            <input type="text" name="po" class="primary_input_field" value="{{ $quotation->po }}" placeholder="po">
                                            <span class="text-danger">{{$errors->first('po')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                </div>
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th width="15%" scope="col">{{__('sale.Product')}}</th>
                                        <th width="10%" scope="col">{{__('quotation.Description')}}</th>
                                        @if (app('general_setting')->origin == 1)
                                            <th width="10%" scope="col">{{__('common.Part Number')}}</th>
                                        @endif
                                        <th width="10%" scope="col">{{__('product.Model')}}</th>
                                        <th width="10%" scope="col">{{__('product.Brand')}}</th>
                                        <th width="10%" scope="col">{{__('sale.Price')}}</th>
                                        <th scope="col">{{__('sale.QTY')}}</th>
                                        <th scope="col">{{__('sale.Tax')}}</th>
                                        <th scope="col">{{__('sale.Discount')}}</th>
                                        <th width="10%" scope="col">{{__('sale.SubTotal')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    @php
                                        $sub_total = 0;
                                        $vat = 0;
                                    @endphp
                                    <tbody id="product_details">
                                    @foreach($quotation->items as $key=> $item)
                                        @php
                                            $variantName = variantName($item);
                                            $sub_total += $item->price * $item->quantity;
                                            $vat += ($item->price * $item->quantity * $item->tax) / 100;
                                        @endphp
                                        @if ($item->productable->product)
                                            @php
                                                $type =$item->product_sku_id.",'sku'" ;
                                            @endphp
                                            <tr>
                                                <td><input type="hidden" name="items[]" value="{{$item->product_sku_id}}">
                                                    {{$item->productable->product->product_name}} <br>
                                                    @if ($variantName)
                                                        ({{ $variantName }})
                                                    @endif
                                                </td>
                                                <td>{{$item->productable->product->description}}</td>

                                                @if (app('general_setting')->origin == 1)
                                                    <td>{{@$item->productable->product->origin}}</td>
                                                @endif
                                                <td>{{@$item->productable->product->model->name}}</td>
                                                <td>{{@$item->productable->product->brand->name}}</td>
                                                <td><input min="{{$item->productSku->purchase_price}}"
                                                           onkeyup="priceCalc({{$type}})"
                                                           class="primary_input_field product_price product_price_sku{{$item->product_sku_id}}"
                                                           type="number"
                                                           value="{{$item->price}}" name="item_price[]"></td>
                                                <td>
                                                    <input type="number" onkeyup="addQuantity({{$type}})"
                                                           name="item_quantity[]" value="{{$item->quantity}}"
                                                           class="primary_input_field quantity quantity_sku{{$item->product_sku_id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="item_tax[]" onkeyup="addTax({{$type}})" value="{{$item->tax}}" net-sub-total="{{ ($item->price - $item->discount) * $item->quantity * $item->tax  / 100 }}" class="primary_input_field tax tax{{$item->product_sku_id}}">
                                                </td>
                                                <td>
                                                    <input type="number" onkeyup="addDiscount({{$type}})"
                                                           name="item_discount[]" value="{{$item->discount}}"
                                                           class="primary_input_field discount discount_sku{{$item->product_sku_id}}">
                                                </td>
                                                <td style="text-align: center;" class="product_subtotal product_subtotal_sku{{$item->product_sku_id}}">{{$item->price * $item->quantity}}</td>
                                                <td><a data-id="{{$item->id}}" data-product="{{$item->id}}"
                                                       class="primary-btn primary-circle fix-gr-bg new_delete_product" href="javascript:void(0)">
                                                        <i class="ti-trash"></i></a></td>
                                            </tr>
                                        @else
                                            @php
                                                $type =$item->product_sku_id.",'combo'" ;
                                            @endphp
                                            <tr>
                                                <td><input type="hidden" name="combo_items[]"
                                                           value="{{$item->productable_id}}"
                                                           class="primary_input_field sku_id{{$item->product_sku_id}}">{{$item->productable->name}} </br> {!!$variantName!!}
                                                </td>

                                                <td>{{@$item->productable->description}}</td>

                                                @if (app('general_setting')->origin == 1)
                                                    <td></td>
                                                @endif
                                                <td></td>
                                                <td></td>

                                                <td><input min="{{$item->productSku->purchase_price}}"
                                                           onkeyup="priceCalc({{$type}})"
                                                           class="primary_input_field product_price product_price_combo{{$item->product_sku_id}}"
                                                           type="number"
                                                           value="{{$item->price}}" name="combo_item_price[]"></td>

                                                <td>
                                                    <input type="number" data-type="combo" name="combo_item_quantity[]"
                                                           value="{{$item->quantity}}"
                                                           onkeyup="addQuantity({{$type}})"
                                                           class="primary_input_field quantity quantity_combo{{$item->product_sku_id}}">
                                                </td>

                                                <td>
                                                    <select name="combo_item_tax[]"
                                                            class="primary_select mb-15 tax tax_combo{{$item->product_sku_id}}"
                                                            onchange="addTax({{$type}})" net-sub-total="{{ ($item->price - $item->discount) * $item->quantity * $item->tax  / 100 }}">
                                                        <option value="0">No Tax</option>
                                                        @foreach($taxes as $tax)
                                                            <option
                                                                value="{{$tax->rate}}" {{$item->tax == $tax->rate ? 'selected' : '' }}>{{$tax->rate}}
                                                                %
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="number" name="combo_item_discount[]"
                                                           value="{{$item->discount}}" onkeyup="addDiscount({{$type}})"
                                                           class="primary_input_field discount discount_combo{{$item->product_sku_id}}">
                                                </td>
                                                <td class="product_subtotal product_subtotal_combo{{$item->product_sku_id}}"> {{$item->sub_total}} </td>
                                                <td><a data-id=" {{$item->id}} " data-product="{{$item->id}}-combo"
                                                       class="new_delete_product" href="javascript:void(0)"><i
                                                            class="ti-trash"></i></a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @php
                                    $total_due = 0;
                                    $this_due = 0;
                                    $tax = 0;
                                    $discountProductTotal = 0;
                                    $subTotalAmount = 0;
                                    foreach ($quotation->items as $product) {

                                        $prductDiscount = $product->price * $product->discount / 100;

                                        $tax +=(($product->price - $prductDiscount) * $product->quantity ) * $product->tax / 100;

                                        if ($product->discount > 0) {
                                            $discountProductTotal += ($product->price * $product->discount / 100) * $product->quantity;
                                        }
                                        $subTotalAmount += $product->price * $product->quantity;
                                    }
                                    $discount = $quotation->total_discount;
                                    $vat =($quotation->amount * $quotation->total_tax) / 100;
                                @endphp
                                <input type="hidden" class="total_price"
                                       value="{{ $quotation->amount}}"
                                       name="item_amount">
                                <div class="col-12 mb-50">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.Total Quantity')}}</label>
                                                    <input type="number" class="primary_input_field total_quantity"
                                                    value="{{$quotation->total_quantity}}" name="total_quantity" readonly>

                                            </div>
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.SubTotal')}}</label>
                                                    <input type="text" class="primary_input_field billing_inputs total_sub_total"
                                                    value="{{$subTotalAmount}}" name="item_amount" readonly="readonly">

                                            </div>
                                            <div class="primary_input grid_input product_discounts" @if ($quotation->items->sum('discount') == 0)
                                                style="display: none;"
                                            @endif >
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.Product Wise Discount')}}</label>
                                                    <input type="text" class="primary_input_field product_discounts"
                                                    value="{{$discountProductTotal}}" name="item_amount" readonly="readonly">

                                            </div>
                                            <div class="primary_input grid_input product_tax" @if ($quotation->items->sum('tax') == 0)
                                                style="display: none;"
                                            @endif>
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.Product Wise Tax')}}</label>
                                                    <input type="text" class="primary_input_field product_tax product_tax_input"
                                                    value="{{$tax}}" name="item_amount" readonly="readonly">

                                            </div>
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.Grand Total')}}</label>
                                                    <input type="text" class="primary_input_field total_price"
                                                        value="{{$subTotalAmount - $discountProductTotal + $tax}}" name="item_amount" readonly="readonly">

                                            </div>
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('purchase.Order Tax')}}</label>
                                                    <select onchange="billingInfo()" name="total_tax" id=""
                                                    class="primary_select  total_tax">
                                                        <option value="0-0">{{__('pos.No Tax')}}</option>
                                                        @foreach($taxes as $key=>$tax)
                                                            <option value="{{$tax->rate}}-{{ $tax->id }}" {{$quotation->total_vat == $tax->rate ? 'selected' : ''}}>{{$tax->rate}}%</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="primary_input grid_input total_discount_tr" @if ($quotation->total_discount == 0)
                                                 style="display: none;"
                                            @endif>
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.Discount')}}</label>
                                                    <input style="width: 100px !important" name="total_discount_amount" type="number" value="{{$quotation->total_discount}}"
                                                    class="primary_input_field total_discount_amount total_discount" readonly>

                                            </div>
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('purchase.Shipping Charge')}}</label>
                                                    <input onkeyup="billingInfo()" name="shipping_charge" type="number" step="0.01" value="{{$quotation->shipping_charge}}" class="primary_input_field billing_inputs shipping_charge">

                                            </div>
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('purchase.Other Charge')}}</label>
                                                    <input onkeyup="billingInfo()" name="other_charge" type="number" step="0.01" value="{{$quotation->other_charge}}" class="primary_input_field billing_inputs other_charge">

                                            </div>
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0" for="">{{__('sale.Payable Amount')}}</label>
                                                    <input type="text" value="{{$quotation->payable_amount}}" class="primary_input_field total_amount" name="total_amount" readonly>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                   for="">{{__("sale.Order Note")}} </label>
                                            <textarea class="summernote3" name="notes">{{ $quotation->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col-12 mt-3">
                                <div class="submit_btn text-center">
                                    <button class="primary-btn semi_large2 fix-gr-bg" onclick="fromSubmit()"><i class="ti-check"></i>{{__('quotation.Update Draft')}}</button>
                                    <button class="primary-btn semi_large2 fix-gr-bg" onclick="preview()"><i class="ti-eye"></i>{{__('quotation.Preview')}}</button>
                                    @if ($quotation->status == 1)
                                        <button class="primary-btn semi_large2 fix-gr-bg"><i class="ti-envelope"></i>{{__('quotation.Mail Already Sent')}}</button>
                                    @else
                                        <button class="primary-btn semi_large2 fix-gr-bg" onclick="approve_modal('{{route('quotation.send_mail', $quotation->id)}}')"><i class="ti-envelope"></i>{{__('quotation.Send Mail')}}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" name="quote_id" id="quote_id" value="{{$quotation->id}}">
        <input type="hidden" name="preview_status" id="preview_status" value="{{ Session::get('preview') }}">
        <input type="hidden" data-id="{{$quotation->id}}" value="{{urlShortener()}}" class="url">
        <div class="view_modal">

        </div>
    </div>
@include('backEnd.partials.approve_modal')
@endsection
@push("scripts")
    <script type="text/javascript">
        var baseUrl = $('#app_base_url').val();
        function productTax(id, type) {
            let product_tax = 0;
            $.each($('.tax'), function (index, value) {
                let amount = $(this).attr('net-sub-total');
                product_tax += parseFloat(amount);
            });
            if (product_tax > 0){
                $('.product_tax').show();
            }else{
                $('.product_tax').hide();
            }
            $('.product_tax_input').val(product_tax);
        }

        function calcutionTaxDiscount(tr){
            let taxParcentage = parseFloat(tr.find('.tax').val());
            let productPrice =  parseFloat(tr.find('.product_price ').val());
            let discount =  parseFloat(tr.find('.discount ').val());
            let qty =  parseInt(tr.find('.quantity').val());
            let discount_price = (productPrice * discount) / 100;
            let netSubTotal = (( productPrice - discount_price) * qty) * taxParcentage /100;
            tr.find('.tax').attr('net-sub-total',netSubTotal)
        }

        function productDiscount() {
            let product_discounts = 0;
            $.each($('.discount'), function (index, value) {
                let amount = $(this).val();
                let tr = $(this).parent().parent();
                let qty =  parseInt(tr.find('.quantity').val());
                let totalDiscount = amount * qty;
                product_discounts += parseInt(totalDiscount);
                calcutionTaxDiscount(tr);
                productTax(1,2)

            });
            if (product_discounts > 0){
                $('.product_discounts').show();
            }else{
                $('.product_discounts').hide();
            }
            $('.product_discounts').val(product_discounts);
        }

        $(document).ready(function () {
            if ($('#preview_status').val() == 1) {
                preview();
            }

            let delete_selector = $('.delete_product');

            if (delete_selector.length > 1) {
                delete_selector.show();
            } else {
                delete_selector.hide();
            }

            $(document).on('change', '.product_info', function () {
                let id = $(this).val();
                $.post('{{ route('quotation.product_modal_for_select') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id,
                }, function (data) {
                    if (data.product_type == "Variable") {
                        $('.view_modal').html(data.html);
                        $('#Item_Details').modal('show');
                    } else {
                        if (data.product_id != 1) {
                            $('#product_details').append(data.product_id);
                            $('select').niceSelect();
                            totalQuantity();
                            productDiscount();
                            totalQuantity();
                            SubTotal();
                            grandTotal();
                            billingInfo();
                            $('.last_price_td').show();
                        }
                    }
                    $('.charging_infos').show();
                });
            });

            $(document).on('click', '.delete_product', function () {
                var whichtr = $(this).closest("tr");
                var id = $(this).data('id');

                whichtr.remove();
                productDiscount();
                totalQuantity();
                SubTotal();
                grandTotal();
                billingInfo();

                $.ajax({
                    url : "{{route('item.session.delete')}}",
                    method : "POST",
                    data : {
                        id : id,
                        _toke : "{{csrf_token()}}"
                    },
                    success : function (result)
                    {
                        toastr.success(result.success);
                    }
                })
            });

            $(document).on('click', '.new_delete_product', function () {
                var whichtr = $(this).closest("tr");
                var id = $(this).data('id');
                var product = $(this).data('product');
                let quantity = $('.quantity' + id).val();
                whichtr.remove();
                productDiscount();
                totalQuantity();
                SubTotal();
                grandTotal();
                billingInfo();
                $.ajax({
                    method: "POST",
                    url: "{{route('item.delete')}}",
                    data: {
                        id: id,
                        quantity: quantity,
                        _token: "{{csrf_token()}}"
                    },
                    success: function (result) {
                        toastr.success(result);
                    }
                })
            });
        });

        function fromSubmit()
        {
            $('#form').submit();
        }

        function preview(){
            var id = $('#quote_id').val();
            $.post('{{ route('quotation.order.preview') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
                $('.view_modal').html(data);
                $('#PreviewEdit').modal('show');
                {{ Session::forget('preview') }};
            });
        }

        function productSubTotal(id, type) {
            let price = $(".product_price_" + type + id).val();
            let quantity = $('.quantity_' + type + id).val();
            let sub_total = price * quantity;
            $('.product_subtotal_' + type + id).text(sub_total);
        }

        function totalQuantity() {
            let total_quantity = 0;
            $.each($('.quantity'), function (index, value) {
                let amount = $(this).val();
                total_quantity += parseInt(amount);
            });

            if (total_quantity > 0 || !isNaN(total_quantity)) {
                $('.total_quantity').text(total_quantity);
                $('.total_quantity').val(total_quantity);
            } else {
                total_quantity = $('.total_quantity').text();
                $('.total_quantity').text(total_quantity);
                $('.total_quantity').val(total_quantity);
            }
        }

        function SubTotal() {
            let total_amount = 0;

            $.each($('.product_subtotal'), function (index, value) {
                let amount = $(this).text();
                total_amount += parseFloat(amount);
            });
            $('.total_sub_total').val(total_amount);
        }

        function grandTotal()
        {
            let amount = parseFloat($('.total_sub_total').val());
            let discount = parseFloat($('.product_discounts').val());
            let tax = parseFloat($('.product_tax_input').val());
            if (isNaN(tax))
                tax =0;
            let final_amount = parseFloat((amount + tax) - discount).toFixed(2) ;
            $('.total_price').val(final_amount);
        }
        $(document).on('input', '.tax', function () {
            let taxParcentage = parseFloat($(this).val());
            let tr = $(this).parent().parent();
            let productPrice =  parseFloat(tr.find('.product_price ').val());
            let discount =  parseFloat(tr.find('.discount ').val());
            let qty =  parseInt(tr.find('.quantity').val());
            let netSubTotal = (( productPrice - discount) * qty) * taxParcentage /100;
            $(this).attr('net-sub-total',netSubTotal)
            productTax(1,2)
        });
        $(document).on('change','.discount_type',function(){
            billingInfo()
        });

        function billingInfo() {
            //billing_info
            let total_discount = parseFloat($('.total_discount').val());
            let total_tax = parseFloat($('.total_tax').val());
            let shipping_charge = parseFloat($('.shipping_charge').val());
            let other_charge = parseFloat($('.other_charge').val());
            let total_amount = parseFloat($('.total_price').val());
            let calculated_total_tax = 0;
            let calculated_total_discount = 0;

            let discount_type = $('.discount_type').val();

            if (total_discount > 0) {
                $('.total_discount_tr').show();
                if (discount_type == 2) {
                    calculated_total_discount = parseFloat($(".total_price").val()) * total_discount / 100;
                } else {
                    calculated_total_discount = total_discount;
                }
            } else {
                $('.total_discount_tr').hide();
            }

            if (total_tax > 0) {
                calculated_total_tax = ((total_amount - calculated_total_discount) * total_tax) / 100;
            }
            $('.total_discount_amount').val(calculated_total_discount);

            let final_amount = parseFloat(((total_amount + calculated_total_tax + shipping_charge + other_charge)) - calculated_total_discount).toFixed(2);


            $('.total_amount').val(final_amount);
        }

        function priceCalc(id,type) {
            productSubTotal(id, type);
            productTax(id, type);
            productDiscount();
            totalQuantity();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addQuantity(id,type) {
            productSubTotal(id, type);
            totalQuantity();
            productTax(id, type);
            productDiscount();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addDiscount(id,type) {
            productSubTotal(id, type);
            totalQuantity();
            productTax(id, type);
            productDiscount();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addTax(id,type) {
            productSubTotal(id, type);
            totalQuantity();
            productTax(id, type);
            productDiscount();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function selectProduct(el) {
            let url = 'purchase/product_add';
            let type = 'quotation';

            $.ajax({
                method: 'POST',
                url: "{{url('/')}}" + '/' + url,
                data: {
                    id: el,
                    type: type,
                    _token: "{{csrf_token()}}",
                },
                success: function (data) {
                    if (data == 1)
                        toastr.error('this item is already added');
                    else {
                        $('#product_details').append(data);
                        $('select').niceSelect();

                        totalQuantity();
                        productDiscount();
                        SubTotal();
                        grandTotal();
                        billingInfo();
                    }
                }
            })
        }

        function saleDetails() {
            let customer_id = $('.contact_type').val();
            $.ajax({
                method: 'POST',
                url: "{{route('customer.details')}}",
                data: {
                    customer_id: customer_id,
                    _token: "{{csrf_token()}}",
                },

                success: function (result) {
                    $('.last_sale_price').text('$' + result.total_amount);
                    $('.last_sale_invoice').text(result.invoice_no);
                    if (result.invoice_no)
                        $('.sale_details').show()
                    else
                        $('.sale_details').hide();
                }
            })
        }

        function selectComboProduct(el) {
            let url = 'purchase/combo_product_add';
            $.ajax({
                method: 'POST',
                url: "{{url('/')}}" + '/' + url,
                data: {
                    id: el,
                    _token: "{{csrf_token()}}",
                },
                success: function (data) {
                    if (data == 1)
                        toastr.error('this item is already added');
                    else {
                        $('#product_details').append(data);
                        $('select').niceSelect();
                        totalQuantity();
                        productDiscount();
                        SubTotal();
                        grandTotal();
                        billingInfo();
                    }
                }
            })
        }

        function house()
        {
            let val = $('.house').val();

            $.ajax({
                method : 'POST',
                url : "{{route('check.existence')}}",
                data : {
                    _token : "{{csrf_token()}}",
                    val : val,
                },
                success : function (resutl){
                    $('.product_info').html(resutl);
                    $('select').niceSelect('update');
                }
            })
        }
    </script>
@endpush
