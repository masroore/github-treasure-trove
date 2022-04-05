@extends('backEnd.master')
@section('mainContent')
    @push('css')
        <style>
            .invoice_table {
                border-collapse: collapse;
            }

            h1, h2, h3, h4, h5, h6 {
                margin: 0;
            }

            .invoice_wrapper {
                max-width: 435px;
                margin: auto;
            }

            .invoice_table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }

            .border_none {
                border: 0px solid transparent;
                border-top: 0px solid transparent !important;
            }

            .invoice_part_iner {
                background-color: #fff;
                padding: 20px;
            }

            .invoice_part_iner h4 {
                font-size: 30px;
                font-weight: 500;
                margin-bottom: 40px;

            }

            .invoice_part_iner h3 {
                font-size: 25px;
                font-weight: 500;
                margin-bottom: 5px;

            }

            .table_border thead {
                background-color: #F6F8FA;
            }

            .invoice_table td, .table th {
                padding: 5px 0;
                vertical-align: top;
                border-top: 0 solid transparent;
                color: #79838b;
            }

            .invoice_table td, .table th {
                padding: 5px 0;
                vertical-align: top;
                border-top: 0 solid transparent;
                color: #79838b;
            }

            .table_border tr {
                border-bottom: 1px solid #000 !important;
            }

            /* .table_border tr:last-child{
                border-bottom: 0 solid transparent !important;
            } */
            th p span, td p span {
                color: #212E40;
            }

            .invoice_table th {
                color: #00273d;
                font-weight: 300;
                border-bottom: 1px solid #f1f2f3 !important;
                background-color: #fafafa;
            }

            h5 {
                font-size: 16px;
                font-weight: 500;
                line-height: 23px;
            }

            h6 {
                font-size: 10px;
                font-weight: 300;
            }

            .mt_40 {
                margin-top: 40px;
            }

            .table_style th, .table_style td {
                padding: 20px;
            }

            .invoice_info_table td {
                font-size: 10px;
                padding: 0px;
            }

            .invoice_info_table td h6 {
                color: #6D6D6D;
                font-weight: 400;
            }

            p {
                font-size: 10px;
                color: #454545;
                line-height: 16px;
            }

            .invoice_info_table2 tbody {

            }

            .invoice_info_table2 tbody th {
                background: transparent;
                padding: 0px;
                text-align: right;
                border-bottom: 1px dotted #000 !important;
            }

            .invoice_info_table2 tbody td {
                padding: 0px;
            }

            .table_border2 thead {
                border-bottom: 1px solid #000 !important;
            }

            .table_border2 thead th {
                background: transparent;
                border-bottom: 1px solid #000 !important;
                font-size: 10px;
            }

            .table_border2 tbody td {
                padding: 0px;
                font-size: 10px;
            }

            .w_70 {
                width: 70%;
            }

            .pdf_table_1 {

            }

            .pdf_table_1 th {
                font-size: 10px;
                padding: 3px;
                background: transparent;
                border-bottom: 1px solid #000 !important;
                border-top: 1px solid #000 !important;
                text-align: left;
            }

            .pdf_table_2 th {
                font-size: 10px;
                padding: 3px;
                background: transparent;
                border-bottom: 1px solid #000 !important;
                border-top: 1px solid #000 !important;
                text-align: left;
            }

            .pdf_table_2 td {
                padding: 0;
            }

            .pdf_table_2 tfoot {

            }

            .pdf_table_2 tfoot td {
                background: #D2D6DE;
                color: #000 !important;
            }

            .dashed_table {
            }

            .dashed-underline {
                display: block;
                border-bottom: 1px dashed #000;
                margin: 5px 0;
            }
            .dashed_table th {
                background: transparent;
                border-bottom: 0 !important;
                text-align: right;
                padding: 0 !important;
                font-size: 10px;
            }

            .dashed_table td {
                padding: 0 !important;
            }

            .dashed_table td span {
                border-bottom: 1px dotted #000;
                padding: 0;
                display: block;
                margin-left: 5px;
                font-size: 10px;
            }

            .balance_text strong {
                font-style: italic;
            }

            hr {
                margin: 0 !important;
            }

            .invoice_wrapper h3,
            .invoice_wrapper h5,
            .invoice_wrapper h6,
            .invoice_wrapper h4 {
                color: #000000;
            }

            .invoice_wrapper table td,
            .invoice_wrapper table th {
                font-size: 10px !important;
            }


            .invoice_logo {
                width: 30%;
                float: left;
                text-align: left;
            }

            .invoice_no {
                text-align: right;
                color: #415094;
            }

            .invoice_info {
                padding: 20px;
                text-transform: capitalize;
            }

            table.dataTable tbody td {
                text-align: left;
            }

            @page
            {
                /* this affects the margin in the printer settings */
                margin-top: 1in;
            }
            .a4_width {
               max-width: 793.71px;
               min-height: 1122.52px;
               margin: auto;
            }
            .a4_width_modal {
                max-width: 210mm;
            }
            .modal-content .modal-body {
                border-radius: 15px;
            }
            .signature_bottom {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                bottom: 30px;
            }
            .extra-margin {
                height: 70px;
            }
            .QA_section .QA_table tbody th, .QA_section .QA_table tbody td {
                padding: 3px;
            }
            .nowrap{
                white-space: nowrap;
            }
            .hpb-1{
                padding-bottom: 5px;
            }
        </style>
    @endpush
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        @php
                            $setting = app('general_setting');
                        @endphp
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{$sale->invoice_no}}</h3>
                                <ul class="d-flex">
                                    @if ($sale->status == 0)
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                               href="javascript:void(0)">{{__('sale.Unpaid')}}</a>
                                        </li>
                                    @elseif ($sale->status == 2)
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                               href="javascript:void(0)">{{__('sale.Partial')}}</a>
                                        </li>
                                    @else
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                               href="javascript:void(0)">{{__('sale.Paid')}}</a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <ul class="d-flex float-right">
                            <li class="mr-2">
                                <div class="primary_input float-right">
                                    <ul id="theme_nav" class="permission_list sms_list ">
                                        <li>
                                            <label data-id="bg_option"
                                                   class="primary_checkbox d-flex mr-12 ">
                                                <input name="status" class="show_due" value="1" type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{__('sale.Previous Due')}}</p>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @if ($sale->is_approved != 1)
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg mr-10"
                                       href="{{route('sale.edit',$sale->id)}}">{{__('common.Edit')}}</a>
                                </li>
                            @endif

                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg mr-10"
                                   href="{{route('sale.print_view',$sale->id)}}" target="_blank">{{__('common.Print')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg mr-10"
                                   href="{{route('sale.challan_print_view',$sale->id)}}" target="_blank">{{__('common.Challan')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10"
                                   href="{{route('sale.pdf',$sale->id)}}">{{__('sale.Pdf')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10"
                                   href="#" data-toggle="modal" data-target="#preview">{{__('quotation.Preview')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10"
                                   href="#" data-toggle="modal" data-target="#payments">{{__('sale.View Payments')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10"
                                   onclick="send_mail('{{route('sale.send_mail', $sale->id)}}')"
                                   href="#">{{__('sale.Mail')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 student-details">
                        <ul class="nav nav-tabs tab_column" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#invoice" role="tab"
                                   data-toggle="tab">{{__('pos.A4 Size')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pos_machine" role="tab"
                                   data-toggle="tab">{{__('pos.POS Machine')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active a4_width position-relative" id="invoice">
                                <div class="white_box_50px box_shadow_white position-relative a4_width" id="printableArea">
                                    <div class="row pb-30 border-bottom">
                                        <div class="col-md-6 col-lg-6">
                                            @if ($setting->logo)
                                                <img src="{{asset($setting->logo)}}" width="100px" alt="">
                                            @else
                                                <img src="{{asset('public/frontend/')}}/img/logo.png" width="100px" alt="">
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-lg-6 text-right">
                                            <h5 class="hpb-1">{{$setting->company_name}}</h5>
                                            <h5 class="hpb-1">{{$setting->phone}}</h5>
                                            <h5 class="hpb-1">{{$setting->email}}</h5>
                                            <h5>{{$setting->address}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 col-lg-6 col-sm-12">
                                            <table class="table-borderless">
                                                @php
                                                    $customer = ($sale->customer_id != null) ? $sale->customer : $sale->agentuser;
                                                @endphp
                                                <tr>
                                                    <td>{{__('common.Bill No')}}</td>
                                                    <td>: {{$sale->invoice_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Bill Date')}}</td>
                                                    <td>: {{date(app('general_setting')->dateFormat->format, strtotime($sale->created_at))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Party Name')}}</td>
                                                    <td>: {{$customer->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Party Address')}}</td>
                                                    <td>: {{$customer->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Phone')}}</td>
                                                    <td>
                                                        @if ($sale->customer_id != null)
                                                            : {{$customer->mobile}}
                                                        @else
                                                            : {{$customer->agent->phone}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Email')}}</td>
                                                    <td>
                                                        <a href="mailto:{{$customer->email}}">: {{$customer->email}}</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12">
                                            <table class="table-borderless mr-0 ml-auto">
                                                @php
                                                    $customer = ($sale->customer_id != null) ? $sale->customer : $sale->agentuser;
                                                @endphp
                                                <tr>
                                                    <td>{{__('common.Served By')}}</td>
                                                    <td>: {{$sale->creator->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Entry Time')}}</td>
                                                    <td>: {{$sale->created_at}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Sale Type')}}</td>
                                                    <td>: @if ($sale->type == 1) {{ __('common.Regular') }} @elseif ($sale->type == 0) {{ __('common.Conditional') }} @else {{ __('common.POS') }}@endif</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 previous_due" style="display: none">
                                            <table class="table-borderless">
                                                <tr>
                                                    <td><b>{{__('sale.Previous Due')}}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Amount')}}:</td>
                                                    <td>{{single_price($due)}}</td>
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
                                                        <table class="table ">
                                                            <tr class="m-0">
                                                                <th scope="col">{{ __('common.No') }}</th>
                                                                <th scope="col" width="20%">{{__('sale.Product')}}</th>
                                                                @if (app('general_setting')->origin == 1)
                                                                <th scope="col">{{__('product.Part No.')}}</th>
                                                                @endif
                                                                <th scope="col">{{__('product.Model')}}</th>
                                                                <th scope="col">{{__('product.Brand')}}</th>
                                                                <th scope="col">{{__('sale.Price')}}</th>
                                                                <th scope="col">{{__('sale.QTY')}}</th>
                                                                <th scope="col">{{__('sale.Tax')}}</th>
                                                                <th scope="col" class="text-right">{{__('sale.Dis')}}(%)</th>
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
                                                                        <td>{{ $key+1 }}</td>
                                                                        <td><input type="hidden" name="items[]"
                                                                                   value="{{$item->product_sku_id}}">
                                                                            {{$item->productable->product->product_name}}
                                                                            <br>
                                                                            @if ($variantName)
                                                                                ({{ $variantName }})
                                                                            @endif
                                                                        </td>
                                                                        @if (app('general_setting')->origin == 1)
                                                                            <td>
                                                                               
                                                                                {{@$item->productable->product->origin}}
                                                                            </td>
                                                                        @endif
                                                                        <td>{{@$item->productable->product->model->name}}</td>
                                                                        <td>{{@$item->productable->product->brand->name}}</td>
                                                                        <td class="nowrap">{{single_price($item->price)}}</td>
                                                                        <td class="text-center">{{$item->quantity}}</td>
                                                                        <td>{{$item->tax}}%</td>
                                                                        <td class="text-center">{{$item->discount}}</td>
                                                                        <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                                    </tr>
                                                                @else
                                                                    @php
                                                                        $type =$item->product_sku_id.",'combo'" ;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $key+1 }}</td>
                                                                        <td>{{$item->productable->name}}
                                                                            <br> {!!$variantName!!}
                                                                        </td>
                                                                        @if (app('general_setting')->origin == 1)
                                                                            <td></td>
                                                                        @endif
                                                                        <td></td>
                                                                        <td></td>

                                                                        <td class="nowrap">{{single_price($item->price)}}</td>

                                                                        <td class="text-center">{{$item->quantity}}</td>

                                                                        <td>{{$item->tax}}%</td>

                                                                        <td>{{$item->discount}}</td>
                                                                        <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            <tfoot>
                                                                @php
                                                                    $subtotal = $sale->items->sum('price') * $sale->items->sum('quantity');
                                                                    $total_due = 0;
                                                                    $this_due = 0;
                                                                    $tax = 0;
                                                                    $discountProductTotal = 0;
                                                                    $subTotalAmount = 0;
                                                                    foreach ($sale->items as $product) {

                                                                        $prductDiscount = $product->price * $product->discount / 100;

                                                                        $tax +=(($product->price - $prductDiscount) * $product->quantity ) * $product->tax / 100;

                                                                        if ($product->discount > 0) {
                                                                            $discountProductTotal += $prductDiscount * $product->quantity;
                                                                        }
                                                                        $subTotalAmount += $product->price * $product->quantity;
                                                                    }
                                                                    $this_due = $sale->payable_amount - $sale->payments->sum('amount') - $sale->payments->sum('advance_amount') - $sale->payments->sum('return_amount');
                                                                    $discount = $sale->total_discount;
                                                                    $vat = (($sale->amount - $discount) * $sale->total_tax) / 100;
                                                                @endphp
                                                                @php
                                                                    $paid =0;
                                                                @endphp
                                                            <tr>
                                                                <td @if (app('general_setting')->origin == 1) colspan="9" @else colspan="8" @endif style="text-align: right">
                                                                    <ul>

                                                                        <li class="nowrap">{{__('quotation.SubTotal')}}
                                                                            :</li>
                                                                        @if ($discountProductTotal > 0)
                                                                            <li>{{__('sale.Product Wise Discount')}}
                                                                                :
                                                                            </li>
                                                                        @endif
                                                                        @if ($tax > 0)
                                                                            <li>{{__('sale.Product Wise Tax')}}
                                                                                :
                                                                            </li>
                                                                        @endif
                                                                        <li>{{__('sale.Grand Total')}}
                                                                            :</li>
                                                                        @if ($discount > 0)
                                                                            <li>{{__('quotation.Discount')}}
                                                                                :</li>
                                                                        @endif
                                                                        @if ($vat > 0)
                                                                            <li>{{__('quotation.Other Tax')}} ({{ $sale->total_tax }}%)
                                                                                :
                                                                            </li>
                                                                        @endif

                                                                        @if($sale->shipping_charge > 0)
                                                                            <li>{{__('purchase.Shipping Charge')}}
                                                                                :</li>
                                                                        @endif
                                                                        @if($sale->other_charge > 0)
                                                                            <li>{{__('purchase.Other Charge')}}
                                                                                :</li>
                                                                        @endif
                                                                        <li class="border-top-0">{{__('sale.Total Amount')}}
                                                                            :</li>
                                                                        <li class="border-top-0">{{__('sale.Due')}}
                                                                            :</li>
                                                                        @if ($this_due < 0)
                                                                            <li class="border-top-0">{{__('purchase.Advance Amount')}}
                                                                                :</li>
                                                                        @endif
                                                                        @if($due > 0)
                                                                            <li class="border-top-0 total_due" style="display: none">{{__('sale.Total Due')}}
                                                                                :</li>
                                                                        @endif
                                                                    </ul>
                                                                </td>

                                                                <td class="text-right mr-0 pr-2">
                                                                    <ul>

                                                                        <li class="nowrap">{{single_price($subTotalAmount)}}</li>
                                                                        @if ($discountProductTotal > 0)
                                                                            <li class="nowrap">(-) {{single_price($discountProductTotal)}}
                                                                            </li>
                                                                        @endif
                                                                        @if ($tax > 0)
                                                                            <li class="nowrap">{{single_price($tax)}}
                                                                            </li>
                                                                        @endif
                                                                        <li class="nowrap">{{single_price($subTotalAmount - $discountProductTotal + $tax)}}</li>
                                                                        @if ($discount > 0)
                                                                            <li class="nowrap">(-) {{single_price($discount)}}</li>
                                                                        @endif
                                                                        @if ($vat > 0)
                                                                            <li class="nowrap">{{single_price($vat)}}
                                                                            </li>
                                                                        @endif
                                                                        @if($sale->shipping_charge > 0)
                                                                            <li class="nowrap">{{single_price($sale->shipping_charge)}}</li>
                                                                        @endif
                                                                        @if($sale->other_charge > 0)
                                                                            <li class="nowrap">{{single_price($sale->other_charge)}}</li>
                                                                        @endif
                                                                        <li class="border-top-0">{{single_price($sale->payable_amount)}}</li>
                                                                        <li class="border-top-0">{{ ($this_due > 0) ? single_price($this_due) : single_price(0)}}</li>
                                                                        @if ($this_due < 0)
                                                                            <li class="border-top-0">{{single_price($sale->payments->sum('amount') + $sale->payments->sum('advance_amount') - $sale->payable_amount)}}</li>
                                                                        @endif
                                                                        @if($due > 0)
                                                                            <li class="border-top-0 total_due" style="display: none">{{single_price($due + $this_due)}}</li>
                                                                        @endif
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $col = 12;
                                        if($sale->notes and app('general_setting')->terms_conditions){
                                            $col = 6;
                                        }
                                    @endphp
                                    <div class="row mt-30 mb-60 pb-50">
                                        @if ($sale->notes)
                                        <div class="col-lg-{{ $col }} mt-10 text-justify">
                                            
                                                <h3>{{__('sale.Sale Note')}}</h3>
                                                <p style="font-size:12px; font-weight:400; color:#828BB2; margin-top:5px">{!! $sale->notes !!}</p>
                                            
                                        </div>
                                        @endif
                                        @if (app('general_setting')->terms_conditions)
                                        <div class="col-lg-{{ $col }} mt-10 text-justify">
                                            
                                                <h3>{{__('setting.Terms & Condition')}}</h3>
                                                <p style="font-size:12px; font-weight:400; color:#828BB2; margin-top:5px">{{app('general_setting')->terms_conditions}}</p>
                                           
                                        </div>
                                         @endif
                                        <div class="col-lg-12">
                                            <p>Remarks:</p>
                                            <p class="text-center">{{app('general_setting')->remarks_title}}</p>
                                            <span class="dashed-underline"></span>
                                            <p class="text-center">{{app('general_setting')->remarks_body}}</p>
                                        </div>
                                    </div>

                                    <div class="extra-margin">

                                    </div>
                                    <div class="row mt-60 signature_bottom ">
                                        <div class="col-md-4 text-center">
                                            <img src="{{ asset('public/frontend/img/signature.png') }}" alt="" >
                                            <p>--------------------------</p>
                                            <p>{{__('sale.Customer')}}</p>
                                            <p>{{__('sale.Signature')}}</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $sale->creator->signature ? asset($sale->creator->signature) : asset('public/frontend/img/signature.png') }}" alt="" >
                                            <p>--------------------------</p>
                                            <p>{{__('sale.Accountant')}}</p>
                                            <p>{{__('sale.Signature')}}</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $sale->updater->signature ? asset($sale->updater->signature) : asset('public/frontend/img/signature.png') }}" alt="">
                                            <p>--------------------------</p>
                                            <p>{{__('sale.Authorized')}}</p>
                                            <p>{{__('sale.Signature')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-30 justify-content-center">
                                    <a href="{{route('sale.create')}}"
                                       class="primary-btn fix-gr-bg mr-20">{{__('sale.Back To Sale')}}</a>
                                    {{-- <a href="javascript:void(0)" onclick="printDiv('printableArea')"
                                       class="primary-btn fix-gr-bg mr-20">{{__('sale.Print')}}</a> --}}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="pos_machine">
                                <div class="invoice_wrapper">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <!-- invoice print part here -->
                                                <div class="invoice_print">
                                                    <div class="container">
                                                        <div id="printablePos" class="invoice_part_iner">
                                                            <table class="invoice_table invoice_info_table">
                                                                <h3 style="text-align: center; color: black">{{app('general_setting')->company_name}}</h3>
                                                                <h5 style="text-align: center; color: black">{{app('general_setting')->country_name}}</h5>
                                                                <p style="text-align: center;color: black">{{__('retailer.Phone')}}
                                                                    :{{app('general_setting')->phone}}
                                                                    , {{__('retailer.Email')}}
                                                                    : {{app('general_setting')->email}}</p>
                                                                <tbody>
                                                                <tr>
                                                                    <td><h6>{{$sale->invoice_no}}</h6></td>
                                                                    <td style="text-align: right;">
                                                                        <h6>{{__('sale.Invoice No')}}</h6></td>

                                                                </tr>
                                                                <tr>
                                                                    <td><h6>{{__('sale.Date')}}</h6></td>
                                                                    <td style="text-align: right;">
                                                                        <h6>{{$sale->date}}</h6>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $name = ($sale->customer_id != null) ? $sale->customer->name : $sale->agentuser->name;
                                                                    $mobile = ($sale->customer_id != null) ? $sale->customer->mobile : $sale->agentuser->agent->phone;
                                                                    $email = ($sale->customer_id != null) ? $sale->customer->email : $sale->agentuser->email;
                                                                @endphp
                                                                <tr>
                                                                    <td><h6>{{__('sale.Customer')}}</h6></td>
                                                                    <td style="text-align: right;"><h6>{{$name}}</h6>
                                                                    </td>
                                                                </tr>
                                                                {{--<tr>
                                                                    <td>
                                                                        <h6>{{__('sale.Customer')}} {{__('retailer.Phone')}}</h6>
                                                                    </td>
                                                                    <td style="text-align: right;"><h6>{{$mobile}}</h6></td>
                                                                </tr>--}}
                                                                </tbody>
                                                            </table>
                                                            <div class="table_title">
                                                                <h3 style="font-size: 14px; text-transform: uppercase; text-align: center; color: black">{{ __('common.Invoice') }}</h3>
                                                            </div>
                                                            <table class="invoice_table pdf_table_1"
                                                                   style="margin-bottom: 0 !important;color: black">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col">{{__('common.No')}}</th>
                                                                    <th scope="col">{{__('common.Name')}}</th>
                                                                    <th scope="col">{{__('quotation.Qty')}}</th>
                                                                    <th scope="col" class="text-right">{{__('sale.Price')}}</th>
                                                                    <th scope="col" class="text-right">{{__('sale.Discount')}} (%)</th>
                                                                    <th scope="col" class="text-right">{{__('sale.Amount')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($sale->items as $key => $item)
                                                                    <tr>
                                                                        <td>{{$key+1}}</td>
                                                                        @php
                                                                            $product =$item->productable->product ? $item->productable->product->product_name : $item->productable->name;
                                                                        @endphp
                                                                        <td>{{$product}}</td>
                                                                        <td>{{$item->quantity}}</td>
                                                                        <td class="text-right">{{$item->price}}</td>
                                                                        <td class="text-right">{{$item->discount}}</td>
                                                                        <td class="text-right">{{ single_price($item->sub_total)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                            <hr>
                                                            <table class="invoice_table dashed_table"
                                                                   style="margin-bottom: 10px;color: black">
                                                                <tbody>
                                                                <tr>
                                                                    <th class="w_70">{{__('sale.SubTotal')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{single_price($subTotalAmount)}}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w_70">{{__('quotation.Product wise Total Discount')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{single_price($discountProductTotal)}}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w_70">{{__('sale.Product Tax')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{single_price($tax)}}</span></td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w_70">{{__('sale.Grand Total')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{ single_price($subTotalAmount - $discountProductTotal + $tax) }}</span></td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w_70">{{__('sale.Discount')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        @if ($sale->total_discount > 0)
                                                                            <span>-{{ single_price($sale->total_discount) }}</span></td>
                                                                        @else
                                                                            <span>{{ single_price(0)}}</span></td>
                                                                        @endif
                                                                </tr>
                                                                <tr>
                                                                    <th class="w_70">{{__('quotation.Other Tax')}} ({{ $sale->total_tax }}%):</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{ single_price($vat) }}</span></td>
                                                                </tr>
                                                                @if($sale->shipping_charge > 0)
                                                                    <tr>
                                                                        <th class="w_70">{{__('purchase.Shipping Charge')}}:</th>
                                                                        <td style="text-align: right;">
                                                                            <span>{{ single_price($sale->shipping_charge) }}</span></td>
                                                                    </tr>
                                                                @endif
                                                                @if($sale->other_charge > 0)
                                                                    <tr>
                                                                        <th class="w_70">{{__('purchase.Other Charge')}}:</th>
                                                                        <td style="text-align: right;">
                                                                            <span>{{ single_price($sale->other_charge) }}</span></td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <th class="w_70">{{__('sale.Total Amount')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{ single_price($sale->payable_amount) }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w_70">{{__('sale.Paid Amount')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{ single_price($sale->payments->sum('amount'))}}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w_70">{{__('sale.Due')}}:</th>
                                                                    <td style="text-align: right;">
                                                                        <span>{{ single_price($sale->payable_amount - $sale->payments->sum('amount'))}}</span>
                                                                    </td>
                                                                </tr>
                                                                @if ($sale->payable_amount - ($sale->payments->sum('amount') + $sale->payments->sum('advance_amount')) < 0)
                                                                    <tr>
                                                                        <th class="w_70">{{__('purchase.Advance Amount')}}:</th>
                                                                        <td style="text-align: right;">
                                                                            <span>{{ single_price($sale->payments->sum('amount') + $sale->payments->sum('advance_amount') - $sale->payable_amount)}}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                            <div style="text-align: center;">
                                                                {!! DNS1D::getBarcodeSVG($sale->id, 'C39') !!}
                                                            </div>
                                                            <p style="text-align: center;"> {{app('general_setting')->terms_conditions}}</p>
                                                            <p>Remarks:</p>
                                                            <p style="text-align: center;">{{app('general_setting')->remarks_title}}</p>
                                                            <span class="dashed-underline"></span>
                                                            <p style="text-align: center;">{{app('general_setting')->remarks_body}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- invoice print part end -->
                                                <div class="row justify-content-center mt-20">
                                                    <button type="button" onclick="printDiv('printablePos')"
                                                            class="primary-btn fix-gr-bg mr-2">{{__('pos.Print')}}</button>
                                                    <button type="button" onclick="modal_close()"
                                                            class="primary-btn fix-gr-bg">{{__('common.Close')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade admin-query" id="preview">
            <div class="modal-dialog a4_width_modal modal-dialog-centered">
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
                                    <h5 class="hpb-1">{{$setting->company_name}}</h5>
                                    <h5 class="hpb-1">{{$setting->phone}}</h5>
                                    <h5 class="hpb-1">{{$setting->email}}</h5>
                                    <h5>{{$setting->address}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-lg-8 col-sm-12">
                                    <table class="table-borderless">
                                        @php
                                            $name = ($sale->customer_id != null) ? $sale->customer->name : $sale->agentuser->name;
                                            $mobile = ($sale->customer_id != null) ? $sale->customer->mobile : $sale->agentuser->agent->phone;
                                            $email = ($sale->customer_id != null) ? $sale->customer->email : $sale->agentuser->email;
                                            $address = ($sale->customer_id != null) ? $sale->customer->address : $sale->agentuser->address;
                                        @endphp
                                        <tr>
                                            <td>{{__('common.Bill No')}}</td>
                                            <td>: {{$sale->invoice_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Bill Date')}}</td>
                                            <td>: {{date(app('general_setting')->dateFormat->format, strtotime($sale->created_at))}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Party Name')}}</td>
                                            <td>: {{@$name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Party Address')}}</td>
                                            <td>: {{@$address}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Phone')}}</td>
                                            <td>: {{@$mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Email')}}</td>
                                            <td>: {{@$email}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-12">
                                    <table class="table-borderless mr-0 ml-auto">
                                        @php
                                            $customer = ($sale->customer_id != null) ? $sale->customer : $sale->agentuser;
                                        @endphp
                                        <tr>
                                            <td>{{__('common.Served By')}}</td>
                                            <td>: {{$sale->creator->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Entry Time')}}</td>
                                            <td>: {{$sale->created_at}}</td>
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
                                                <table class="table ">
                                                    <tr class="m-0">
                                                        <th scope="col">{{ __('common.No') }}</th>
                                                        <th scope="col" width="20%">{{__('sale.Product Name')}}</th>
                                                        @if (app('general_setting')->origin == 1)
                                                        <th scope="col">{{__('product.Part No.')}}</th>
                                                        @endif
                                                        <th scope="col">{{__('product.Model')}}</th>
                                                        <th scope="col">{{__('product.Brand')}}</th>
                                                        <th scope="col">{{__('sale.Price')}}</th>
                                                        <th scope="col">{{__('sale.Quantity')}}</th>
                                                        <th scope="col">{{__('sale.Tax')}}</th>
                                                        <th scope="col">{{__('sale.Discount')}}(%)</th>
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
                                                                <td>{{ $key+1 }}</td>
                                                                <td><input type="hidden" name="items[]"
                                                                           value="{{$item->product_sku_id}}">
                                                                    {{$item->productable->product->product_name}}
                                                                    <br>
                                                                    @if ($variantName)
                                                                        ({{ $variantName }})
                                                                    @endif
                                                                </td>
                                                                @if (app('general_setting')->origin == 1)
                                                                    <td>
                                                                        {{-- @foreach ($item->part_number_details as $key => $part_num_detail)
                                                                            {{ @$part_num_detail->part_number->seiral_no }} @if ($item->part_number_details->count() > $key+1) ; @endif<br>
                                                                        @endforeach --}}
                                                                        {{@$item->productable->product->origin}}
                                                                    </td>
                                                                @endif
                                                                <td>{{@$item->productable->product->model->name}}</td>
                                                                <td>{{@$item->productable->product->brand->name}}</td>
                                                                <td>{{single_price($item->price)}}</td>
                                                                <td class="text-center">{{$item->quantity}}</td>
                                                                <td>{{$item->tax}}%</td>
                                                                <td class="text-center">{{$item->discount}}</td>
                                                                <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                            </tr>
                                                        @else
                                                            @php
                                                                $type =$item->product_sku_id.",'combo'" ;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{$item->productable->name}}
                                                                    <br> {!!$variantName!!}
                                                                </td>

                                                                <td></td>
                                                                @if (app('general_setting')->origin == 1)
                                                                    <td></td>
                                                                @endif
                                                                <td></td>

                                                                <td>{{single_price($item->price)}}</td>

                                                                <td class="text-center">{{$item->quantity}}</td>

                                                                <td>{{$item->tax}}%</td>

                                                                <td>{{$item->discount}}</td>
                                                                <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    <tfoot>
                                                        @php
                                                            $subtotal = $sale->items->sum('price') * $sale->items->sum('quantity');
                                                            $total_due = 0;
                                                            $this_due = 0;
                                                            $tax = 0;
                                                            $discountProductTotal = 0;
                                                            $subTotalAmount = 0;
                                                            foreach ($sale->items as $product) {

                                                                $prductDiscount = $product->price * $product->discount / 100;

                                                                $tax +=(($product->price - $prductDiscount) * $product->quantity ) * $product->tax / 100;

                                                                if ($product->discount > 0) {
                                                                    $discountProductTotal += $prductDiscount * $product->quantity;
                                                                }
                                                                $subTotalAmount += $product->price * $product->quantity;
                                                            }
                                                            $this_due = $sale->payable_amount - $sale->payments->sum('amount') - $sale->payments->sum('return_amount');
                                                            $discount = $sale->total_discount;
                                                            $vat =(($sale->amount - $discount) * $sale->total_tax) / 100;
                                                        @endphp
                                                        @php
                                                            $paid =0;
                                                        @endphp
                                                    <tr>
                                                        <td @if (app('general_setting')->origin == 1) colspan="9" @else colspan="8" @endif style="text-align: right">
                                                            <ul>

                                                                <li class="nowrap">{{__('quotation.SubTotal')}}
                                                                    :</li>
                                                                @if ($discountProductTotal > 0)
                                                                    <li>{{__('sale.Product Wise Discount')}}
                                                                        :
                                                                    </li>
                                                                @endif
                                                                @if ($tax > 0)
                                                                    <li>{{__('sale.Product Wise Tax')}}
                                                                        :
                                                                    </li>
                                                                @endif
                                                                <li>{{__('sale.Grand Total')}}
                                                                    :</li>
                                                                @if ($discount > 0)
                                                                    <li>{{__('quotation.Discount')}}
                                                                        :</li>
                                                                @endif
                                                                @if ($vat > 0)
                                                                    <li>{{__('quotation.Other Tax')}} ({{ $sale->total_tax }}%)
                                                                        :
                                                                    </li>
                                                                @endif

                                                                @if($sale->shipping_charge > 0)
                                                                    <li>{{__('purchase.Shipping Charge')}}
                                                                        :</li>
                                                                @endif
                                                                @if($sale->other_charge > 0)
                                                                    <li>{{__('purchase.Other Charge')}}
                                                                        :</li>
                                                                @endif
                                                                <li class="border-top-0">{{__('sale.Total Amount')}}
                                                                    :</li>
                                                                <li class="border-top-0">{{__('sale.Due')}}
                                                                    :</li>
                                                                @if($due > 0)
                                                                    <li class="border-top-0 total_due" style="display: none">{{__('sale.Total Due')}}
                                                                        :</li>
                                                                @endif
                                                            </ul>
                                                        </td>

                                                        <td class="text-right mr-0 pr-2">
                                                            <ul>

                                                                <li class="nowrap">{{single_price($subTotalAmount)}}</li>
                                                                @if ($discountProductTotal > 0)
                                                                    <li class="nowrap">(-) {{single_price($discountProductTotal)}}
                                                                    </li>
                                                                @endif
                                                                @if ($tax > 0)
                                                                    <li class="nowrap">{{single_price($tax)}}
                                                                    </li>
                                                                @endif
                                                                <li class="nowrap">{{single_price($subTotalAmount - $discountProductTotal + $tax)}}</li>
                                                                @if ($discount > 0)
                                                                    <li class="nowrap">(-) {{single_price($discount)}}</li>
                                                                @endif
                                                                @if ($vat > 0)
                                                                    <li class="nowrap">{{single_price($vat)}}
                                                                    </li>
                                                                @endif
                                                                @if($sale->shipping_charge > 0)
                                                                    <li class="nowrap">{{single_price($sale->shipping_charge)}}</li>
                                                                @endif
                                                                @if($sale->other_charge > 0)
                                                                    <li class="nowrap">{{single_price($sale->other_charge)}}</li>
                                                                @endif
                                                                <li class="border-top-0">{{single_price($sale->payable_amount)}}</li>
                                                                <li class="border-top-0">{{single_price($this_due)}}</li>
                                                                @if($due > 0)
                                                                    <li class="border-top-0 total_due" style="display: none">{{single_price($due + $this_due)}}</li>
                                                                @endif
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
        <div class="modal fade admin-query" id="payments">
            <div class="modal-dialog modal_1000px modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('sale.Payments History')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ti-close "></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="row mt-10">
                                <div class="col-12">
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table ">
                                            <!-- table-responsive -->
                                            <div class="">
                                                <table class="table ">
                                                    <tr class="m-0">
                                                        <th scope="col">{{__('sale.Date')}}</th>
                                                        <th scope="col">{{__('sale.Payment Method')}}</th>
                                                        <th scope="col">{{__('sale.Amount')}}</th>
                                                    </tr>
                                                    @php
                                                        $total_amount = 0;
                                                    @endphp

                                                    @foreach($sale->payments as $key=> $payment)
                                                        @php
                                                            $paid = $payment->amount - $payment->return_amount;
                                                            $total_amount += $paid;
                                                        @endphp
                                                        <tr>
                                                            <td>{{date(app('general_setting')->dateFormat->format, strtotime($payment->created_at))}}</td>
                                                            <td>{{$payment->payment_method}}</td>
                                                            <td> {{single_price($paid)}} </td>
                                                        </tr>
                                                    @endforeach
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="2"
                                                            style="text-align: right">{{__('purchase.Total Amount')}}</td>
                                                        <td>{{single_price($total_amount)}}</td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade admin-query" id="mail_send">
            <div class="modal-dialog modal_800px modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('sale.Email Confimation') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row pt-30">
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless">
                                    <tr>
                                        <td>{{__('quotation.Date')}}</td>
                                        <td>{{$sale->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('quotation.Invoice No')}}</td>
                                        <td>{{$sale->invoice_no}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <table class="table-borderless">

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

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <a id="approve_link"
                                   class="primary-btn semi_large2 fix-gr-bg">{{__('sale.Send Mail')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @push("scripts")
            <script type="text/javascript">
                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    setTimeout(function () {
                        window.location.reload();
                    }, 15000);
                }

                function send_mail(url) {
                    $('#mail_send').modal('show');
                    document.getElementById('approve_link').setAttribute('href', url);
                }
            </script>
    @endpush

@endsection
