
<div class="modal fade admin-query" id="PreviewEdit">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                @php
                $setting = app('general_setting');
                @endphp
                <div class="container-fluid p-0">
                    <div class="row pb-30 border-bottom">
                        <div class="left_width_50">
                            @if ($setting->logo)
                                <img src="{{asset($setting->logo)}}" width="100px" alt="">
                            @else
                                <img src="{{asset('frontend/')}}/img/logo.png" width="100px" alt="">
                            @endif
                        </div>
                        <div class="left_width_50 text-right">
                            <h4>{{$order->invoice_no}}</h4>
                        </div>
                    </div>
                    <div class="row pt-30">
                        <div class="col-md-4 col-lg-4">
                            <table class="table-borderless">
                                <tr>
                                    <td>{{__('quotation.Date')}}</td>
                                    <td>{{$order->created_at}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('quotation.Reference No')}}</td>
                                    <td>{{$order->ref_no}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('quotation.Status')}}</td>
                                    <td>{{$order->status == 1 ? 'Sent' : 'Pending'}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('quotation.Valid Till Date')}}</td>
                                    <td>{{$order->valid_till_date}}</td>
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
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <table class="table-borderless">
                                <tr>
                                    <td><b>{{__('sale.Billed To')}}</b></td>
                                </tr>

                                @php
                                    $name = $order->customer ? $order->customer->name : $order->agentuser->name;
                                    $mobile = $order->customer ? $order->customer->mobile : $order->agentuser->username;
                                    $email = $order->customer ? $order->customer->email : $order->agentuser->email;
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
                            <table
                                class="table table-bordered {{$order->items->sum('sub_total') < app('general_setting')->sale_margin_price ? 'below_margin_price' : ''}}">
                                <tr class="m-0">
                                    <th width="15%" scope="col">{{__('sale.Product Name')}}</th>
                                    <th width="50%" scope="col">{{__('quotation.Description')}}</th>
                                    <th width="10%" scope="col">{{__('sale.Price')}}</th>
                                    <th width="5%" scope="col">{{__('sale.Quantity')}}</th>
                                    <th width="5%" scope="col">{{__('sale.Tax')}}</th>
                                    <th width="5%" scope="col">{{__('sale.Discount')}}</th>
                                    <th width="10%" scope="col">{{__('sale.SubTotal')}}</th>
                                </tr>

                                @foreach($order->items as $key=> $item)
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
                                            <td><input type="hidden" name="items[]" value="{{$item->product_sku_id}}">
                                                {{$item->productable->product->product_name}} <br>
                                                @if ($variantName)
                                                    ({{ $variantName }})
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    echo $item->productable->product->description;
                                                @endphp
                                            </td>
                                            <td>{{single_price($item->price)}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->tax}}%</td>
                                            <td>{{$item->discount}}%</td>
                                            <td>{{single_price($item->sub_total)}}</td>
                                        </tr>
                                    @else
                                        @php
                                            $type =$item->product_sku_id.",'combo'" ;
                                        @endphp
                                        <tr>
                                            <td>{{$item->productable->name}} </br> {!!$variantName!!}
                                            </td>

                                            <td>
                                                @php
                                                    echo $item->productable->description;
                                                @endphp
                                            </td>

                                            <td>{{single_price($item->price)}}</td>

                                            <td>{{$item->quantity}}</td>

                                            <td>{{$item->tax}}%</td>

                                            <td>{{single_price($item->discount)}}</td>
                                            <td> {{single_price($item->sub_total)}} </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right">{{__('sale.Total Products')}}</td>
                                    <td class="p-2">{{$order->total_quantity}}</td>
                                    <td colspan="3" style="text-align: right">
                                        <ul>
                                            <li>{{__('sale.Tax')}} : {{$order->total_vat}} %</li>
                                            <li>{{__('sale.Discount')}}
                                                : {{single_price($order->total_discount)}}</li>
                                            <li class="border-top-0">{{__('sale.Total')}}
                                                : {{single_price($order->payable_amount)}}</li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            @if ($order->notes != null)
                                <div class="col-12 mt-10">
                                    <h3>{{__('sale.Sale Note')}}</h3>
                                    <p>{!! $order->notes !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
