@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('purchase.Add Purchase Order')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <h4 class="text-danger customer_due pb-3"
                                        style="display: none">{{__('sale.Total Due')}}
                                        :<span class="balance_due"></span></h4>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 text-right">
                                    <h4 class="text-danger customer_invoice pb-3"
                                        style="display: none">{{__('sale.Last Invoice')}}
                                        :<a href="javascript:void(0)" data-toggle="modal" onclick="getDetails()"
                                            class="invoice_link"></a></h4>
                                </div>
                            </div>
                            <!-- Prefix  -->
                            <form action="{{route("purchase_order.store")}}" method="POST"
                                  enctype="multipart/form-data" id="addForm">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('purchase.Select Supplier')}} *</label>
                                            <select class="primary_select mb-15 contact_type"
                                                    onchange="purchaseDetails()" name="supplier_id" required>
                                                <option selected disabled>{{__('common.Select')}}</option>
                                                @foreach($suppliers as $supplier)
                                                    <option
                                                        value="{{$supplier->id}}" {{isset($supplier_id)  && $supplier_id == $supplier->id ? 'selected' : '' }}>{{$supplier->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('supplier_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('purchase.Select Warehouse or Branch')}} *</label>
                                            <select class="primary_select mb-15 house contact_type" name="showroom">
                                                @if (Auth::user()->role->type == "system_user")
                                                    <option selected disabled>{{__('common.Select')}}</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option
                                                            value="warehouse-{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                    @endforeach
                                                    @foreach($showrooms as $showroom)
                                                        <option
                                                            value="showroom-{{$showroom->id}}" {{session()->get('showroom_id') == $showroom->id ? 'selected' : ''}}> {{$showroom->name}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="showroom-{{ Auth::user()->staff->showroom_id }}"
                                                            selected> {{showroomName()}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Attach Document')}} <span class="text-muted">({{__('quotation.pdf,csv,jpg,png,doc,docx,xlsx,zip')}})</span></label>
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
                                            <span class="text-danger">{{$errors->first('documents')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('sale.Date') }} *</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text" name="date"
                                                                   value="{{date('m/d/Y')}}" autocomplete="off">
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
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                   for="">{{__("quotation.Shipping Address")}}</label>
                                            <input type="text" class="primary_input_field" name="shipping_address"
                                                   value="{{isset($purchase) && !empty($purchase) ? $purchase->shipping_address : old('shipping_address')}}">

                                            <span class="text-danger">{{$errors->first('shipping_address')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('sale.Reference No')}}</label>
                                            <input type="text" class="primary_input_field"
                                                   placeholder="{{__('sale.Reference No')}}" name="ref_no"
                                                   value="{{ old('ref_no') }}">
                                            <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('purchase.LC No.')}}</label>
                                            <input type="text" class="primary_input_field"
                                                   placeholder="{{__('purchase.LC No.')}}" name="lc_no"
                                                   value="{{ old('lc_no') }}">
                                            <span class="text-danger">{{$errors->first('lc_no')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('purchase.CNF Agent')}}</label>
                                            <select class="primary_select mb-15 house cnf_agent" name="cnf_agent">
                                                <option value="null">{{ __('purchase.choose one') }}</option>
                                                @foreach ($cnfs->where('status', 1) as $key => $cnf)
                                                    <option value="{{ $cnf->id }}">{{ $cnf->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('cnf_agent')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Discount')}}</label>
                                            <input onkeyup="billingInfo()" name="total_discount"
                                                   type="number" step="0.01"
                                                   value="0"
                                                   class="primary_input_field total_discount">
                                            <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Discount Type')}}</label>
                                            <select class="primary_select mb-15 discount_type"
                                                    onchange="billingInfo()" id="discount_type"
                                                    name="discount_type">
                                                <option value="1">{{ __('quotation.Amount') }}</option>
                                                <option value="2">{{ __('quotation.Percentage') }}</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('quotation.Select Product')}} *</label>
                                            <select class="primary_select mb-15 product_info" name="product">
                                                <option value="1">{{__('quotation.Select Product')}}</option>
                                                @foreach ($allProducts as $product)
                                                    <option
                                                        {{isset($item) && $item->productSku->product_id ==  $product->product_id ? 'selected' :''}} value="{{$product->product_id}}-{{ $product->product_type }}">{{$product->product_name}} @if (app('general_setting')->origin == 1 && $product->origin)
                                                            > {{ __('common.Part Number') }}
                                                            : {{ $product->origin }} @endif @if ($product->brand)
                                                            > {{ __('product.Brand') }}
                                                            : {{ $product->brand }} @endif @if ($product->brand)
                                                            > {{ __('product.Model') }}
                                                            : {{ $product->model }} @endif</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('product_id')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
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
                                    <div class="col-md-6 col-lg-6 col-sm-12 amount_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Amount')}}</label>
                                            <input type="text" name="amount[]"
                                                   class="primary_input_field amount_payment"
                                                   placeholder="Enter Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="row bank_info_div"
                                     @if(app('general_setting')->payment_gateway != 2 ) style="display: none" @endif>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <div class="primary_input mb-15"><label class="primary_input_label"
                                                                                for="">{{__('sale.Bank Name')}}</label><input
                                                type="text" name="bank_name[]" class="primary_input_field"
                                                placeholder="Bank Name"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <div class="primary_input mb-15"><label class="primary_input_label"
                                                                                for="">{{__('sale.Branch')}}</label><input
                                                type="text" name="branch[]" class="primary_input_field"
                                                placeholder="Branch"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <div class="primary_input mb-15"><label class="primary_input_label"
                                                                                for="">{{__('sale.Account No')}}</label><input
                                                type="text" name="account_no[]" class="primary_input_field"
                                                placeholder="Account No"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <div class="primary_input mb-15"><label class="primary_input_label"
                                                                                for="">{{__('sale.Account Owner')}}</label><input
                                                type="text" name="account_owner[]" class="primary_input_field"
                                                placeholder="Account Owner"></div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="20%" scope="col">{{__('sale.Product Name')}}</th>
                                        @if (app('general_setting')->origin == 1)
                                            <th width="10%" scope="col">{{__('common.Part Number')}}</th>
                                        @else
                                            <th width="10%" scope="col">{{__('sale.SKU')}}</th>
                                        @endif
                                        <th width="10%" scope="col">{{__('product.Model')}}</th>
                                        <th width="10%" scope="col">{{__('product.Brand')}}</th>
                                        <th width="10%" scope="col">{{__('sale.Price')}}</th>
                                        <th width="10%" scope="col">{{__('sale.Sell Price')}}</th>
                                        <th width="5%" scope="col">{{__('sale.Quantity')}}</th>
                                        <th width="5%" scope="col">{{__('sale.Tax')}} (%)</th>
                                        <th width="5%" scope="col">{{__('sale.Discount')}}</th>
                                        <th width="10%" scope="col">{{__('sale.SubTotal')}}</th>
                                        <th width="5%" scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    @php
                                        $total_quanity = $total_price = 0

                                    @endphp
                                    <tbody id="product_details">
                                    @if(isset($items))
                                        @foreach($items as $key => $item)
                                            @php
                                                $variantName = variantNameFromSku($item->productSku);

                                                $total_quanity++;
                                                $total_price += $item->productSku->purchase_price
                                            @endphp
                                            @php
                                                $type =$item->product_sku_id.",'sku'"
                                            @endphp
                                            <tr>
                                                <td><input type="hidden" name="product_id[]"
                                                           value="{{$item->product_sku_id}}">
                                                    {{$item->productSku->product->product_name}} <br>
                                                    @if ($variantName)
                                                        ({{ $variantName }})
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (app('general_setting')->origin == 1)
                                                        {{@$item->productable->product->origin}}
                                                    @else
                                                        {{@$item->productable->sku}}
                                                    @endif
                                                </td>
                                                <td>{{@$item->productable->product->model->name}}</td>
                                                <td>{{@$item->productable->product->brand->name}}</td>
                                                <td><input min="{{$item->productSku->purchase_price}}"
                                                           onkeyup="priceCalc({{$type}})"
                                                           class="primary_input_field product_price product_price_sku{{$item->product_sku_id}}"
                                                           type="number"
                                                           value="{{$item->productSku->purchase_price}}"
                                                           name="product_price[]"></td>
                                                <td><input min="{{$item->productSku->purchase_price}}"
                                                           class="primary_input_field product_selling_price product_selling_price_sku{{$item->product_sku_id}}"
                                                           type="number"
                                                           value="{{$item->productSku->selling_price}}"
                                                           name="product_selling_price[]"></td>
                                                <td>
                                                    <input type="number" onkeyup="addQuantity({{$type}})"
                                                           name="product_quantity[]" value="1"
                                                           class="primary_input_field quantity quantity_sku{{$item->product_sku_id}}">
                                                </td>

                                                <td>
                                                    <input type="number" name="product_tax[]" value="0"
                                                           onkeyup="addTax({{$type}})"
                                                           class="primary_input_field tax tax_sku'{{$item->product_sku_id}}">
                                                </td>
                                                <td>
                                                    <input type="number" onkeyup="addDiscount({{$type}})"
                                                           name="product_discount[]" value="0"
                                                           class="primary_input_field discount discount_sku{{$item->product_sku_id}}">
                                                </td>
                                                <td style="text-align:center"
                                                    class="product_subtotal product_subtotal_sku{{$item->product_sku_id}}">{{$item->productSku->purchase_price}}</td>
                                                <td><a data-id="{{$item->id}}" data-product="{{$item->id}}"
                                                       class="primary-btn primary-circle fix-gr-bg old_delete_product"
                                                       href="javascript:void(0)">
                                                        <i class="ti-trash"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tr>
                                </table>
                                <div class="col-12 mb-50">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="primary_input grid_input">
                                                <label class="font_13 theme_text f_w_500 mb-0"
                                                       for="">{{__('sale.Total Quantity')}}</label>
                                                <input type="number"
                                                       class="primary_input_field total_quantity"
                                                       value="0" name="total_quantity" readonly>

                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.SubTotal')}}</label>
                                            <input type="text"
                                                   class="primary_input_field total_sub_total"
                                                   value="0" name="item_amount" readonly="readonly">

                                        </div>
                                        <div class="primary_input grid_input product_discounts"
                                             style="display: none;">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Product Wise Discount')}}</label>

                                            <input type="text"
                                                   class="primary_input_field product_discounts"
                                                   value="0" name="item_amount" readonly="readonly">

                                        </div>
                                        <div class="primary_input grid_input product_tax" style="display: none;">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Product Wise Tax')}}</label>
                                            <input type="text"
                                                   class="primary_input_field product_tax product_tax_input"
                                                   value="0" name="item_amount" readonly="readonly">

                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Grand Total')}}</label>

                                            <input type="text"
                                                   class="primary_input_field total_price"
                                                   value="0" name="item_amount" readonly="readonly">

                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('purchase.Order Tax')}}</label>
                                            <select onchange="billingInfo()" name="total_tax" id=""
                                                    class="primary_select  total_tax">
                                                <option value="0-0">{{__('pos.No Tax')}}</option>
                                                @foreach($taxes as $key=>$tax)
                                                    <option value="{{$tax->rate}}-{{ $tax->id }}">{{$tax->rate}}
                                                        % {{$tax->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="primary_input grid_input total_discount_tr"
                                             style="display: none;">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Discount')}}</label>

                                            <input style="width: 100px !important" name="total_discount_amount"
                                                   type="number" value="0"
                                                   class="primary_input_field total_discount_amount total_discount"
                                                   readonly>

                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('purchase.Shipping Charge')}}</label>

                                            <input onkeyup="billingInfo()" name="shipping_charge" type="number"
                                                   step="0.01" value="0"
                                                   class="primary_input_field shipping_charge">

                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('purchase.Other Charge')}}</label>
                                            <input onkeyup="billingInfo()" name="other_charge" type="number"
                                                   step="0.01" value="0"
                                                   class="primary_input_field other_charge">

                                        </div>
                                        <div class="primary_input grid_input">
                                            <label class="font_13 theme_text f_w_500 mb-0"
                                                   for="">{{__('sale.Payable Amount')}}</label>
                                            <input type="text" value="0"
                                                   class="primary_input_field total_amount"
                                                   name="total_amount" readonly>

                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input">
                                    <label class="primary_input_label"
                                           for="">{{__("quotation.Order Note")}} </label>
                                    <textarea class="summernote3" name="notes"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="payment_modal"></div>
                        </form>
                        <div class="row mt-20 justify-content-center text-center">
                            <button type="button" onclick="approve_modal('{{route('purchase_order.index')}}')"
                                    class="primary-btn mr-2 fix-gr-bg mr-2"><i
                                    class="fa fa-times"></i> {{__('common.Cancel')}}</button>
                            <button type="button" class="primary-btn mr-2 fix-gr-bg reset_btn"><i
                                    class="fa fa-refresh"></i> {{ __('report.Reset') }}</button>
                            <button type="button"
                                    class="primary-btn mr-2 fix-gr-bg submit_btn">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <div class="getDetails w-100">

    </div>
    <input type="hidden" value="{{urlShortener()}}" class="url">
    <div class="view_modal">

    </div>
    @include('backEnd.partials.approve_modal')

    </div>
    @push("scripts")
        <script type="text/javascript">
            var baseUrl = $('#app_base_url').val();

            function productTax(id, type) {
                let product_tax = 0;
                $.each($('.tax'), function (index, value) {
                    let amount = $(this).attr('net-sub-total');
                    product_tax += parseFloat(amount);
                });
                if (product_tax > 0) {
                    $('.product_tax').show();
                } else {
                    $('.product_tax').hide();
                }
                $('.product_tax_input').val(product_tax);
            }

            function calcutionTaxDiscount(tr) {
                let taxParcentage = parseFloat(tr.find('.tax').val());
                let productPrice = parseFloat(tr.find('.product_price ').val());
                let discount = parseFloat(tr.find('.discount ').val());
                let qty = parseInt(tr.find('.quantity').val());
                let netSubTotal = ((productPrice - discount) * qty) * taxParcentage / 100;
                tr.find('.tax').attr('net-sub-total', netSubTotal)
            }

            function productDiscount() {
                let product_discounts = 0;
                $.each($('.discount'), function (index, value) {
                    let amount = $(this).val();
                    let tr = $(this).parent().parent();
                    let qty = parseInt(tr.find('.quantity').val());
                    let totalDiscount = amount * qty;
                    product_discounts += parseInt(totalDiscount);
                    calcutionTaxDiscount(tr);
                    productTax(1, 2)

                });
                if (product_discounts > 0) {
                    $('.product_discounts').show();
                } else {
                    $('.product_discounts').hide();
                }
                $('.product_discounts').val(product_discounts);
            }

            $(document).ready(function () {

                $(document).on('input', '.tax', function () {
                    let taxParcentage = parseFloat($(this).val());
                    let tr = $(this).parent().parent();
                    let productPrice = parseFloat(tr.find('.product_price ').val());
                    let discount = parseFloat(tr.find('.discount ').val());
                    let qty = parseInt(tr.find('.quantity').val());
                    let netSubTotal = ((productPrice - discount) * qty) * taxParcentage / 100;
                    $(this).attr('net-sub-total', netSubTotal)
                    productTax(1, 2)
                });


                $(document).on('change', '.discount_type', function () {
                    billingInfo()
                });

                $(document).on('change', '.product_info', function () {
                    let id = $(this).val();
                    $.post('{{ route('purchase.product_modal_for_select') }}', {
                        _token: '{{ csrf_token() }}',
                        id: id
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
                        }
                        $('.charging_infos').show();
                    });
                });

                $(document).on('click', '.delete_product', function () {
                    var whichtr = $(this).closest("tr");
                    var id = $(this).data('id');

                    whichtr.remove();
                    totalQuantity();
                    productTax();
                    productDiscount();
                    totalQuantity();
                    SubTotal();
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

                $(document).on('change', '#paying_method', function () {
                    let value = $(this).val();

                    if (value == 'cheque')
                        $('.cheque').show()
                    else
                        $('.cheque').hide()
                })

                $(document).on('click', '.reset_btn', function () {
                    window.location.reload();
                })
                $(document).on('click', '.submit_btn', function () {
                    var customer_id = $('.contact_type').val();
                    if (customer_id != null) {
                        $('#addForm').submit();
                    } else {
                        toastr.error("Please Select Supplier First");
                    }
                })
            });


            // function productTax(id, type) {
            // let product_tax = 0;
            // let sub_total = $('.product_subtotal_' + type + id).text();
            // $.each($('.tax'), function (index, value) {
            //     let amount = $(this).val();
            //     product_tax += parseFloat(amount);
            // });
            // if (product_tax > 0)
            //     $('.product_tax').show();
            // else
            //     $('.product_tax').hide();
            // let amount = (parseFloat(sub_total) * product_tax) / 100;
            // $('.product_tax').val(amount);
            // }

            // function productDiscount() {
            //     let product_discounts = 0;
            //     $.each($('.discount'), function (index, value) {
            //         let amount = $(this).val();
            //         product_discounts += parseInt(amount);
            //     });
            //     if (product_discounts > 0)
            //         $('.product_discounts').show();
            //     else
            //         $('.product_discounts').hide();
            //     $('.product_discounts').val(product_discounts);
            // }

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

            function billingInfo() {
                //billing_info
                let total_discount = parseFloat($('.total_discount').val());
                let total_tax = parseFloat($('.total_tax').val());
                let shipping_charge = parseFloat($('.shipping_charge').val());
                let other_charge = parseFloat($('.other_charge').val());
                let total_amount = parseFloat($('.total_price').val());
                let calculated_total_tax = 0;
                let calculated_total_discount = 0;
                if (total_tax > 0) {
                    calculated_total_tax = ((total_amount) * total_tax) / 100;
                }
                let discount_type = $('.discount_type').val();

                if (total_discount > 0) {
                    $('.total_discount_tr').show();
                    if (discount_type == 2) {
                        calculated_total_discount = parseFloat($(".total_price").val()) * total_discount / 100;
                    } else {
                        calculated_total_discount = total_discount;
                    }
                } else
                    $('.total_discount_tr').hide();

                $('.total_discount_amount').val(calculated_total_discount);

                let final_amount = parseFloat(((total_amount + calculated_total_tax + shipping_charge + other_charge) - calculated_total_discount)).toFixed(2);
                $('.total_amount').val(final_amount);
            }

            function priceCalc(id, type) {
                let price = $(".product_price_" + type + id).val();
                let quantity = $('.quantity_' + type + id).val();

                let sub_total = (price * quantity);
                $('.product_subtotal_' + type + id).text(sub_total);
                productTax(id, type);
                productDiscount();
                totalQuantity();
                SubTotal();
                grandTotal();
                billingInfo();
            }

            function addQuantity(id, type) {
                let price = $(".product_price_" + type + id).val();
                let quantity = $('.quantity_' + type + id).val();

                let sub_total = (price * quantity);
                $('.product_subtotal_' + type + id).text(sub_total);
                let tr = $('.quantity_' + type + id).parent().parent();
                calcutionTaxDiscount(tr);
                totalQuantity();
                productTax(id, type);
                productDiscount();
                totalQuantity();
                SubTotal();
                grandTotal();
                billingInfo();
            }

            function addDiscount(id, type) {
                let price = $('.product_price_' + type + id).val();
                let quantity = $('.quantity_' + type + id).val();
                let sub_total = price * quantity;
                $('.product_subtotal_' + type + id).text(sub_total);
                totalQuantity();
                productTax(id, type);
                productDiscount();
                totalQuantity();
                SubTotal();
                grandTotal();
                billingInfo();
            }

            function addTax(id, type) {
                let price = $('.product_price_' + type + id).val();
                let quantity = $('.quantity_' + type + id).val();

                let sub_total = price * quantity;
                // $('.product_subtotal_' + type + id).text(sub_total);
                totalQuantity();
                productTax(id, type);
                productDiscount();
                totalQuantity();
                SubTotal();
                grandTotal();
                billingInfo();
            }

            function deliveryInfo() {
                let value = $('#sale_type').val();
                if (value == '0') {
                    $('.delivery_info').show();
                } else
                    $('.delivery_info').hide();
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

            $('#sale_form').submit(function (e) {
                let margin_price = $('.sale_margin_price').val();
                let total_price = $('.total_amount').val();
                if (!total_price)
                    total_price = 0;
                if (parseFloat(margin_price) > parseFloat(total_price)) {

                    if (confirm('Sale Price is Below Margin Price'))
                        return true;
                    else {
                        e.preventDefault(e);
                        return false;
                    }
                }
                // return false; // will halt submission


            })

            function paymentModal() {
                let method = $('.payment_method').val();
                let supplier = $('.contact_type option:selected').text();
                let total_amount = $('.total_amount').val();
                let total_quantity = $('.total_quantity').val();

                $.ajax({
                    url: "{{route('purchase_multiple_payment')}}",
                    method: "POST",
                    data: {
                        type: method,
                        _token: "{{csrf_token()}}",
                        supplier: supplier,
                        total_amount: total_amount,
                        total_qty: total_quantity,
                    },
                    success: function (result) {
                        $('.payment_modal').html(result);
                        $('#Pos_Payment_Multiple').modal('show');
                        $('select').niceSelect();
                    }
                })
            }

            function getDetails() {
                let supplier_id = $('.contact_type').val();
                $.post('{{ route('get_purchase_details') }}', {
                    _token: '{{ csrf_token() }}',
                    supplier_id: supplier_id
                }, function (data) {
                    $('.getDetails').html(data);
                    $('#purchase_info_modal').modal('show');
                    $('select').niceSelect();
                });
            }

            function purchaseDetails() {
                let supplier_id = $('.contact_type').val();

                $.ajax({
                    method: 'POST',
                    url: "{{route('supplier.purchase.details')}}",
                    data: {
                        supplier_id: supplier_id,
                        _token: "{{csrf_token()}}",
                    },

                    success: function (result) {
                        if (result.due) {
                            $('.customer_due').show();
                            $('.balance_due').text(' ' + result.due);
                        }

                        if (result.url) {
                            $('.customer_invoice').show();
                            $('.invoice_link').text(' ' + result.invoice);
                        }
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
@endsection
