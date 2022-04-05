@extends('backEnd.master')
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__('purchase.Purchase Receive')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-md-3 col-lg-3">
                                <table class="table-borderless">
                                    <tr>
                                        <td class="info_tbl">{{__('quotation.Date')}}</td>
                                        <td>: {{$order->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('quotation.Ref. No')}}</td>
                                        <td>: {{$order->ref_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('common.Status')}}</td>
                                        <td>: {{$order->status == 1 ? 'Ordered' : 'Pending'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('purchase.Pay Term')}}</td>
                                        <td>
                                            : {{$order->supplier->pay_term}} {{$order->supplier->pay_term_condition}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <table class="table-borderless">
                                    <tr>
                                        <td><b>{{__('quotation.Supplier')}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>{{$order->supplier->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="mailto:{{$order->supplier->email}}">{{$order->supplier->email}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="tel:{{$order->supplier->mobile}}">{{$order->supplier->mobile}}</a>,
                                            <a href="tel:{{$order->supplier->alternate_contact_no}}">{{$order->supplier->alternate_contact_no}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{$order->supplier->address}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-2 col-lg-2 mr-0">
                                <table class="table-borderless">
                                    <tr>
                                        <td><b>{{__('quotation.Shipping Address')}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>{{$order->shipping_address}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-2 col-lg-2">
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
                                                    <a href="{{asset($document)}}" target="_blank"
                                                       download>{{$name[3]}}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <table class="table-borderless">
                                    <tr>
                                        <td><b>{{__('purchase.Company')}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('purchase.Company')}}</td>
                                        <td>: {{ app('general_setting')->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('quotation.Phone')}}</td>
                                        <td>
                                            <a href="{{ app('general_setting')->phone }}">: {{ app('general_setting')->phone }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('quotation.Email')}}</td>
                                        <td>
                                            <a href="mailto:{{ app('general_setting')->email }}">: {{ app('general_setting')->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('purchase.Website')}}</td>
                                        <td>
                                            <a href="{{ app('general_setting')->website_url }}">: {{ app('general_setting')->website_url }}</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-20 col-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="p-2">{{__('quotation.Product Name')}}</th>
                                        <th class="p-2">{{__('purchase.Unit Price')}} ($)</th>
                                        <th class="p-2">{{__('quotation.Quantity')}}</th>
                                        <th class="p-2">{{__('quotation.Subtotal')}} ($)</th>
                                        <th class="p-2">{{__('purchase.Receiving Dates')}}</th>
                                    </tr>
                                    @php
                                        $last_date = '';
                                    @endphp
                                    @foreach($order->receiveProducts as $product)
                                        <tr>
                                            <td class="p-2">{{@$product->item->productSku->product->product_name}}</td>
                                            <td class="p-2">{{@$product->item->price}}</td>
                                            <td class="p-2">{{$product->receive_quantity}}</td>
                                            <td class="p-2">{{single_price($product->item->price * @$product->receive_quantity)}}</td>
                                            <td class="p-2">{{$product->receive_date}}</td>
                                        </tr>
                                    @endforeach
                                </table>

                                <div class="col-12 mt-10">
                                    <h3>{{__('purchase.Purchase Note')}}</h3>
                                    <p>{!! $order->notes !!}</p>
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
            function addQuantity(id) {
                let price = $(".product_price" + id).text();
                let item_quantity = $('.quantity' + id).val();
                let sub_total = (price * item_quantity);
                $('.product_subtotal' + id).text(sub_total);
            }


        </script>
    @endpush

@endsection
