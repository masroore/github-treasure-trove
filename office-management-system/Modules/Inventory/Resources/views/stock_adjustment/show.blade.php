@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('product.Stock Adjustment Details')}}</h3>
                                <a href="javascript:void(0)" onclick="printDiv('printableArea')" class="primary-btn semi_large2 fix-gr-bg">{{__('sale.Print')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white" id="printableArea">
                            <div class="row pb-30 border-bottom">
                                <div class="col-md-6 col-lg-6">
                                    <img src="{{asset('uploads/settings/infix.png')}}" width="100px" alt="">
                                </div>
                            </div>
                            <div class="row pt-30">
                                <div class="col-md-7 col-lg-7">
                                    <table class="table-borderless">
                                        <tr>
                                            <td>{{__('product.Created Date')}}</td>
                                            <td>: {{ userName($stockAdjustment->created_by) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('product.Created User')}}</td>
                                            <td>: {{ ($stockAdjustment->updated_by) ? userName($stockAdjustment->updated_by) : "X" }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('product.Updated User')}}</td>
                                            <td>: {{date(app('general_setting')->dateFormat->format, strtotime($stockAdjustment->created_at))}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('product.Recovery Date')}}</td>
                                            <td>: {{date(app('general_setting')->dateFormat->format, strtotime($stockAdjustment->date))}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('sale.Reference No')}}</td>
                                            <td>: {{$stockAdjustment->ref_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.Status')}}</td>
                                            <td>: {{$stockAdjustment->status == 1 ? 'Approved' : 'Pending'}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('sale.Warehouse')}}</td>
                                            <td>: {{@$stockAdjustment->adjustable->name}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <tr class="m-0">
                                            <th>{{__('sale.Product')}}</th>
                                            <th>{{__('sale.SKU')}}</th>
                                            <th>{{__('sale.Unit Price')}}</th>
                                            <th>{{__('sale.Quantity')}}</th>
                                            <th>{{__('sale.SubTotal')}}</th>
                                        </tr>

                                        @foreach($stockAdjustment->stock_adjustments_products as $item)
                                            @php
                                                $v_name = [];
                                                $v_value = [];
                                                $p_name = [];
                                                $p_qty = [];
                                                $variantName = null;
                                                if ($item->productSku->product && $item->productSku->product_variation) {
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
                                            @if ($item->productSku->product)
                                                <tr class="text-center">
                                                    <td>
                                                        {{$item->productSku->product->product_name}} <br>
                                                        @if ($variantName)
                                                            ({{ $variantName }})
                                                        @endif
                                                    </td>
                                                    <td>{{$item->productSku->sku}}</td>
                                                    <td>{{single_price($item->unit_price)}}</td>
                                                    <td>{{$item->qty}}</td>
                                                    <td class="product_subtotal product_subtotal{{$item->id}}">{{single_price($item->subtotal)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tfoot>
                                        <tr>
                                            <td colspan="3" style="text-align: right">{{__('product.Total Products')}}</td>
                                            <td class="text-center">{{$stockAdjustment->stock_adjustments_products->sum('qty')}}</td>
                                            <td colspan="3" style="text-align: right">
                                                <ul>
                                                    <li>Total : {{single_price($stockAdjustment->stock_adjustments_products->sum('subtotal'))}}</li>
                                                    <li class="border-top-0">Total Recovery : {{single_price($item->recovery_amount)}}</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-lg-6 col-md-6 col-sm-12 mt-10">
                                    <h3>{{__('product.Reason')}}</h3>
                                    <p>{!! $stockAdjustment->reason !!}</p>
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
                    setTimeout(function(){ window.location.reload(); }, 15000);
                }
            </script>
    @endpush

@endsection
