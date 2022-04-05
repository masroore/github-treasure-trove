<div class="modal fade admin-query" id="purchase_info_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __("purchase.Purchase Detail's") }} - ({{ @$order->purchasable->name }})</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('purchase.Date')}}:</label>
                            <label class="primary_input_label" for="">{{__('quotation.Reference No')}}:</label>
                            <label class="primary_input_label" for="">{{__('common.Status')}}:</label>
                            <label class="primary_input_label" for="">{{__('purchase.Pay Term')}}:</label>
                            <label class="primary_input_label" for="">{{__('purchase.Payment Method')}}:</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ date('d-m-Y', strtotime($order->created_at)) }}.</label>
                            <label class="primary_input_label" for="">{{ $order->ref_no }}.</label>
                            <label class="primary_input_label" for="">{{$order->status == 1 ? 'Ordered' : 'Pending'}}.</label>
                            <label class="primary_input_label" for="">{{$order->payment_term}}.</label>
                            <label class="primary_input_label" for="">{{$order->payment_method}}.</label>
                        </div>
                    </div>
                </div>
                @if ($order->supplier)
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('quotation.Supplier')}}:</label>
                                <label class="primary_input_label" for="">{{ __('common.Email') }}:</label>
                                <label class="primary_input_label" for="">{{ __('common.Phone') }}:</label>
                                <label class="primary_input_label" for="">{{ __('common.Alternate Phone') }}:</label>
                                <label class="primary_input_label" for="">{{ __('common.Address') }}:</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ @$order->supplier->name }}.</label>
                                <label class="primary_input_label" for="">{{ @$order->supplier->email }}.</label>
                                <label class="primary_input_label" for="">{{ @$order->supplier->mobile }}.</label>
                                <label class="primary_input_label" for="">{{ @$order->supplier->alternate_contact_no }}.</label>
                                <label class="primary_input_label" for="">{{ @$order->supplier->address }}.</label>
                            </div>
                        </div>
                    </div>
                @endif
                <hr>

                <table class="table table-bordered">
                    <tr class="m-0">
                        <th>{{__('quotation.Product Name')}}</th>
                        <th>{{__('purchase.Sku')}}</th>
                        <th>{{__('quotation.Price')}}</th>
                        <th>{{__('quotation.Quantity')}}</th>
                        <th>{{__('quotation.Tax')}}</th>
                        <th>{{__('quotation.Discount')}}</th>
                        <th>{{__('quotation.SubTotal')}}</th>
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
                            <td class="p-2">{{@$item->productSku->product->product_name}}<br>
                                @if ($variantName)
                                    ({{ $variantName }})
                                @endif
                            </td>
                            <td>{{$item->productSku->sku}}</td>
                            <td class="p-2">{{@$item->price}}</td>
                            <td class="p-2">{{@$item->quantity}}</td>
                            <td class="p-2">{{@$item->tax}}</td>
                            <td class="p-2">{{@$item->discount}}</td>
                            <td class="p-2">{{@$item->sub_total}}</td>
                        </tr>
                    @endforeach
                </table>

                <hr>
                <div class="row">
                    <div class="col">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.Product Qty')}}:</label>
                            <label class="primary_input_label" for="">{{ __('quotation.SubTotal') }}:</label>
                            <label class="primary_input_label" for="">{{ __('quotation.Tax') }}:</label>
                            <label class="primary_input_label" for="">{{ __('quotation.Discount') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Paid Amount') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Return Amount') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Total Amount') }}:</label>
                        </div>
                    </div>
                    @php
                        $tax = ($order->items->sum('sub_total') * $order->items->sum('tax'))/100;
                        $total = ($order->items->sum('sub_total') + $tax) - $order->items->sum('discount');
                    @endphp
                    <div class="col">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ $order->items->sum('quantity') }}</label>
                            <label class="primary_input_label" for="">{{single_price($order->items->sum('sub_total'))}}.</label>
                            <label class="primary_input_label" for="">{{$order->items->sum('tax')}} %.</label>
                            <label class="primary_input_label" for="">{{$order->items->sum('discount')}} %.</label>
                            <label class="primary_input_label" for="">{{single_price($order->payments->sum('amount'))}}.</label>
                            <label class="primary_input_label" for="">{{single_price($order->items->sum('return_amount'))}}.</label>
                            <label class="primary_input_label" for="">{{single_price($total)}}.</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
