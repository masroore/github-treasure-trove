@extends('backEnd.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('sale.Add Sale') }}</h3>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="sale_margin_price" class="sale_margin_price"
                       value="{{app('general_setting')->sale_margin_price}}">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                <h4 class="text-danger customer_due pb-3"
                                    style="display: none">{{__('sale.Previous Due')}}
                                    :<a target="_blank" href="{{route('due.invoice.list')}}" class="balance_due"></a>
                                </h4>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 text-right">
                                <h4 class="text-danger customer_invoice pb-3"
                                    style="display: none">{{__('sale.Last Invoice')}}
                                    :<a href="javascript:void(0)" data-toggle="modal" onclick="invoiceDetail()"
                                        class="invoice_link"></a></h4>
                            </div>
                        </div>
                        <!-- Prefix  -->
                        <form action="{{route("sale.store")}}" id="saleForm" method="POST"
                              enctype="multipart/form-data" >
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('sale.Date') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="date" type="text" name="date"
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
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('sale.Select Customer')}}
                                            *</label>
                                        <select class="primary_select mb-15 contact_type" onchange="saleDetails()"
                                                name="customer_id" required>
                                            <option value="">{{__('sale.Select')}}</option>
                                            @foreach($customers as $customer)
                                                <option value="customer-{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('sale.Select Warehouse or Branch')}} *</label>
                                        <select class="primary_select mb-15 house" onchange="house()"
                                                name="warehouse_id">
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
                                        <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
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
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('common.PO')}} {{__('common.No')}} </label>
                                        <input type="text" class="primary_input_field"
                                               placeholder="{{__('common.PO')}} {{__('common.No')}}" name="ref_no"
                                               value="{{ old('ref_no') }}">
                                        <span class="text-danger">{{$errors->first('ref_no')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Select Product')}}
                                            </label>
                                        <select class="primary_select mb-15 product_info" id="product_info" name="product">
                                            <option value="1">{{__('sale.Select Product')}}</option>
                                            @foreach ($allProducts as $product)
                                                <option value="{{$product->product_id}}-{{ $product->product_type }}">{{$product->product_name}} @if (app('general_setting')->origin == 1 && $product->origin) > {{ __('common.Part Number') }} : {{ $product->origin }} @endif @if ($product->brand_name) > {{ __('product.Brand') }} : {{ $product->brand_name }} @endif @if ($product->model_name) > {{ __('product.Model') }} : {{ $product->model_name }} @endif</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('product_id')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Select Service')}}
                                            </label>
                                        <select class="primary_select mb-15 product_info" id="product_info" name="product">
                                            <option value="1">{{__('sale.Select Service')}}</option>
                                            @foreach ($allServices as $product)
                                                <option value="{{$product->product_id}}-{{ $product->product_type }}">{{$product->product_name}} @if (app('general_setting')->origin == 1 && $product->origin) > {{ __('common.Part Number') }} : {{ $product->origin }} @endif @if ($product->brand_name) > {{ __('product.Brand') }} : {{ $product->brand_name }} @endif @if ($product->model_name) > {{ __('product.Model') }} : {{ $product->model_name }} @endif</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('product_id')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Shipping Name')}}
                                            ({{__('sale.optional')}})</label>
                                        <input type="text" class="primary_input_field"
                                               placeholder="{{__('sale.Shipping Name')}}" name="shipping_name"
                                               value="{{ old('shipping_name') }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Discount')}} </label>
                                        <input onkeyup="billingInfo()" name="total_discount"
                                               type="number" step="0.01"
                                               value="0"
                                               class="primary_input_field billing_inputs total_discount">
                                        <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="">{{__('quotation.Discount Type')}}</label>
                                        <select class="primary_select mb-15 discount_type" onchange="billingInfo()"
                                                id="discount_type" name="discount_type">
                                            <option value="1">{{ __('quotation.Amount') }}</option>
                                            <option value="2">{{ __('quotation.Percentage') }}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('discount_type')}}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="sale_url" value="{{urlShortener()}}">
                                @if(request()->is('conditional-sale/create'))
                                    <input type="hidden" name="payment_method[]" value="due-00">
                                @else
                                    <div class="col-md-4 col-lg-4 col-sm-6">
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
                                    <div class="col-md-4 col-lg-4 col-sm-6 amount_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('sale.Amount')}}</label>
                                            <input type="text" name="amount[]"
                                                   class="primary_input_field amount_payment"
                                                   placeholder="Enter Amount">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(!request()->is('conditional-sale/create'))
                                <div class="row bank_info_div"
                                     @if(app('general_setting')->payment_gateway != 2 ) style="display: none" @endif>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <div class="primary_input mb-15"><label class="primary_input_label" for="">{{__('sale.Bank Name')}}</label><input
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
                                                                                for="">{{__('sale.Bank Name')}}</label><input
                                                type="text" name="account_no[]" class="primary_input_field"
                                                placeholder="Account No"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <div class="primary_input mb-15"><label class="primary_input_label"
                                                                                for="">{{__('sale.Branch')}}</label><input
                                                type="text" name="account_owner[]" class="primary_input_field"
                                                placeholder="Account Owner"></div>
                                    </div>
                                </div>
                            @endif
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="20%" scope="col">{{__('sale.Product')}}</th>
                                    @if (app('general_setting')->origin == 1)
                                        <th width="10%" scope="col">{{__('common.Part Number')}}</th>
                                    @else
                                        <th width="10%" scope="col">{{__('sale.SKU')}}</th>
                                    @endif
                                    <th scope="col">{{__('product.Model')}}</th>
                                    <th scope="col">{{__('product.Brand')}}</th>
                                    <th scope="col" class="d-none">{{__('common.Serial No')}}</th>
                                    <th scope="col">{{__('sale.Price')}}</th>
                                    <th scope="col">{{__('sale.QTY')}}</th>
                                    <th scope="col">{{__('sale.Tax')}} (%)</th>
                                    <th scope="col">{{__('sale.Discount')}}</th>
                                    <th scope="col">{{__('sale.SubTotal')}}</th>
                                    <th scope="col">{{__('common.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody id="product_details">


                                </tbody>
                            </table>

                            <input type="hidden" class="total_price"
                                   value="0"
                                   name="item_amount">
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
                                        <div class="primary_input grid_input product_discounts" style="display: none;">
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
                                                    class="primary_select total_tax">
                                                <option value="0-0">{{__('pos.No Tax')}}</option>
                                                @foreach($taxes as $key=>$tax)
                                                    <option value="{{$tax->rate}}-{{ $tax->id }}">{{$tax->rate}}% {{$tax->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="primary_input grid_input total_discount_tr" style="display: none;">
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
                            <input type="hidden" value="0" class="preview_status" name="preview_status">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{__("sale.Order Note")}} </label>
                                        <textarea class="summernote3" name="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="send_mail" name="send_mail">
                        </form>
                        <div class="col-12 mt-20">
                            <div class="submit_btn text-center ">
                                <button class="primary-btn fix-gr-bg submit-button" onclick="fromSubmit()"><i
                                        class="ti-check"></i>{{__('common.Save')}}</button>
                                <button class="primary-btn fix-gr-bg submit-button" onclick="fromSubmitwithPreview()"><i
                                        class="ti-check"></i>{{__('quotation.Draft')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" value="{{urlShortener()}}" class="url">

    <div class="view_modal">

    </div>
    <div class="invoice_details w-100">

    </div>
@endsection
@push("scripts")
    <script type="text/javascript">

        var baseUrl = $('#app_base_url').val();
        let credit_limit = 0;
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

        function fromSubmitWithMail()
        {
            var customer_id = $('.contact_type').val();
            if (customer_id != "") {
                $('.submit-button').prop('disabled', true);
                $('.send_mail').val(1);
                $('#saleForm').submit();
            }else {
                toastr.error("please Select Customer First");
            }
        }
        $(document).ready(function () {
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
        });

        function fromSubmit() {
            var customer_id = $('.contact_type').val();
            if (customer_id != "") {
                $('.submit-button').prop('disabled', true);
                $('#saleForm').submit();
            }else {
                toastr.error("please Select Customer First");
            }
        }

        function fromSubmitwithPreview() {
            var customer_id = $('.contact_type').val();
            if (customer_id != "") {
                $('.submit-button').prop('disabled', true);
                $('.preview_status').val(1);
                $('#saleForm').submit();
            }else {
                toastr.error("please Select Customer First");
            }
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
            let quantity = $('.quantity_' + type + id).val();
            let sub_total = price * quantity;
            $('.product_subtotal_' + type + id).text(sub_total);
            let min_price = $(".product_min_price_" + type + id).val();
            if (price < min_price)
                $(".product_price_" + type + id).addClass('red_border');
            else
                $(".product_price_" + type + id).removeClass('red_border');
            productTax(id, type);
            productDiscount();
            totalQuantity();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addQuantity(id, type) {
            let datatype = $('.quantity_' + type + id).data('type');
            let price = $(".product_price_" + type + id).val();
            let quantity = $('.quantity_' + type + id).val();
            let house = $('.house').val();

            $.ajax({
                method: 'POST',
                url: "{{route('check.quantity')}}",
                data: {
                    id: id,
                    type: datatype,
                    house: house,
                    quantity: quantity,
                    _token: "{{csrf_token()}}",
                },
                success: function (result) {
                    if (result.stock){
                        toastr.error(result.msg);
                        $('.quantity_' + type + id).val(result.stock);
                    }
                    else {
                        let sub_total = price * quantity;
                        $('.product_subtotal_' + type + id).text(sub_total);
                        let tr = $('.quantity_' + type + id).parent().parent();
                        calcutionTaxDiscount(tr);
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
            let price = $('.product_price_' + type + id).val();
            let quantity = $('.quantity_' + type + id).val();
            let sub_total = price * quantity;
            $('.product_subtotal_' + type + id).text(sub_total);
            totalQuantity();
            productTax(id, type);
            productDiscount();
            SubTotal();
            grandTotal();
            billingInfo();
        }

        function addTax(id, type) {
            let price = $('.product_price_' + type + id).val();
            let quantity = $('.quantity_' + type + id).val();
            let sub_total = price * quantity;
            $('.product_subtotal_' + type + id).text(sub_total);
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
                    customer: customer,
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
                    $('.customer_due').show();
                    $('.balance_due').text(' ' + result.due);
                    if (result.credit_limit)
                        credit_limit = parseFloat(result.credit_limit);
                    if (result.due > credit_limit) {
                        toastr.warning('Your due is greater than your credit limit');
                    }
                    if (result.url) {
                        $('.customer_invoice').show();
                        $('.last_price').show();
                        $('.invoice_link').text(' ' + result.invoice);
                    }
                }
            })
        }

        function deliveryInfo() {
            let value = $('#sale_type').val();
            if (value == '0') {
                $('.delivery_info').show();
            } else
                $('.delivery_info').hide();
        }

        function invoiceDetail() {
            let customer_id = $('.contact_type').val();

            $.ajax({
                method: 'POST',
                url: "{{route('get_sale_details')}}",
                data: {
                    customer_id: customer_id,
                    _token: "{{csrf_token()}}",
                },

                success: function (result) {
                    $('.invoice_details').html(result);
                    $('#sale_info_modal').modal('show');
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
    </script>
@endpush
