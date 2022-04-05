<div class="modal fade admin-query" id="purchase_info_modal">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __("purchase.Purchase Detail's") }} - ({{ @$order->purchasable->name }})</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            @php
                $setting = app('general_setting');
            @endphp
            <div class="modal-body">
                <div id="printableArea">
                    <div class="row mt-30">
                        <div class="col-md-5 col-lg-5">
                            <table class="table-borderless">
                                <tr>
                                    <td>{{__('purchase.Date')}}</td>
                                    <td>{{date(app('general_setting')->dateFormat->format, strtotime($order->created_at))}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('quotation.Reference No')}}</td>
                                    <td>{{$order->ref_no}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.Status')}}</td>
                                    <td>{{$order->status == 1 ? 'Ordered' : 'Pending'}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('purchase.Pay Term')}}</td>
                                    <td>{{$order->supplier->pay_term}} {{$order->supplier->pay_term_condition}}</td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-md-3 col-lg-3">
                            <table class="table-borderless">
                                <tr>
                                    <td><b>{{__('quotation.Supplier')}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{@$order->supplier->name}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="mailto:{{@$order->supplier->email}}">{{@$order->supplier->email}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="tel:{{@$order->supplier->mobile}}">{{@$order->supplier->mobile}}</a>,
                                        <a href="tel:{{@$order->supplier->alternate_contact_no}}">{{@$order->supplier->alternate_contact_no}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{@$order->supplier->address}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <table class="table-borderless">
                                <tr>
                                    <td><b>{{__('purchase.Company')}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{__('purchase.Company')}}</td>
                                    <td>{{$setting->company_name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('retailer.Phone')}}</td>
                                    <td><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></td>
                                </tr>
                                <tr>
                                    <td>{{__('retailer.Email')}}</td>
                                    <td><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></td>
                                </tr>
                                <tr>
                                    <td>{{__('purchase.Website')}}</td>
                                    <td><a href="{{$setting->website_url}}">{{$setting->website_url}}</a></td>
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
                            <div class="QA_section QA_section_modal QA_section_heading_custom">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table class="table Crm_table_active3">
                                            <tr class="m-0">
                                                <th scope="col">{{__('sale.Product Name')}}</th>
                                                @if (app('general_setting')->origin == 1)
                                                <th scope="col">{{__('product.Part No.')}}</th>
                                                @endif
                                                <th scope="col">{{__('product.Model')}}</th>
                                                <th scope="col">{{__('product.Brand')}}</th>
                                                <th scope="col">{{__('sale.Price')}}</th>
                                                <th scope="col">{{__('sale.Quantity')}}</th>
                                                <th scope="col">{{__('sale.Tax')}}</th>
                                                <th class="text-right" scope="col">{{__('sale.Discount')}}</th>
                                                <th class="text-right" scope="col">{{__('sale.SubTotal')}}</th>
                                            </tr>

                                            @foreach($order->items as $key=> $item)
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
                                                        @if (app('general_setting')->origin == 1)
                                                            <td>
                                                                {{@$item->productSku->product->origin}}
                                                            </td>
                                                        @endif
                                                        <td>{{@$item->productSku->product->model->name}}</td>
                                                        <td>{{@$item->productSku->product->brand->name}}</td>
                                                        <td>{{single_price($item->price)}}</td>
                                                        <td>{{$item->quantity}}</td>
                                                        <td>{{$item->tax}}%</td>
                                                        <td class="text-right">{{single_price($item->discount)}}</td>
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

                                                        <td class="product_sku"></td>

                                                        <td>{{single_price($item->price)}}</td>

                                                        <td>{{$item->quantity}}</td>

                                                        <td>{{$item->tax}}%</td>

                                                        <td class="text-right">{{single_price($item->discount)}}</td>
                                                        <td class="text-right"> {{single_price($item->price * $item->quantity)}} </td>
                                                    </tr>
                                                @endif
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
                                                    $vat =($order->amount * $order->total_vat) / 100;
                                                @endphp
                                                @php
                                                    $paid =0;
                                                @endphp
                                            <tr>
                                                <td @if (app('general_setting')->origin == 1) colspan="8" @else colspan="7" @endif class="text-right">
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
                                                        @if($order->total_discount > 0)
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
                                                        <li class="border-top-0">{{__('sale.Total Due')}}
                                                            :</li>
                                                    </ul>
                                                </td>
                                                <td class="text-right">
                                                    <ul>
                                                        <li>{{single_price($subTotalAmount)}}</li>
                                                        @if($discountProductTotal > 0)
                                                            <li>-{{ single_price($discountProductTotal)}}
                                                            </li>
                                                        @endif
                                                        @if($tax > 0)
                                                            <li>{{single_price($tax)}}
                                                            </li>
                                                        @endif
                                                        @if($vat > 0)
                                                            <li>{{ single_price($vat)}}
                                                            </li>
                                                        @endif
                                                        @if($order->total_discount > 0)
                                                            <li>-{{single_price($order->total_discount)}}</li>
                                                        @endif
                                                        @if($order->shipping_charge > 0)
                                                            <li>{{single_price($order->shipping_charge)}}</li>
                                                        @endif
                                                        @if($order->other_charge > 0)
                                                            <li>{{single_price($order->other_charge)}}</li>
                                                        @endif
                                                        <li class="border-top-0">{{single_price($order->payable_amount)}}</li>
                                                        <li class="border-top-0">{{single_price($order->payable_amount - $paid)}}</li>
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
                    <div class="row mt-30 mb-60">
                        @if ($order->notes)
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-10 text-justify">
                                <h3>{{__('sale.Sale Note')}}</h3>
                                <p>{!! $order->notes !!}</p>
                            </div>
                        @endif
                        @if (app('general_setting')->terms_conditions)
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-10 text-justify">
                                <h3>{{__('setting.Terms & Condition')}}</h3>
                                <p>{{app('general_setting')->terms_conditions}}</p>
                            </div>
                        @endif
                    </div>
                  
            </div>
        </div>
    </div>
</div>
