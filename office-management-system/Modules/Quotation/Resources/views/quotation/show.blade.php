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
      
            <section class="admin-visitor-area up_st_admin_visitor">
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{$quotation->invoice_no}}</h3>
                                    <ul class="d-flex">
                                        @if(permissionCheck('quotation.edit'))
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                         href="{{route('quotation.edit',$quotation->id)}}">{{__('common.Edit')}}</a>
                                     </li>
                                     @endif
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-9 col-md-9 col-sm-12">
                        <ul class="d-flex float-right">
                            <li><a class="primary-btn fix-gr-bg radius_30px mr-10"
                             href="{{route('quotation.order.pdf',$quotation->id)}}">{{__('sale.Export')}}</a>
                         </li>
                         <li><a class="primary-btn fix-gr-bg radius_30px mr-10"
                             href="{{ route('quotation.send_mail',$quotation->id) }}">{{__('sale.Send')}}</a>
                         </li>
                         <li><a href="{{route('quotation.order.print_view',$quotation->id)}}" target="_blank"
                             class="primary-btn fix-gr-bg radius_30px mr-10">{{__('sale.Print')}}</a>
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
                        <div role="tabpanel" class="tab-pane fade show active a4_width" id="invoice">
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
                                            $customer = ($quotation->customer_id != null) ? $quotation->customer : $quotation->agentuser;
                                            @endphp
                                            <tr>
                                                <td>{{__('common.Bill No')}}</td>
                                                <td>: {{$quotation->invoice_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.Bill Date')}}</td>
                                                <td>: {{date(app('general_setting')->dateFormat->format, strtotime($quotation->created_at))}}</td>
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
                                                    @if ($quotation->customer_id != null)
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
                                            $customer = ($quotation->customer_id != null) ? $quotation->customer : $quotation->agentuser;
                                            @endphp
                                            <tr>
                                                <td>{{__('common.Served By')}}</td>
                                                <td>: {{$quotation->creator->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.Entry Time')}}</td>
                                                <td>: {{$quotation->created_at}}</td>
                                            </tr>
                                            <tr>
                                                <td class="info_tbl">{{__('quotation.Ref. No')}}</td>
                                                <td>:  {{$quotation->ref_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('quotation.Status')}}</td>
                                                <td>:  {{$quotation->status == 1 ? 'Sent' : 'Pending'}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('quotation.Valid Till Date')}}</td>
                                                <td>:  {{$quotation->valid_till_date}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-30">
                                    @if ($quotation->shipping_address)
                                    <div class="col-md-4 col-lg-4 mr-0">
                                        <table class="table-borderless">
                                            <tr>
                                                <td><b>{{__('quotation.Shipping Address')}}</b></td>
                                            </tr>
                                            <tr>
                                                <td>{{$quotation->shipping_address}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    @endif
                                    @if ($quotation->documents)
                                    <div class="col-md-4 col-lg-4">
                                        <table class="table-borderless">
                                            <tr>
                                                <td><b>{{__('quotation.Download Attachment')}}</b></td>
                                            </tr>
                                            @if ($quotation->document && count($quotation->document) > 0)
                                            @foreach($quotation->document as $document)
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
                                                            <th scope="col">{{__('sale.Dis')}} (%)</th>
                                                            <th scope="col" class="text-right">{{__('sale.SubTotal')}}</th>
                                                        </tr>

                                                        @foreach($quotation->items as $key=> $item)
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
                                                        <td>{{$item->discount}}</td>
                                                        <td class="text-right nowrap"> {{single_price($item->price * $item->quantity)}} </td>
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

                                                        <td class="nowrap">{{single_price($item->price)}}</td>

                                                        <td class="text-center">{{$item->quantity}}</td>

                                                        <td>{{$item->tax}}%</td>

                                                        <td>{{$item->discount}}</td>
                                                        <td class="text-right nowrap"> {{single_price($item->price * $item->quantity)}} </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    <tfoot>
                                                        @php
                                                        $subtotal = $quotation->items->sum('price') * $quotation->items->sum('quantity');
                                                        $total_due = 0;
                                                        $this_due = 0;
                                                        $tax = 0;
                                                        $discountProductTotal = 0;
                                                        $subTotalAmount = 0;
                                                        foreach ($quotation->items as $product) {

                                                            $prductDiscount = $product->price * $product->discount / 100;

                                                            $tax +=(($product->price - $prductDiscount) * $product->quantity ) * $product->tax / 100;

                                                            if ($product->discount > 0) {
                                                                $discountProductTotal += $prductDiscount * $product->quantity;
                                                            }
                                                            $subTotalAmount += $product->price * $product->quantity;
                                                        }
                                                        $discount = $quotation->total_discount;
                                                        $price_after_discount = $quotation->amount - $discount;
                                                        $vat = ($price_after_discount * $quotation->total_vat) / 100;
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
                                                                    @if ($vat > 0)
                                                                    <li>{{__('quotation.Other Tax')}} ({{ $quotation->total_vat }}%)
                                                                        :
                                                                    </li>
                                                                    @endif
                                                                    @if ($discount > 0)
                                                                    <li>{{__('quotation.Discount')}}
                                                                    :</li>
                                                                    @endif

                                                                    @if($quotation->shipping_charge > 0)
                                                                    <li>{{__('purchase.Shipping Charge')}}
                                                                    :</li>
                                                                    @endif
                                                                    @if($quotation->other_charge > 0)
                                                                    <li>{{__('purchase.Other Charge')}}
                                                                    :</li>
                                                                    @endif
                                                                    <li class="border-top-0">{{__('sale.Total Amount')}}
                                                                    :</li>
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
                                                                    @if ($vat > 0)
                                                                    <li class="nowrap">{{single_price($vat)}}
                                                                    </li>
                                                                    @endif
                                                                    @if ($discount > 0)
                                                                    <li class="nowrap">(-) {{single_price($discount)}}</li>
                                                                    @endif
                                                                    @if($quotation->shipping_charge > 0)
                                                                    <li class="nowrap">{{single_price($quotation->shipping_charge)}}</li>
                                                                    @endif
                                                                    @if($quotation->other_charge > 0)
                                                                    <li class="nowrap">{{single_price($quotation->other_charge)}}</li>
                                                                    @endif
                                                                    <li class="border-top-0 nowrap">{{single_price($quotation->payable_amount)}}</li>
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
                                if($quotation->notes and app('general_setting')->terms_conditions){
                                    $col = 6;
                                }
                            @endphp
                            <div class="row mt-30 mb-60">
                                @if ($quotation->notes)
                                <div class="col-lg-{{ $col }} mt-10 text-justify">
                                    
                                    <h3>{{__('sale.Sale Note')}}</h3>
                                    <p style="font-size:12px; font-weight:400; color:#828BB2; margin-top:5px">{!! $quotation->notes !!}</p>
                                   
                                </div>
                                 @endif
                                 @if (app('general_setting')->terms_conditions)
                                <div class="col-lg-{{ $col }} mt-10 text-justify">
                                    
                                    <h3>{{__('setting.Terms & Condition')}}</h3>
                                    <p style="font-size:12px; font-weight:400; color:#828BB2; margin-top:5px">{{app('general_setting')->terms_conditions}}</p>
                                    
                                </div>
                                @endif
                            </div>
                            <div class="extra-margin">

                            </div>
                            <div class="row mt-60 signature_bottom">
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('public/frontend/img/signature.png') }}" alt="">
                                    <p>--------------------------</p>
                                    <p>{{__('sale.Customer')}}</p>
                                    <p>{{__('sale.Signature')}}</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <img src="{{ $quotation->creator->signature ? asset($quotation->creator->signature) : asset('public/frontend/img/signature.png') }}" alt="">
                                    <p>--------------------------</p>
                                    <p>{{__('sale.Accountant')}}</p>
                                    <p>{{__('sale.Signature')}}</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <img  src="{{ $quotation->updator->signature ? asset($quotation->updator->signature) : asset('public/frontend/img/signature.png') }}" alt="">
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
