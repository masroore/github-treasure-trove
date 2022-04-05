<!DOCTYPE html>
<html>
<head>

    <title>Challan Print</title>

    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="{{asset('backEnd/')}}/css/rtl/bootstrap.min.css"/>

    <style>
        @font-face {
            font-family: 'Cerebri Sans',
            url('storage/fonts/Poppins-Regular.ttf');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Cerebri Sans',
            url('storage/fonts/Poppins-Medium.ttf');
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: 'Cerebri Sans',
            url('storage/fonts/Poppins-SemiBold.ttf');
            font-weight: 600;
            font-style: normal;
        }
        .invoice_heading {
            border-bottom: 1px solid black;
            padding: 20px;
            text-transform: capitalize;
        }
        body{
            font-family: "Poppins", sans-serif;
        }
        .invoice_logo {
            width: 33.33%;
            float: left;
            text-align: left;
        }

        .invoice_no {
            text-align: right;
            color: #415094;
        }

        .invoice_info {
            padding: 20px;
            width: 100%;
            text-transform: capitalize;
        }
        .t-100{
            min-height: 100px;
        }

        .billing_info {
            margin-top: 115px;
        }

        table {
            text-align: left;
            font-family: "Poppins", sans-serif;
        }

        td, th {
            color: #828bb2;
            font-size: 13px;
            font-weight: 400;
            font-family: "Poppins", sans-serif;
        }

        th {
            font-weight: 600;
            font-family: "Poppins", sans-serif;
        }

        li {
            list-style-type: none;
            text-align: right;
        }

        .sale_note {
            width: 45%;
            float: left;
            text-align: left;
        }

        .notes {
            color: #415094;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .note_details {
            font-size: 12px;
            font-weight: 600;
            color: #828BB2 !important;
        }
        .margin_120{
            margin-top: 120px;
            font-size: 12px;
        }.margin_12{
            margin-bottom: 120px;
            font-size: 12px;
        }
        .invoice_footer{
            position: absolute;
            left: 0;
            bottom: 180px;
            width: 100%;
        }

        .invoice_info_footer {
            padding: 0px;
            width: 100%;
            left: 0;
            text-transform: capitalize;
            position: inherit;
        }

        p {
            font-size: 10px;
            color: #454545;
            line-height: 16px;
        }
        .extra_div {
            height:100;
        }
        .a4_width {
           max-width: 210mm;
           margin: auto;
        }
        .nowrap{
            white-space: nowrap;
        }
        .hpb-1{
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
@php
    $setting = app('general_setting');
@endphp
<div class="container-fluid ">
    <div class="invoice_heading">
        <div class="invoice_logo">
            <img src="{{asset($setting->logo)}}" width="100px" alt="">
        </div>
        <div class="invoice_no">
            <h5 class="hpb-1">{{$setting->company_name}}</h5>
            <h5 class="hpb-1">{{$setting->phone}}</h5>
            <h5 class="hpb-1">{{$setting->email}}</h5>
            <h5>{{$setting->address}}</h5>
        </div>
    </div>
    <div class="invoice_info">
        <div class="invoice_logo" style="width:75%">
            <table class="table-borderless">
                @php
                    $name = ($data->customer_id != null) ? $data->customer->name : $data->agentuser->name;
                    $mobile = ($data->customer_id != null) ? $data->customer->mobile : $data->agentuser->agent->phone;
                    $email = ($data->customer_id != null) ? $data->customer->email : $data->agentuser->email;
                    $address = ($data->customer_id != null) ? $data->customer->address : $data->agentuser->address;
                @endphp
                <tr>
                    <td>{{__('common.Challan No')}}</td>
                    <td><span class="p-1">:</span> {{$data->invoice_no}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Challan Date')}}</td>
                    <td><span class="p-1">:</span> {{date(app('general_setting')->dateFormat->format, strtotime($data->created_at))}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Party Name')}}</td>
                    <td><span class="p-1">:</span> {{@$name}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Party Address')}}</td>
                    <td><span class="p-1">:</span> {{@$address}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Phone')}}</td>
                    <td><span class="p-1">:</span> {{@$mobile}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Email')}}</td>
                    <td><span class="p-1">:</span> {{@$email}}</td>
                </tr>
            </table>
        </div>
        <div class="invoice_logo" style="width:25%">
            <table class="table-borderless mr_0 ml_auto">
                <tr>
                    <td>{{__('common.Served By')}}</td>
                    <td><span class="p-1">:</span> {{$data->creator->name}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Entry Time')}}</td>
                    <td><span class="p-1">:</span> {{date('m-d-Y H:i:s', strtotime($data->created_at))}}</td>
                </tr>
                <tr>
                    <td>{{__('sale.Ref. No')}}</td>
                    <td><span class="p-1">:</span> {{$data->ref_no}}</td>
                </tr>
                <tr>
                    <td>{{__('common.Status')}}</td>
                    <td><span class="p-1">:</span> {{$data->status == 1 ? trans('sale.Paid') : trans('sale.Unpaid')}}</td>
                </tr>
                <tr>
                    <td>{{__('sale.Branch')}}</td>
                    <td><span class="p-1">:</span> {{@$data->saleable->name}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="invoice_info">
        <table class="table table-bordered billing_info">
            <tr>
                <th scope="col">{{__('common.No')}}</th>
                <th scope="col">{{__('sale.Product Name')}}</th>
                @if (app('general_setting')->origin == 1)
                <th scope="col">{{__('product.Part No.')}}</th>
                @endif
                <th scope="col">{{__('product.Model')}}</th>
                <th scope="col">{{__('product.Brand')}}</th>
                <th scope="col">{{__('sale.Quantity')}}</th>
            </tr>

            @foreach($data->items as $key=> $item)
                @php
                    $v_name = [];
                    $v_value = [];
                    $p_name = [];
                    $p_qty = [];
                    $variantName = null;
                    if ($item->productable->product && $item->productable->product_variation) {
                    foreach (json_decode($item->productable->product_variation->variant_id) as $key => $value) {
                    array_push($v_name , Modules\Product\Entities\Variant::find($value)->name);
                    }
                    foreach (json_decode($item->productable->product_variation->variant_value_id) as $key => $value) {
                    array_push($v_value , Modules\Product\Entities\VariantValues::find($value)->value);
                    }

                    for ($i=0; $i < count($v_name); $i++) {
                    $variantName .= $v_name[$i] . ' : ' . $v_value[$i];
                    }
                    }else {
                    if (is_array($item->productable->combo_products) || is_object($item->productable->combo_products)) {
                    foreach ($item->productable->combo_products as $c_product_detail) {
                    array_push($p_name , $c_product_detail->productSku->product->product_name);
                    array_push($p_qty , $c_product_detail->product_qty);
                    if ($c_product_detail->productSku->product_variation) {
                    foreach (json_decode($c_product_detail->productSku->product_variation->variant_id) as $key => $value) {
                    array_push($v_name , Modules\Product\Entities\Variant::find($value)->name);
                    }

                    foreach (json_decode($c_product_detail->productSku->product_variation->variant_value_id) as $key => $value) {
                    array_push($v_value , Modules\Product\Entities\VariantValues::find($value)->value);
                    }
                    }
                    }

                    for ($i=0; $i < count($p_name); $i++) {
                    if (!empty($v_name[$i])) {
                    $variantName .= $p_name[$i] . ' -> qty : ('. $p_qty[$i] . ') Specification::' . $v_name[$i] . ' : ' . $v_value[$i] . '; </br>';
                    }else {
                    $variantName .= $p_name[$i] . ' -> qty : ('. $p_qty[$i] . ') ; </br>';
                    }
                    }
                    }
                    }
                @endphp

                @if ($item->productable->product)
                    @php
                        $type =$item->product_sku_id.",'sku'" ;
                    @endphp
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><input type="hidden" name="items[]" value="{{$item->product_sku_id}}">
                            {{$item->productable->product->product_name}} <br>
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
                        <td>{{$item->quantity}}</td>
                    </tr>
                @else
                    @php
                        $type =$item->product_sku_id.",'combo'" ;
                    @endphp
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$item->productable->name}} </br> {!!$variantName!!}
                        </td>

                        <td></td>
                        @if (app('general_setting')->origin == 1)
                            <td></td>
                        @endif
                        <td></td>

                        <td>{{$item->quantity}}</td>

                    </tr>
                @endif
            @endforeach

        </table>
    </div>
    {{-- <div class="invoice_info margin_12 custom_margin"  style="display: flex;justify-content: space-between; width:100%;" >
        <div class="sale_note" style="">
            <div class="sale_note_inner text-justify" >
                @if ($data->notes)
                    <h3 class="notes">{{__('common.Note')}}</h3>
                    <div class="note_details">{!! $data->notes !!}</div>
                @endif
            </div>
        </div>
        <div class="sale_note" @if ($data->notes)style="display: flex;justify-content: flex-end; padding-left: 60px" @else style="display: flex;justify-content: flex-end;" @endif>
            <div class="sale_note_inner text-justify">
                @if (app('general_setting')->terms_conditions)
                    <h3 class="notes">{{__('setting.Terms & Condition')}}</h3>
                    <div class="note_details">{{app('general_setting')->terms_conditions}}</div>
                @endif
            </div>
        </div>
    </div> --}}
</div>
<div class="extra_div">

</div>
<footer class="invoice_footer">
    <div class="invoice_info_footer">
        <div class="invoice_logo text-center">
            <img src="{{ asset('frontend/img/signature.png') }}" alt="" >
            <p>--------------------------</p>
            <p style="margin-bottom:0; line-height:14px;">{{__('sale.Customer')}}</p>
            <p>{{__('sale.Signature')}}</p>
        </div>
        <div class="invoice_logo text-center">
            <img src="{{ $data->creator->signature ? asset($data->creator->signature) : asset('frontend/img/signature.png') }}" alt="">
            <p>--------------------------</p>
            <p style="margin-bottom:0; line-height:14px;">{{__('sale.Accountant')}}</p>
            <p>{{__('sale.Signature')}}</p>
        </div>
        <div class="invoice_logo text-center">
            <img src="{{ $data->updater->signature ? asset($data->updater->signature) : asset('frontend/img/signature.png') }}" alt="">
            <p>--------------------------</p>
            <p style="margin-bottom:0; line-height:14px;">{{__('sale.Authorized')}}</p>
            <p>{{__('sale.Signature')}}</p>
        </div>
    </div>
</footer>

<script src="{{asset('backEnd/vendors/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
window.print();
});
</script>
</body>
</html>
