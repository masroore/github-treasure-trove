@extends('backEnd.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('backEnd/css/custom.css')}}"/>
@endpush
@section('mainContent')
    @include("backEnd.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            @if(request()->is("quotation/quotation-sale-convert/{$sale->id}"))
                                <h3 class="mb-0 mr-30">{{__('quotation.Convert To Sale')}}</h3>
                            @else
                                <h3 class="mb-0 mr-30">{{__('quotation.Clone to Sale')}}</h3>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <!-- Prefix  -->
                        <form action="{{route("sale.quotation_to_store")}}" method="POST" enctype="multipart/form-data" id="saleForm">
                            @csrf
                            <input type="hidden" name="quotation_id" value="{{ $sale->id }}">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Date')}} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="date" type="text" name="date"
                                                               value="{{ date('m/d/Y', strtotime($sale->date)) }}"
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
                                        <label class="primary_input_label"
                                               for="">{{__('sale.Select Retailer or Customer')}}
                                            *</label>
                                        <select class="primary_select mb-15 contact_type" name="customer_id">
                                            <option selected disabled>{{__('sale.Select')}}</option>
                                            @foreach($customers as $customer)
                                                <option
                                                    value="customer-{{$customer->id}}" {{$customer->id == $sale->customer_id ? 'selected' : ''}}>{{$customer->name}}</option>
                                            @endforeach
                                            
                                        </select>
                                        <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('sale.Select Warehouse or Branch')}} *</label>
                                        <select class="primary_select mb-15 house contact_type" onchange="house()"
                                                name="warehouse_id">
                                            @if (Auth::user()->role->type == "system_user")
                                                <option selected disabled>{{__('common.Select')}}</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option
                                                        value="warehouse-{{$warehouse->id}}" {{$warehouse->id == $sale->quotationable_id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                                @endforeach
                                                @foreach($showrooms as $showroom)
                                                    <option
                                                        value="showroom-{{$showroom->id}}" {{$showroom->id == $sale->quotationable_id ? 'selected' : ''}}>{{$showroom->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="showroom-{{ $sale->quotationable_id }}"
                                                        selected> {{showroomName()}}</option>
                                            @endif
                                        </select>
                                        <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('common.PO')}} {{__('common.No')}}</label>
                                        <input type="text" class="primary_input_field"
                                               placeholder="{{__('common.PO')}} {{__('common.No')}}" name="ref_no"
                                               value="{{ $sale->ref_no }}">
                                        <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                    </div>
                                </div>
                                @php
                                    if (Modules\Sale\Entities\Sale::latest()->first()) {
                                        $aid = Modules\Sale\Entities\Sale::latest()->first()->id + 1;
                                    }else {
                                        $aid = 1;
                                    }
                                @endphp
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('sale.Invoice')}} {{__('common.No')}} *</label>
                                        <input type="text" class="primary_input_field"
                                               placeholder="{{__('sale.Invoice')}} {{__('common.No')}}"
                                               name="invoice_no"
                                               value="{{ \Modules\Setup\Entities\IntroPrefix::find(3)->prefix . '-' . date('y') . date('m').Auth::id().$aid }}"
                                               required>
                                        <span class="text-danger">{{$errors->first('invoice_no')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Discount')}}</label>
                                        <input onkeyup="billingInfo()" name="total_discount"
                                               type="number" step="0.01"
                                               value="{{$sale->discount_amount}}"
                                               class="primary_input_field billing_inputs total_discount">
                                        <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('quotation.Discount Type')}}
                                            *</label>
                                        <select class="primary_select mb-15 discount_type" onchange="billingInfo()"
                                                id="discount_type" name="discount_type">
                                            <option value="1"
                                                    @if ($sale->discount_type == 1) selected @endif>{{ __('quotation.Amount') }}</option>
                                            <option value="2"
                                                    @if ($sale->discount_type == 2) selected @endif>{{ __('quotation.Percentage') }}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Sale Type')}} *</label>
                                        <select class="primary_select mb-15 sale_type" id="sale_type" name="sale_type">
                                            <option value="1">{{ __('sale.Regular Sale') }}</option>
                                            <option value="2" {{request()->is('conditional-sale/create') ? 'selected' : ''}}>{{ __('sale.Conditional Sale') }}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('sale_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Payment Method')}}
                                            *</label>
                                        <select class="primary_select mb-15 payment_method" name="payment_method[]"
                                                onchange="showDiv()">
                                            <option value="due-00">{{__('sale.Due')}}</option>
                                            <option
                                                value="cash-00" {{app('general_setting')->payment_gateway == 1 ? 'selected' : ''}}>{{__('pos.Cash')}}</option>
                                            @foreach (\Modules\Account\Entities\ChartAccount::where('configuration_group_id', 2)->get() as $bank_account)
                                                <option
                                                    value="bank-{{ $bank_account->id }}" {{app('general_setting')->payment_gateway == 2 ? 'selected' : ''}}>{{ $bank_account->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 amount_div">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Amount')}}</label>
                                        <input type="text" name="amount[]" class="primary_input_field amount_payment" placeholder="Enter Amount">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Select Product')}}</label>
                                        <select class="primary_select mb-15 product_info" id="product_info"
                                                name="product">
                                            <option value="1">{{__('sale.Select Product')}}</option>
                                            @foreach ($allProducts as $product)
                                                <option value="{{$product->product_id}}-{{ $product->product_type }}">{{$product->product_name}} @if (app('general_setting')->origin == 1 && $product->origin) > {{ __('common.Part Number') }} : {{ $product->origin }} @endif @if ($product->brand_name) > {{ __('product.Brand') }} : {{ $product->brand_name }} @endif @if ($product->model_name) > {{ __('product.Model') }} : {{ $product->model_name }} @endif</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('product_id')}}</span>
                                    </div>
                                </div>
                            </div>
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th width="20%" scope="col">{{__('sale.Product Name')}}</th>
                                    <th scope="col" width="10%">{{__('sale.SKU')}}</th>
                                    @if (app('general_setting')->origin == 1)
                                        <th scope="col" width="10%">{{__('common.Part Number')}}</th>
                                    @endif
                                    <th scope="col">{{__('product.Model')}}</th>
                                    <th scope="col">{{__('product.Brand')}}</th>
                                    <th class="d-none" scope="col">{{__('common.Serial No')}}</th>
                                    <th scope="col">{{__('sale.Price')}}</th>
                                    <th class="last_price" scope="col"><a href="javascript:void(0)" onclick="invoiceDetail()">{{__('sale.Last Price')}}</a></th>
                                    <th scope="col">{{__('sale.Quantity')}}</th>
                                    <th scope="col">{{__('sale.Tax')}} (%)</th>
                                    <th scope="col">{{__('sale.Discount')}}</th>
                                    <th scope="col">{{__('sale.SubTotal')}}</th>
                                    <th scope="col">{{__('common.Action')}}</th>
                                </tr>
                                </thead>
                                @php
                                    $sub_total = 0;
                                    $vat = 0;
                                @endphp
                                <tbody id="product_details">
                                @foreach($sale->items as $key=> $item)
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
                                            <td>{{@$item->productable->sku}}</td>
                                            <input class="product_min_price_sku{{$item->product_sku_id}}" type="hidden" value="{{ $item->productSku->min_selling_price}}">
                                            @if (app('general_setting')->origin == 1)
                                                <td>{{@$item->productable->product->origin}}</td>
                                            @endif
                                            <td>{{@$item->productable->product->model->name}}</td>
                                            <td>{{@$item->productable->product->brand->name}}</td>
                                            <td class="d-none">
                                                <select class="primary_select mb-15 sale_type" id="item_serial_no" name="item_serial_no[]" multiple>
                                                    @foreach ($item->productable->part_numbers as $part_number)
                                                        <option value="{{ $part_number->id }}" @if ($item->part_number_details->where('part_number_id', $part_number->id)->first()) selected @endif>{{ $part_number->seiral_no }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input min="{{$item->productSku->purchase_price}}"
                                                       onkeyup="priceCalc({{$type}})"
                                                       class="primary_input_field product_price product_price_sku{{$item->product_sku_id}}"
                                                       type="number"
                                                       value="{{$item->price}}" name="item_price[]"></td>
                                            <td></td>
                                            <td>
                                                <input type="number" onkeyup="addQuantity({{$type}})"
                                                       name="item_quantity[]" value="{{$item->quantity}}"
                                                       class="primary_input_field quantity quantity_sku{{$item->product_sku_id}}">
                                            </td>
                                            <td>
                                                <input type="number" name="product_tax[]" onkeyup="addTax({{$type}})"
                                                       value="{{$item->tax}}" net-sub-total="{{ ($item->price - $item->discount) * $item->quantity * $item->tax  / 100 }}"
                                                       class="primary_input_field tax tax{{$item->product_sku_id}}">
                                            </td>
                                            <td>
                                                <input type="number" onkeyup="addDiscount({{$type}})"
                                                       name="item_discount[]" value="{{$item->discount}}"
                                                       class="primary_input_field discount discount_sku{{$item->product_sku_id}}">
                                            </td>
                                            <td style="text-align: center;"
                                                class="product_subtotal product_subtotal_sku{{$item->product_sku_id}}">{{$item->price * $item->quantity}}</td>
                                            <td><a data-id="{{$item->id}}" data-product="{{$item->id}}"
                                                   class="primary-btn primary-circle fix-gr-bg new_delete_product"
                                                   href="javascript:void(0)">
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

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="product_sku"><input
                                                    class="product_min_price_sku{{$item->productable_id}}"
                                                    type="hidden"
                                                    value="{{ $item->productable->min_selling_price}}"
                                                ></td>

                                            <td>
                                                <select class="primary_select mb-15 sale_type" id="combo_item_serial_no" name="combo_item_serial_no[]" multiple>
                                                    @foreach ($item->productable->combo_products as $key => $combo_product)
                                                        @foreach ($combo_product->productSku->part_numbers as $part_number)
                                                            <option value="{{ $item->productable_id }}-{{ $part_number->id }}-{{ $combo_product->product_sku_id }}" @if ($item->part_number_details->where('part_number_id', $part_number->id)->first()) selected @endif>{{ $part_number->seiral_no }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input min="{{$item->productSku->purchase_price}}"
                                                       onkeyup="priceCalc({{$type}})"
                                                       class="primary_input_field product_price product_price_combo{{$item->product_sku_id}}"
                                                       type="number"
                                                       value="{{$item->price}}" name="combo_item_price[]"></td>
                                            <td></td>

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
                                            <td style="text-align: center" class="product_subtotal product_subtotal_combo{{$item->product_sku_id}}"> {{$item->sub_total}} </td>
                                            <td><a data-id=" {{$item->id}} " data-product="{{$item->id}}-combo"
                                                   class="primary-btn primary-circle fix-gr-bg new_delete_product" href="javascript:void(0)"><i
                                                        class="ti-trash"></i></a></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <input type="hidden" class="total_price"
                                   value="{{ $sale->amount}}"
                                   name="item_amount">
                            <div class="col-12 mb-50">
                                <div class="row justify-content-end">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Total Quantity')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input type="number"
                                                       class="primary_input_field billing_inputs total_quantity"
                                                       value="{{$sale->total_quantity}}" name="total_quantity" readonly>
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.SubTotal')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input type="text"
                                                       class="primary_input_field billing_inputs total_sub_total"
                                                       value="{{$sub_total}}" name="item_amount" readonly="readonly">
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input product_discounts"
                                             @if ($sale->items->sum('discount') == 0)
                                             style="display: none;"
                                            @endif >
                                            @php
                                                $totalProductwiseDiscount = 0;
                                                foreach ($sale->items as $key => $itemData) {
                                                    $totalProductwiseDiscount += $itemData->quantity * $itemData->discount;
                                                }
                                            @endphp
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Product Wise Discount')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input type="text"
                                                       class="primary_input_field billing_inputs product_discounts"
                                                       value="{{$totalProductwiseDiscount}}" name="item_amount"
                                                       readonly="readonly">
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input product_tax"
                                             @if ($sale->items->sum('tax') == 0)
                                             style="display: none;"
                                            @endif >
                                            @php
                                                $totalProductwiseTax = 0;
                                                foreach ($sale->items as $key => $itemData) {
                                                    $totalProductwiseTax += ($itemData->price - $itemData->discount) * $itemData->quantity * $itemData->tax  / 100;
                                                }
                                            @endphp
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Product Wise Tax')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input type="text"
                                                       class="primary_input_field billing_inputs product_tax product_tax_input"
                                                       value="{{$totalProductwiseTax}}" name="item_amount" readonly="readonly">
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Grand Total')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input type="text"
                                                       class="primary_input_field billing_inputs total_price"
                                                       value="{{$sale->amount}}" name="item_amount" readonly="readonly">
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('purchase.Order Tax')}}</label>
                                            <select onchange="billingInfo()" name="total_tax" id=""
                                                    class="primary_select  total_tax">
                                                <option value="0-0">{{__('pos.No Tax')}}</option>
                                                @foreach($taxes as $key=>$tax)
                                                    <option value="{{$tax->rate}}-{{ $tax->id }}" {{$sale->total_vat == $tax->rate ? 'selected' : ''}}>{{$tax->rate}}%
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="primary_input grid_input total_discount_tr"
                                             @if ($sale->total_discount == 0)
                                             style="display: none;"
                                            @endif>
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Discount')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input style="width: 100px !important" name="total_discount_amount"
                                                       type="number" value="{{$sale->total_discount}}"
                                                       class="primary_input_field total_discount_amount total_discount billing_inputs"
                                                       readonly>
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('purchase.Shipping Charge')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input onkeyup="billingInfo()" name="shipping_charge" type="number"
                                                       step="0.01" value="{{$sale->shipping_charge}}"
                                                       class="primary_input_field billing_inputs shipping_charge">
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('purchase.Other Charge')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input onkeyup="billingInfo()" name="other_charge" type="number"
                                                       step="0.01" value="{{$sale->other_charge}}"
                                                       class="primary_input_field billing_inputs other_charge">
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Payable Amount')}}</label>
                                            <div class="input-group primary_input_coupon">
                                                <input type="text" value="{{$sale->payable_amount}}"
                                                       class="primary_input_field billing_inputs total_amount"
                                                       name="total_amount" readonly>
                                                <div class="input-group-append">
                                                    <button></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{__("sale.Order Note")}} </label>
                                        <textarea class="summernote3" name="notes">{{$sale->notes}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-3">
                            <div class="submit_btn text-center">
                                <button class="primary-btn semi_large2 fix-gr-bg" onclick="fromSubmit()"><i
                                        class="ti-check"></i>{{__('common.Update')}}</button>
                                <button class="primary-btn semi_large2 fix-gr-bg" data-toggle="modal"
                                        data-target="#preview"><i class="ti-eye"></i>{{__('quotation.Preview')}}
                                </button>
                                @if ($sale->mail_status == 1)
                                    <button class="primary-btn semi_large2 fix-gr-bg"><i
                                            class="ti-envelope"></i>{{__('quotation.Mail Already Sent')}}</button>
                                @else
                                    <button class="primary-btn semi_large2 fix-gr-bg"
                                            onclick="approve_modal('{{route('sale.send_mail', $sale->id)}}')"><i
                                            class="ti-envelope"></i>{{__('quotation.Send Mail')}}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="id" id="sale_id" value="{{$sale->id}}">
    <input type="hidden" name="preview_status" id="preview_status" value="{{ Session::get('previewSale') }}">
    <input type="hidden" data-id="{{$sale->id}}" value="{{urlShortener()}}" class="url">
    <div class="modal fade admin-query" id="preview">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    @php
                        $setting = app('general_setting');
                    @endphp
                    <div class="container-fluid p-0">
                        <div class="row pb-30 border-bottom">
                            <div class="col-md-6">
                                <img src="{{asset($setting->logo ?? 'uploads/settings/infix.png')}}" width="100px"
                                     alt="">
                            </div>
                            <div class="col-md-6 text-right">
                                <h4>{{$sale->invoice_no}}</h4>
                            </div>
                        </div>
                        <div class="row pt-30">
                            <div class="col-md-4 col-lg-4">
                                <table class="table-borderless">
                                    <tr>
                                        <td>{{__('quotation.Date')}}</td>
                                        <td>{{date(app('general_setting')->dateFormat->format, strtotime($sale->created_at))}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('quotation.Reference No')}}</td>
                                        <td>{{$sale->ref_no}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4 col-lg-4">
                            </div>

                            <div class="col-md-4 col-lg-4">
                                <table class="table-borderless">
                                    <tr>
                                        <td><b>{{__('sale.Company')}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('sale.Company')}}</td>
                                        <td>{{$setting->company_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.Phone')}}</td>
                                        <td><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.Email')}}</td>
                                        <td><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('sale.Website')}}</td>
                                        <td><a href="#">infix.pos.com</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <table class="table-borderless">
                                    <tr>
                                        <td><b>{{__('sale.Billed To')}}</b></td>
                                    </tr>

                                    @php
                                        $name = $sale->customer ? $sale->customer->name : $sale->agentuser->name;
                                        $mobile = $sale->customer ? $sale->customer->mobile : $sale->agentuser->username;
                                        $email = $sale->customer ? $sale->customer->email : $sale->agentuser->email;
                                    @endphp
                                    <tr>
                                        <td>{{__('common.Name')}}:</td>
                                        <td>{{@$name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.Phone')}}:</td>
                                        <td>
                                            <a href="tel:{{@$mobile}}">{{@$mobile}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.Email')}}</td>
                                        <td>
                                            <a href="mailto:{{@$email}}">{{@$email}}</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="col-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table class="table Crm_table_active3">
                                                <tr class="m-0">
                                                    <th scope="col">{{__('sale.Product Name')}}</th>
                                                    <th scope="col">{{__('sale.SKU')}}</th>
                                                    <th scope="col">{{__('sale.Price')}}</th>
                                                    <th width="10%" style="display: none;" class="last_price"
                                                        scope="col"><a
                                                            href="javascript:void(0)"
                                                            onclick="invoiceDetail()">{{__('sale.Last Price')}}</a></th>
                                                    <th scope="col">{{__('sale.Quantity')}}</th>
                                                    <th scope="col">{{__('sale.Tax')}}</th>
                                                    <th scope="col">{{__('sale.Discount')}}</th>
                                                    <th scope="col" class="text-right">{{__('sale.SubTotal')}}</th>
                                                </tr>

                                                @foreach($sale->items as $key=> $item)
                                                    @php
                                                        $variantName = variantName($item);
                                                    @endphp

                                                    @if ($item->productable->product)
                                                        @php
                                                            $type =$item->product_sku_id.",'sku'" ;
                                                        @endphp
                                                        <tr>
                                                            <td><input type="hidden" name="items[]"
                                                                       value="{{$item->product_sku_id}}">
                                                                {{$item->productable->product->product_name}}
                                                                <br>
                                                                @if ($variantName)
                                                                    ({{ $variantName }})
                                                                @endif
                                                            </td>


                                                            <td>{{$item->productable->sku}}</td>
                                                            <td>{{single_price($item->price)}}</td>
                                                            <td>{{$item->quantity}}</td>
                                                            <td>{{$item->tax}}%</td>
                                                            <td>{{$item->discount}}%</td>
                                                            <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                        </tr>
                                                    @else
                                                        @php
                                                            $type =$item->product_sku_id.",'combo'" ;
                                                        @endphp
                                                        <tr>
                                                            <td>{{$item->productable->name}}
                                                                <br> {!!$variantName!!}
                                                            </td>

                                                            <td class="product_sku"><input
                                                                    class="product_min_price_combo{{$item->productable_id}}"
                                                                    type="hidden"
                                                                    value="{{ $item->productable->min_selling_price}}"
                                                                ></td>


                                                            <td>{{single_price($item->price)}}</td>

                                                            <td>{{$item->quantity}}</td>

                                                            <td>{{$item->tax}}%</td>

                                                            <td>{{$item->discount}}%</td>
                                                            <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tfoot>
                                                @php
                                                    $subtotal = $sale->items->sum('price') * $sale->items->sum('quantity');
                                                    $tax = ($subtotal * $sale->items->sum('tax'))/100;
                                                    if ($sale->discount_type == 2)
                                                        $discount = ($sale->amount * $sale->total_discount) / 100;
                                                    else
                                                        $discount = $sale->total_discount;
                                                    $vat =($sale->amount * $sale->total_tax) / 100;
                                                @endphp
                                                @php
                                                    $paid =0;
                                                @endphp
                                                <tr>
                                                    <td colspan="6" class="text-right">
                                                        <ul>
                                                            <li>{{__('quotation.SubTotal')}}
                                                                :</li>
                                                            <li>{{__('sale.Product Wise Discount')}}
                                                                :
                                                            </li>
                                                            <li>{{__('sale.Product Wise Tax')}}
                                                                :
                                                            </li>
                                                            <li>{{__('purchase.Order Tax')}}
                                                                :
                                                            </li>
                                                            <li>{{__('purchase.Order Discount')}}
                                                                :</li>
                                                            <li class="border-top-0">{{__('sale.Total Amount')}}
                                                                :</li>

                                                            <li class="border-top-0">{{__('sale.Total Due')}}
                                                                :</li>
                                                        </ul>
                                                    </td>
                                                    <td class="text-right">
                                                        <ul>

                                                            <li>{{single_price($sale->amount)}}</li>
                                                            <li>{{single_price($sale->items->sum('discount'))}}
                                                            </li>
                                                            <li>{{single_price($tax)}}
                                                            </li>
                                                            <li>{{$vat}}
                                                            </li>
                                                            <li>{{single_price($discount)}}</li>
                                                            <li class="border-top-0">{{single_price($sale->payable_amount)}}</li>

                                                            <li class="border-top-0">{{single_price($sale->payable_amount - $paid)}}</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($sale->notes)
                                <div class="col-6 mt-10">
                                    <h3>{{__('sale.Sale Note')}}</h3>
                                    <p>{!! $sale->notes !!}</p>
                                </div>
                            @endif
                            @if (app('general_setting')->terms_conditions)
                                <div class="col-6 mt-10">
                                    <h3>{{__('setting.Terms & Condition')}}</h3>
                                    <p>{{app('general_setting')->terms_conditions}}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="view_modal">

    </div>
    <div class="invoice_details w-100">

    </div>
    @include('backEnd.partials.approve_modal')
@endsection
@push("scripts")
    <script type="text/javascript">
        var baseUrl = $('#app_base_url').val();

        function fromSubmit() {
            $('#saleForm').submit();
        }
        function preview(){
            var id = $('#sale_id').val();
            $.post('{{ route('sale.order.preview') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
                $('.view_modal').html(data);
                $('#PreviewEdit').modal('show');
                {{ Session::forget('previewSale') }};
            });
        }
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
                let discountPercentage = $(this).val();
                let tr = $(this).parent().parent();
                let qty =  parseInt(tr.find('.quantity').val());
                let product_price =  parseInt(tr.find('.product_price').val());
                let discount_amount = product_price * discountPercentage / 100;

                let totalDiscount = discount_amount * qty;
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
            let delete_selector = $('.delete_product');

            if (delete_selector.length > 1) {
                delete_selector.show();
            } else {
                delete_selector.hide();
            }

            $(document).on('change', '.product_info', function () {
                let id = $(this).val();
                let customer = $('.contact_type').val();
                $.post('{{ route('sale.product_modal_for_select') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    customer: customer,
                }, function (data) {
                    if (data.product_type == "Variable") {
                        $('.view_modal').html(data.html);
                        $('#Item_Details').modal('show');
                    } else {
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
                    url: "{{route('item.session.delete')}}",
                    method: "POST",
                    data: {
                        id: id,
                        _toke: "{{csrf_token()}}"
                    },
                    success: function (result) {
                        toastr.success(result.success);
                    }
                })
            });

            $(document).on('click', '.new_delete_product', function () {
                var whichtr = $(this).closest("tr");
                var id = $(this).data('id');
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

        function grandTotal() {
            let amount = parseFloat($('.total_sub_total').val());
            let discount = parseFloat($('.product_discounts').val());
            let tax = parseFloat($('.product_tax_input').val());
            if (isNaN(tax))
                tax = 0;
            let final_amount = parseFloat((amount + tax) - discount).toFixed(2);
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

        function priceCalc(id, type) {
            let price = $(".product_price_" + type + id).val();
            let min_price = $(".product_min_price_" + type + id).val();
            if (price < min_price)
                $(".product_price_" + type + id).addClass('red_border');
            else
                $(".product_price_" + type + id).removeClass('red_border');
            productSubTotal(id, type);
            productTax(id, type);
            productDiscount();
            totalQuantity();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addQuantity(id, type) {
            let quantity = $('.quantity_' + type + id).val();
            let house = $('.house').val();
            let datatype = $('.quantity_' + type + id).data('type');

            $.ajax({
                method: 'POST',
                url: "{{route('check.quantity')}}",
                data: {
                    id: id,
                    type: datatype,
                    house: house,
                    quantity: quantity
                },
                success: function (result) {
                    if (result.stock){
                        toastr.error(result.msg);
                        $('.quantity_' + type + id).val(result.stock);
                    }
                    else {
                        productSubTotal(id, type);
                        totalQuantity();
                        productTax(id, type);
                        productDiscount();
                        SubTotal();
                        grandTotal();
                        billingInfo();
                    }
                }
            })
        }

        function addDiscount(id, type) {
            productSubTotal(id, type);
            totalQuantity();
            productTax(id, type);
            productDiscount();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addTax(id, type) {
            productSubTotal(id, type);
            totalQuantity();
            productTax(id, type);
            productDiscount();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function selectProduct(el) {
            let url = 'sale/product_add';
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

        function house() {
            let val = $('.house').val();

            $.ajax({
                method: 'POST',
                url: "{{route('check.existence')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    val: val,
                },
                success: function (resutl) {
                    $('.product_info').html(resutl);
                    $('select').niceSelect('update');
                }
            })
        }


        function showDiv() {
            if ($('.payment_method').val().split('-')[0] == 'bank') {
                $('.amount_div').show();
                $('.bank_info_div').show();
                $('.amount_payment').removeAttr('disabled');
            } else if ($('.payment_method').val().split('-')[0] == 'cash') {
                $('.amount_div').show();
                $('.bank_info_div').hide();
                $('.amount_payment').removeAttr('disabled');
            } else {
                $('.amount_div').hide();
                $('.bank_info_div').hide();
                $('.amount_payment').attr('disabled', 'disabled');
            }
        }
        
    </script>
@endpush
