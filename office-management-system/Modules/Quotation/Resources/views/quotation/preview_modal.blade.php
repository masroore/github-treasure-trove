<div class="modal fade admin-query" id="PreviewEdit">
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
                                    $customer = ($order->customer_id != null) ? $order->customer : $order->agentuser;
                                @endphp
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
                                    <td>: {{$customer->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.Party Address')}}</td>
                                    <td>: {{$customer->address}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.Phone')}}</td>
                                    <td>
                                        @if ($order->customer_id != null)
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
                                    $customer = ($order->customer_id != null) ? $order->customer : $order->agentuser;
                                @endphp
                                <tr>
                                    <td>{{__('common.Served By')}}</td>
                                    <td>: {{$order->creator->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.Entry Time')}}</td>
                                    <td>: {{$order->created_at}}</td>
                                </tr>
                                <tr>
                                    <td class="info_tbl">{{__('quotation.Ref. No')}}</td>
                                    <td>:  {{$order->ref_no}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('quotation.Status')}}</td>
                                    <td>:  {{$order->status == 1 ? 'Sent' : 'Pending'}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('quotation.Valid Till Date')}}</td>
                                    <td>:  {{$order->valid_till_date}}</td>
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
                                        <table class="table table-responsive">
                                            <tr class="m-0">
                                                <th scope="col">{{ __('common.No') }}</th>
                                                <th scope="col" width="20%">{{__('sale.Product Name')}}</th>
                                                <th scope="col">{{__('product.Brand')}}</th>
                                                <th scope="col">{{__('product.Part No.')}}</th>
                                                <th scope="col">{{__('product.Model')}}</th>
                                                <th scope="col">{{__('sale.Price')}}</th>
                                                <th scope="col">{{__('sale.Quantity')}}</th>
                                                <th scope="col">{{__('sale.Tax')}}</th>
                                                <th scope="col">{{__('sale.Discount')}}</th>
                                                <th scope="col" class="text-right">{{__('sale.SubTotal')}}</th>
                                            </tr>

                                            @foreach($order->items as $key=> $item)
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
                                                        <td>{{@$item->productable->product->brand->name}}</td>
                                                        <td>
                                                            @foreach ($item->part_number_details as $key => $part_num_detail)
                                                                {{ @$part_num_detail->part_number->seiral_no }}
                                                            @endforeach
                                                        </td>
                                                        <td>{{@$item->productable->model->name}}</td>
                                                        <td>{{single_price($item->price)}}</td>
                                                        <td class="text-center">{{$item->quantity}}</td>
                                                        <td>{{$item->tax}}%</td>
                                                        <td>{{single_price($item->discount)}}</td>
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
                                                        <td></td>
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
                                                    $subtotal = $order->items->sum('price') * $order->items->sum('quantity');
                                                    $total_due = 0;
                                                    $this_due = 0;
                                                    $tax = 0;
                                                    $discountProductTotal = 0;
                                                    $subTotalAmount = 0;
                                                    foreach ($order->items as $product) {

                                                        $prductDiscount = $product->price * $product->discount / 100;

                                                        $tax +=(($product->price - $prductDiscount) * $product->quantity ) * $product->tax / 100;

                                                        if ($product->discount > 0) {
                                                            $discountProductTotal += $prductDiscount * $product->quantity;
                                                        }
                                                        $subTotalAmount += $product->price * $product->quantity;
                                                    }
                                                    $discount = $order->total_discount;
                                                    $vat =($order->amount * $order->total_tax) / 100;
                                                @endphp
                                                @php
                                                    $paid =0;
                                                @endphp
                                            <tr>
                                                <td colspan="9" style="text-align: right">
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
                                                            <li>{{__('quotation.Other Tax')}} ({{ $order->total_tax }}%)
                                                                :
                                                            </li>
                                                        @endif
                                                        @if ($discount > 0)
                                                            <li>{{__('quotation.Discount')}}
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
                                                        @if($order->shipping_charge > 0)
                                                            <li class="nowrap">{{single_price($order->shipping_charge)}}</li>
                                                        @endif
                                                        @if($order->other_charge > 0)
                                                            <li class="nowrap">{{single_price($order->other_charge)}}</li>
                                                        @endif
                                                        <li class="border-top-0">{{single_price($order->payable_amount)}}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($order->notes != null)
                                <div class="col-12 mt-10">
                                    <h3>{{__('quotation.Quotation Note')}}</h3>
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
