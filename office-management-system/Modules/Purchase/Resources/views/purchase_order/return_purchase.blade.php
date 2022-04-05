@extends('backEnd.master')
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__('purchase.Purchase Return')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-md-3 col-lg-3">
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
                                        <td>{{__('common.Status')}}</td>
                                        <td>{{$order->status == 1 ? 'Ordered' : 'Pending'}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('purchase.Pay Term')}}</td>
                                        <td>{{$order->supplier->pay_term}} {{$order->supplier->pay_term_condition}}</td>
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
                                                $name = explode('/',$document)
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
                                        <td>InfixPos</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('agent.Phone')}}</td>
                                        <td><a href="tel:01631102838">01631102838</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('agent.Email')}}</td>
                                        <td><a href="mailto:infix@pos.com">infix@pos.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('purchase.Website')}}</td>
                                        <td><a href="#">infix.pos.com</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-50">
                            <div class="col-12">
                                <form action="{{route("purchase.return.update",$order->id)}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <table class="table Crm_table_active3">
                                                <tr>
                                                    <th class="p-2">{{__('quotation.Product Name')}}</th>
                                                    <th class="p-2">{{__('purchase.Unit Price')}} ($)</th>
                                                    <th class="p-2">{{__('quotation.Quantity')}}</th>
                                                    <th class="p-2">{{__('quotation.Tax')}} (%)</th>
                                                    <th class="p-2">{{__('quotation.Discount')}} ($)</th>
                                                    <th class="p-2">{{__('quotation.Subtotal')}} ($)</th>
                                                    <th class="p-2">{{__('purchase.Return Quantity')}}</th>
                                                    <th class="p-2">{{__('purchase.Return Value')}} ($)</th>
                                                </tr>

                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td class="p-2">{{@$item->productSku->product->product_name}}</td>
                                                        <td class="p-2 product_price{{$item->id}}">{{@$item->price}}</td>
                                                        <td class="p-2">{{@$item->quantity}}</td>
                                                        <td class="p-2">{{@$item->tax}}</td>
                                                        <td class="p-2">{{@$item->discount}}</td>
                                                        <td class="p-2">{{@$item->sub_total}}</td>
                                                        <td class="p-2"><input type="hidden" name="items[]"
                                                                               value="{{$item->id}}">
                                                            <input type="number" onkeyup="addQuantity({{$item->id}})"
                                                                   name="quantity[]" max="{{$item->quantity}}"
                                                                   value="{{$item->return_quantity}}"
                                                                   class="primary_input_field quantity quantity{{$item->id}}">
                                                            <span
                                                                class="text-danger quantity_validate{{$item->id}}"></span>
                                                        </td>

                                                        <td class="p-2 product_subtotal product_subtotal{{$item->id}}">{{$item->return_amount}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    @if ($order->notes)
                                        <div class="col-12 mt-10">
                                            <h3>{{__('purchase.Purchase Note')}}</h3>
                                            <p>{!! $order->notes !!}</p>
                                        </div>
                                    @endif

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
    @push("scripts")
        <script type="text/javascript">
            function addQuantity(id) {
                let price = $(".product_price" + id).text();
                let item_quantity = $('.quantity' + id).val();
                let sub_total = (price * item_quantity);
                $('.product_subtotal' + id).text(sub_total);
            }

            $(document).ready(function () {
                $(".table").dataTable();
            });
        </script>
    @endpush

@endsection
