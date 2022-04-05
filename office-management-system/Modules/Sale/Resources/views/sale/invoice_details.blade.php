<div class="modal fade admin-query" id="invoice_details">
    <div class="modal-dialog modal_1200px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('sale.Invoice Details') }}<span class="view_product_name"></span></h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            @php
                $setting = app('general_setting');
            @endphp
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <img src="{{asset('uploads/settings/infix.png')}}" width="100px" alt="">
                    </div>
                    <div class="col-md-6 col-lg-6 text-right">
                        <h4>{{$sale->invoice_no}}</h4>
                    </div>
                </div>

                <div class="row pt-30">
                    <div class="col-md-4 col-lg-4">
                        <table class="table-borderless">
                            <tr>
                                <td>{{__('sale.Date')}}</td>
                                <td>{{$sale->created_at}}</td>
                            </tr>
                            <tr>
                                <td>{{__('sale.Reference No')}}</td>
                                <td>{{$sale->ref_no}}</td>
                            </tr>
                            <tr>
                                <td>{{__('common.Status')}}</td>
                                <td>{{$sale->status == 1 ? 'Paid' : 'Unpaid'}}</td>
                            </tr>
                            <tr>
                                <td>{{houseName($sale->saleable_type)}}</td>
                                <td>{{@$sale->saleable->name}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5 col-lg-5">
                    </div>
                    <div class="col-md-3 col-lg-3">
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
                <div class="row mt-30">
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <table class="table-borderless">
                            <tr>
                                <td><b>{{__('sale.Billed To')}}</b></td>
                            </tr>
                            <tr>
                                <td>{{__('common.Name')}}:</td>
                                <td>{{@$customer->name}}</td>
                            </tr>
                            <tr>
                                <td>{{__('common.Phone')}}:</td>
                                <td>
                                    <a href="tel:{{@$customer->mobile}}">{{@$customer->mobile}}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('common.Email')}}</td>
                                <td>
                                    <a href="mailto:{{@$customer->email}}">{{@$customer->email}}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5 col-lg-5 col-sm-12">
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-12 previous_due" style="display: none">
                        <table class="table-borderless">
                            <tr>
                                <td><b>{{__('sale.Previous Due')}}</b></td>
                            </tr>
                            <tr>
                                <td>{{__('Amount')}}:</td>
{{--                                <td>{{$due}}</td>--}}
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-12">
                        <table
                            class="table table-bordered {{$sale->items->sum('sub_total') < app('general_setting')->sale_margin_price ? 'below_margin_price' : ''}}">
                            <tr class="m-0">
                                <th>{{__('sale.Product')}}</th>
                                <th>{{__('sale.Category')}}</th>
                                <th>{{__('sale.Unit Price')}}</th>
                                <th>{{__('sale.Quantity')}}</th>
                                <th>{{__('sale.Tax')}}</th>
                                <th>{{__('sale.Discount')}}</th>
                                <th>{{__('sale.SubTotal')}}</th>
                            </tr>

                            @foreach($sale->items as $item)
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
                                    <tr>
                                        <td class="p-2">
                                            @if (@$item->productable->product->product_name)
                                                {{@$item->productable->product->product_name}}
                                                <br>
                                                {{ $variantName }}
                                            @else
                                                {{@$item->productable->name}}
                                                <br>
                                                {{ $variantName }}
                                            @endif
                                        </td>
                                        <td class="p-2">{{@$item->productable->product->category->name}}</td>
                                        <td class="p-2">{{single_price(@$item->price)}}</td>
                                        <td class="p-2">{{@$item->quantity}}</td>
                                        <td class="p-2">{{@$item->tax}}%</td>
                                        <td class="p-2">{{single_price($item->discount)}}</td>
                                        <td class="p-2">{{single_price(@$item->sub_total)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="p-2">
                                            {{$item->productable->name}}</br> {!!$variantName!!}
                                        </td>
                                        <td class="p-2"></td>
                                        <td class="p-2">{{single_price(@$item->productable->price)}}</td>
                                        <td class="p-2">{{@$item->quantity}}</td>
                                        <td class="p-2">{{@$item->tax}}%</td>
                                        <td class="p-2">{{single_price($item->discount)}}</td>
                                        <td class="p-2">{{single_price(@$item->sub_total)}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right">{{__('sale.Total Products')}}</td>
                                <td class="p-2">{{$sale->total_quantity}}</td>
                                <td colspan="3" style="text-align: right">
                                    <ul>
                                        <li>{{__('sale.Tax')}} : {{$sale->total_tax}}%</li>
                                        @if ($sale->total_discount > 0)
                                            <li>{{__('sale.Discount')}}
                                                : {{$sale->total_discount}} %
                                            </li>
                                        @endif
                                        <li class="border-top-0">Total
                                            : {{single_price($sale->total_amount)}}</li>
                                    </ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row mt-30">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-10">
                        <h3>{{__('sale.Sale Note')}}</h3>
                        <p>{!! $sale->notes !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
