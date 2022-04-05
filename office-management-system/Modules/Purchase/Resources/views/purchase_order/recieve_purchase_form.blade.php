@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('purchase.Receive Products')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{route("purchase.receive.update",$order->id)}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="p-2">{{__('quotation.Product Name')}}</th>
                                                <th class="p-2">{{__('purchase.Unit Price')}}</th>
                                                <th class="p-2">{{__('quotation.Quantity')}}</th>
                                                <th class="p-2 d-none">{{ __('common.Serial No') }}</th>
                                                <th class="p-2 d-none">{{ __('common.Serial No') }} (Excel)</th>
                                                <th class="p-2">{{__('purchase.Total Received')}}</th>
                                                <th class="p-2">{{__('purchase.Receive Quantity')}}</th>
                                                <th class="p-2">{{__('quotation.Subtotal')}}</th>
                                            </tr>

                                            @foreach($order->items as $key=> $item)
                                                <tr>
                                                    <td class="p-2"><input type="hidden" name="product_sku_id[]" value="{{$item->product_sku_id}}">
                                                        {{@$item->productSku->product->product_name}}</td>
                                                    <td class="p-2 product_price{{$item->id}}">{{@$item->price}}</td>
                                                    <td class="p-2">{{@$item->quantity}}</td>
                                                    <td class="d-none">
                                                        <div class="primary_input mb-25">
                                                            <div class="tagInput_field">
                                                                <input class="sr-only" type="text" id="serial_no" name="serial_no[]" data-role="tagsinput" class="sr-only">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="d-none">
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text" id="placeholderFileOneName{{$key}}" placeholder="Browse file" readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg" for="document_file_{{$key}}">{{__("common.Browse")}} </label>
                                                                <input type="file" class="d-none" accept=".xlsx, .xls, .csv" name="file[]" id="document_file_{{$key}}">
                                                            </button>
                                                        </div>
                                                    </td>
                                                    @php
                                                    $received = $order->receiveProducts->where('product_sku_id',$item->product_sku_id)->sum('receive_quantity');
                                                    @endphp
                                                    <td class="p-2">{{$received}}</td>
                                                    <td class="p-2"><input type="hidden" name="items[]"
                                                                           value="{{$item->id}}">
                                                        <input type="number" onkeyup="addQuantity({{$item->id}})"
                                                               name="quantity[]" max="{{$item->quantity - $received}}"
                                                               value="{{$item->quantity - $received}}"
                                                               class="primary_input_field quantity quantity{{$item->id}}">
                                                        <span class="text-danger quantity_validate{{$item->id}}"></span></td>
                                                    <td class="p-2 product_subtotal_{{$item->id}}">
                                                        <input type="hidden" name="subtotal[]" class="product_subtotal{{$item->id}}" value="{{$item->price * $item->quantity}}">
                                                        {{$item->price * ($item->received ?? $item->quantity)}}</td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>

                                        <div class="col-12 mt-5">
                                            <div class="submit_btn text-center">
                                                <button class="primary-btn semi_large2 fix-gr-bg"><i
                                                        class="ti-check"></i>{{__('common.Save')}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
        @push("scripts")
            <script type="text/javascript">
                function addQuantity(id) {
                    let price = $(".product_price" + id).text();
                    let item_quantity = $('.quantity' + id).val();
                    let sub_total = (price * item_quantity);
                    $('.product_subtotal_' + id).text(sub_total);
                    $('.product_subtotal' + id).val(sub_total);
                }
            </script>
    @endpush

@endsection
