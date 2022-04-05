
<div class="modal fade admin-query" id="sale_info_modal">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __("purchase.Sales Detail's") }} - ({{ @$sale->saleable->name }})</h4>
                <button type="button" class="close" onclick="modal_close()" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            @php
                $setting = app('general_setting');
            @endphp
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="primary_input float-right">
                            <ul id="theme_nav" class="permission_list sms_list ">
                                <li>
                                    <label class="primary_checkbox d-flex mr-12 ">
                                        <input name="status" class="show_due" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{__('sale.Previous Due')}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="printableArea">
                    <div class="row pt-20">
                        <div class="col-md-4 col-lg-4">
                            <table class="table-borderless">
                                <tr>
                                    <td>{{__('sale.Date')}}</td>
                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
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
                        <div class="col-md-4 col-lg-4">
                        </div>
                        <div class="col-md-4 col-lg-4">
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
                                    <td><a href="mailto:{{$setting->email}}">{{$setting->email}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('sale.Website')}}</td>
                                    <td><a href="#"> {{$setting->website_url}}</a></td>
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

                                @php
                                    $customer = $sale->customer_id != null ? $sale->customer : $sale->agentuser;
                                @endphp
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

                        <div class="col-md-3 col-lg-3 col-sm-12 previous_due" style="display: none">
                            <table class="table-borderless">
                                <tr>
                                    <td><b>{{__('sale.Previous Due')}}</b></td>
                                </tr>
                                <tr>
                                    <td>{{__('Amount')}}:</td>
                                    @if ($sale->customer_id != null)
                                        <td>{{single_price($customer->accounts['due'])}}</td>
                                    @else
                                        <td>{{single_price($customer->accounts['due'])}}</td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-10">
                        <div class="col-12">
                            <div class="QA_section QA_section_modal QA_section_heading_custom">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table class="table Crm_table_active3">
                                            <tr class="m-0 p-2">
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

                                            @foreach($sale->items as $key=> $item)
                                                @php
                                                    $variantName = variantName($item);
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

                                                        @if (app('general_setting')->origin == 1)
                                                            <td></td>
                                                        @endif
                                                        <td></td>
                                                        <td></td>

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
                                                    $subtotal = $sale->items->sum('price') * $sale->items->sum('quantity');
                                                    $total_due = 0;
                                                    $this_due = 0;
                                                    $tax = 0;
                                                    $discountProductTotal = 0;
                                                    $subTotalAmount = 0;
                                                    foreach ($sale->items as $product) {

                                                        $tax +=(($product->price - $product->discount) * $product->quantity ) * $product->tax / 100;

                                                        $discountProductTotal += ($product->discount * $product->quantity);
                                                        $subTotalAmount += $product->price * $product->quantity;
                                                    }
                                                    $this_due = $sale->payable_amount - $sale->payments->sum('amount') - $sale->payments->sum('advance_amount') - $sale->payments->sum('return_amount');
                                                    $discount = $sale->total_discount;
                                                    $vat =( $sale->grand_total / 100) * $sale->total_tax;
                                                @endphp
                                                @php
                                                    $paid =0;
                                                @endphp
                                            <tr>
                                                <td @if (app('general_setting')->origin == 1) colspan="8" @else colspan="7" @endif class="text-right">
                                                    <ul>
                                                        <li>{{__('quotation.SubTotal')}} :</li>
                                                        @if($discountProductTotal >0)
                                                            <li>{{__('sale.Product Wise Discount')}} :</li>
                                                        @endif
                                                        @if($tax >0)
                                                            <li>{{__('sale.Product Wise Tax')}} :</li>
                                                        @endif
                                                        <li>{{__('sale.Grand Total')}} :</li>
                                                        @if($vat > 0)
                                                            <li>{{__('quotation.Other Tax')}} :</li>
                                                        @endif
                                                        @if($discount > 0)
                                                            <li>{{__('quotation.Discount')}} :</li>
                                                        @endif
                                                        @if($sale->shipping_charge > 0)
                                                            <li>{{__('purchase.Shipping Charge')}}
                                                                :</li>
                                                        @endif
                                                        @if($sale->other_charge > 0)
                                                            <li>{{__('purchase.Other Charge')}}
                                                                :</li>
                                                        @endif

                                                        <li class="border-top-0">{{__('sale.Total Amount')}} :</li>
                                                        <li class="border-top-0">{{__('sale.Due')}} :</li>
                                                    </ul>
                                                </td>
                                                <td class="text-right">
                                                    <ul>
                                                        <li>{{single_price($subTotalAmount)}}</li>
                                                        @if($discountProductTotal >0)
                                                            <li>{{single_price($discountProductTotal)}}</li>
                                                        @endif
                                                        @if($tax >0)
                                                            <li>{{single_price($tax)}}</li>
                                                        @endif
                                                        <li>{{ single_price($sale->grand_total) }}</li>
                                                        @if($vat > 0)
                                                            <li>{{single_price($vat)}}</li>
                                                        @endif
                                                        @if($discount > 0)
                                                            <li>{{single_price($discount)}}</li>
                                                        @endif

                                                        @if($sale->shipping_charge > 0)
                                                            <li>{{single_price($sale->shipping_charge)}}</li>
                                                        @endif
                                                        @if($sale->other_charge > 0)
                                                            <li>{{single_price($sale->other_charge)}}</li>
                                                        @endif

                                                        <li class="border-top-0">{{single_price($sale->payable_amount)}}</li>
                                                        <li class="border-top-0">{{ ($this_due > 0) ? single_price($this_due) : single_price(0)}}</li>
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
                        @if ($sale->notes)
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-10 text-justify">
                                <h3>{{__('sale.Sale Note')}}</h3>
                                <p>{!! $sale->notes !!}</p>
                            </div>
                        @endif
                        @if (app('general_setting')->terms_conditions)
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-10 text-justify">
                                <h3>{{__('setting.Terms & Condition')}}</h3>
                                <p>{{app('general_setting')->terms_conditions}}</p>
                            </div>
                        @endif
                    </div>
                    {{-- <div class="row mt-60">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('frontend/img/signature.png') }}" alt="" >
                            <p>--------------------------</p>
                            <p>{{__('sale.Customer')}}</p>
                            <p>{{__('sale.Signature')}}</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="{{ $sale->creator->signature ? asset($sale->creator->signature) : asset('frontend/img/signature.png') }}" alt="" >
                            <p>--------------------------</p>
                            <p>{{__('sale.Accountant')}}</p>
                            <p>{{__('sale.Signature')}}</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="{{ $sale->updater->signature ? asset($sale->updater->signature) : asset('frontend/img/signature.png') }}" alt="">
                            <p>--------------------------</p>
                            <p>{{__('sale.Authorized')}}</p>
                            <p>{{__('sale.Signature')}}</p>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="row text-center mt-20">
                    <div class="col-md-12 col-12">
                        <a href="javascript:void(0)" class="primary-btn fix-gr-bg mr-2"
                           onclick="printDiv('printableArea')">{{__('pos.Print')}}</a>
                        <a href="javascript:void(0)" onclick="modal_close()"
                           class="primary-btn fix-gr-bg mr-2"  data-dismiss="modal">{{__('common.Close')}}</a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
