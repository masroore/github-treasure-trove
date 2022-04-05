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
    
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        @php
                            $setting = app('general_setting');
                        @endphp
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{$order->invoice_no}}</h3>
                                <ul class="d-flex">
                                    @if ($order->is_paid == 0)
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                               href="javascript:void(0)">{{__('sale.Unpaid')}}</a>
                                        </li>
                                    @elseif ($order->is_paid == 2)
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                               href="javascript:void(0)">{{__('sale.Paid')}}</a>
                                        </li>
                                    @else
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                               href="javascript:void(0)">{{__('sale.Partial')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <ul class="d-flex float-right">
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10" target="_blank"
                                   href="{{route('purchase.order.print_view',$order->id)}}">{{__('common.Print')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10"
                                   href="{{route('purchase.order.pdf',$order->id)}}">{{__('sale.Export')}}</a>
                            </li>
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10"
                                   href="{{ route('purchase.mail',$order->id) }}">{{__('sale.Send')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 student-details">
                        <ul class="nav nav-tabs tab_column" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#invoice" role="tab"
                                   data-toggle="tab">{{__('pos.A4 Size')}}</a>
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
                                                <img src="{{asset('frontend/')}}/img/logo.png" width="100px" alt="">
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
                                                <tr>
                                                    <td>{{__('common.Bill No')}}</td>
                                                    <td>: {{$order->invoice_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Bill Date')}}</td>
                                                    <td>: {{date(app('general_setting')->dateFormat->format, strtotime($order->created_at))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Party Name')}}</td>
                                                    <td>: {{@$order->supplier->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Party Address')}}</td>
                                                    <td>: {{@$order->supplier->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Phone')}}</td>
                                                    <td>: {{@$order->supplier->mobile}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Email')}}</td>
                                                    <td>: {{@$order->supplier->email}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12">
                                            <table class="table-borderless mr-0 ml-auto">
                                                <tr>
                                                    <td>{{__('common.Served By')}}</td>
                                                    <td>: {{$order->user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Entry Time')}}</td>
                                                    <td>: {{$order->created_at}}</td>
                                                </tr><tr>
                                                    <td>{{__('quotation.Reference No')}}</td>
                                                    <td>: {{$order->ref_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.Status')}}</td>
                                                    <td>: {{$order->status == 1 ? 'Ordered' : 'Pending'}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('purchase.Pay Term')}}</td>
                                                    <td>: {{$order->supplier->pay_term}} {{$order->supplier->pay_term_condition}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-30">
                                        @if ($order->shipping_address)
                                            <div class="col-md-4 col-lg-4 mr-0">
                                                <table class="table-borderless">
                                                    <tr>
                                                        <td><b>{{__('quotation.Shipping Address')}}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$order->shipping_address}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @endif
                                        @if ($order->documents)
                                            <div class="col-md-4 col-lg-4">
                                                <table class="table-borderless">
                                                    <tr>
                                                        <td><b>{{__('purchase.Download Attachment')}}</b></td>
                                                    </tr>
                                                    @if ($order->documents && count($order->documents) > 0)
                                                        @foreach($order->documents as $document)
                                                            @php
                                                                $name = explode('/',$document);
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <a href="{{route('file.download',implode(',',$name))}}">{{$name[3]}}</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        <table class="table">
                                                            <tr>
                                                                <th>{{__('quotation.Product Name')}}</th>
                                                                @if (app('general_setting')->origin == 1)
                                                                    <th class="text-center">{{__('common.Part Number')}}</th>
                                                                @else
                                                                    <th class="text-center">{{__('sale.SKU')}}</th>
                                                                @endif
                                                                <th class="text-center">{{__('product.Brand')}}</th>
                                                                <th class="text-center">{{__('product.Model')}}</th>
                                                                <th>{{__('quotation.Price')}}</th>
                                                                <th>{{__('quotation.Quantity')}}</th>
                                                                <th>{{__('quotation.Tax')}}(%)</th>
                                                                <th class="text-right">{{__('quotation.Discount')}}</th>
                                                                <th class="text-right">{{__('quotation.Total Amount')}}</th>
                                                            </tr>

                                                            @foreach($order->items as $item)
                                                                @php
                                                                    $v_name = [];
                                                                    $v_value = [];
                                                                    $variantName = null;
                                                                    if ($item->productSku->product_variation) {
                                                                        foreach (json_decode($item->productSku->product_variation->variant_id) as $key => $value) {
                                                                            array_push($v_name , Modules\Product\Entities\Variant::find($value)->name);
                                                                        }
                                                                        foreach (json_decode($item->productSku->product_variation->variant_value_id) as $key => $value) {
                                                                            array_push($v_value , Modules\Product\Entities\VariantValues::find($value)->value);
                                                                        }

                                                                        for ($i=0; $i < count($v_name); $i++) {
                                                                            $variantName .= $v_name[$i] . ' : ' . $v_value[$i];
                                                                        }
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td>{{@$item->productSku->product->product_name}}
                                                                        <br>
                                                                        @if ($variantName)
                                                                            ({{ $variantName }})
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if (app('general_setting')->origin == 1)
                                                                            {{@$item->productable->product->origin}}
                                                                        @else
                                                                            {{$item->productable->sku}}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{@$item->productSku->product->brand->name}}</td>
                                                                    <td>{{@$item->productSku->product->model->name}}</td>
                                                                    <td>{{@$item->price}}</td>
                                                                    <td class="text-center">{{@$item->quantity}}</td>
                                                                    <td>{{@$item->tax}}</td>
                                                                    <td class="text-right">{{@$item->discount}}</td>
                                                                    <td class="text-right">{{@$item->price * $item->quantity}}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tfoot>
                                                            @php
                                                                $subtotal = $order->items->sum('price') * $order->items->sum('quantity');
                                                                
                                                                $tax = 0;
                                                                $discountProductTotal = 0;
                                                                $subTotalAmount = 0;
                                                                foreach ($order->items as $product) {

                                                                    $tax +=(($product->price - $product->discount) * $product->quantity ) * $product->tax / 100;

                                                                    $discountProductTotal += ($product->discount * $product->quantity);
                                                                    $subTotalAmount += $product->price * $product->quantity;
                                                                }

                                                                if ($order->discount_type == 2){
                                                                    $discount = $order->total_discount;
                                                                }else{
                                                                    $discount = $order->total_discount;
                                                                }
                                                                $vat =($order->amount * $order->total_vat) / 100;
                                                            @endphp
                                                            @php
                                                                $paid =0;
                                                            @endphp
                                                            <tr>
                                                                <td colspan="8" class="text-right mr-0 pr-2">
                                                                    <ul>
                                                                        <li>{{__('quotation.SubTotal')}}
                                                                            : </li>
                                                                        @if($order->items->sum('discount') > 0)
                                                                            <li>{{__('sale.Product Wise Discount')}}
                                                                                :
                                                                            </li>
                                                                        @endif
                                                                        @if($tax > 0)
                                                                            <li>{{__('sale.Product Wise Tax')}}
                                                                                :
                                                                            </li>
                                                                        @endif
                                                                        @if($vat > 0)
                                                                            <li>{{__('purchase.Others Tax')}}
                                                                                :
                                                                            </li>
                                                                        @endif
                                                                        @if($discount > 0)
                                                                            <li>{{__('purchase.Order Discount')}}
                                                                                :</li>
                                                                        @endif
                                                                        @if($order->shipping_charge > 0)
                                                                            <li>{{__('purchase.Shipping Charge')}}
                                                                                :</li>
                                                                        @endif
                                                                        @if($order->other_charge > 0)
                                                                            <li>{{__('purchase.Other Charge')}}
                                                                                :</li>
                                                                        @endif
                                                                        <li class="border-top-0">{{__('sale.Total Amount')}}
                                                                            :</li>
                                                                        
                                                                            <li class="border-top-0">{{__('sale.Total Due')}}
                                                                                :</li>
                                                                        
                                                                    </ul>
                                                                </td>
                                                                @php
                                                                    $paid = $order->payments->sum('amount');
                                                                @endphp
                                                                <td class="text-right mr-0 pr-2">
                                                                    <ul>

                                                                        <li class="nowrap">{{single_price($subTotalAmount)}}</li>
                                                                        @if($discountProductTotal > 0)
                                                                            <li class="nowrap">(-)  {{ single_price($discountProductTotal)}}
                                                                            </li>
                                                                        @endif
                                                                        @if($tax > 0)
                                                                            <li class="nowrap">{{single_price($tax)}}
                                                                            </li>
                                                                        @endif
                                                                        @if($vat > 0)
                                                                            <li class="nowrap">{{ single_price($vat)}}
                                                                            </li>
                                                                        @endif
                                                                        @if($discount > 0)
                                                                            <li class="nowrap">(-) {{single_price($discount)}}</li>
                                                                        @endif
                                                                        @if($order->shipping_charge > 0)
                                                                            <li class="nowrap">{{single_price($order->shipping_charge)}}</li>
                                                                        @endif
                                                                        @if($order->other_charge > 0)
                                                                            <li class="nowrap">{{single_price($order->other_charge)}}</li>
                                                                        @endif
                                                                        <li class="border-top-0">{{single_price($order->payable_amount)}}</li>
                                                                        
                                                                            <li class="border-top-0">{{single_price($order->payable_amount - $order->payments->sum('amount'))}}</li>
                                                                        
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
                                     @if ($order->notes)
                                    <div class="row mt-30 mb-60 pb-50">
                                        <div class="col-lg-12 mt-10 text-justify">
                                            <h3>{{__('common.Note')}}</h3>
                                            <p style="font-size:12px; font-weight:400; color:#828BB2; margin-top:5px">{!! $order->notes !!}</p>
                                            
                                        </div>
                                       
                                    </div>
                                    @endif
                                    <div class="extra-margin">

                                    </div>
                                    <div class="row mt-60 signature_bottom">
                                        <div class="col-md-4 text-center">
                                            <img src="{{ asset('public/frontend/img/signature.png') }}" alt="" >
                                            <p>--------------------------</p>
                                            <p>{{__('sale.Customer')}}</p>
                                            <p>{{__('sale.Signature')}}</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $order->user->signature ? asset($order->user->signature) : asset('public/frontend/img/signature.png') }}" alt="">
                                            <p>--------------------------</p>
                                            <p>{{__('sale.Accountant')}}</p>
                                            <p>{{__('sale.Signature')}}</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $order->updater->signature ? asset($order->updater->signature) : asset('public/frontend/img/signature.png') }}" alt="">
                                            <p>--------------------------</p>
                                            <p>{{__('sale.Authorized')}}</p>
                                            <p>{{__('sale.Signature')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        @push("scripts")
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".table").dataTable();
                });
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
