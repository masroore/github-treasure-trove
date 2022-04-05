@extends('backEnd.master')
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">Purchase Detail's</h3>
                                <a href="{{route('sale.pdf',$sale->id)}}" class="primary-btn semi_large2 fix-gr-bg mr-20">Get Pdf</a>
                                <a href="javascript:void(0)" onclick="printDiv('printableArea')" class="primary-btn semi_large2 fix-gr-bg">Print</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white" id="printableArea">
                            <div class="row pb-30 border-bottom">
                                <div class="col-md-6 col-lg-6">
                                    <img src="{{asset('uploads/settings/infix.png')}}" width="100px" alt="">
                                </div>
                                <div class="col-md-6 col-lg-6 text-right">
                                    <h4>{{$setting->invoice_prefix}}{{$sale->invoice_no}}</h4>
                                </div>
                            </div>
                            <div class="row pt-30">
                                <div class="col-md-4 col-lg-4">
                                    <table class="table-borderless">
                                        <tr>
                                            <td>Date</td>
                                            <td>{{$sale->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <td>Reference No</td>
                                            <td>{{$sale->ref_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{$sale->status == 1 ? 'Paid' : 'Unpaid'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Warehouse</td>
                                            <td>{{@$sale->warehouse->name}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-5 col-lg-5">
                                </div>

                                <div class="col-md-3 col-lg-3">
                                    <table class="table-borderless">
                                        <tr>
                                            <td><b>Company</b></td>
                                        </tr>
                                        <tr>
                                            <td>Company</td>
                                            <td>{{$setting->company_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Website</td>
                                            <td><a href="#">infix.pos.com</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <table class="table-borderless">
                                        <tr>
                                            <td><b>Billed To</b></td>
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{@$sale->customer->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td>
                                                <a href="tel:{{@$sale->customer->mobile}}">{{@$sale->customer->mobile}}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <a href="mailto:{{@$sale->customer->email}}">{{@$sale->customer->email}}</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            <div class="row mt-10">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <tr class="m-0">
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Tax</th>
                                            <th>Discount</th>
                                            <th>Subtotal</th>
                                        </tr>

                                        @foreach($sale->items as $item)
                                            <tr>
                                                <td class="p-2">{{@$item->product->product_name}}</td>
                                                <td class="p-2">{{@$item->product->category->name}}</td>
                                                <td class="p-2">{{@$item->color}}</td>
                                                <td class="p-2">{{@$item->size}}</td>
                                                <td class="p-2">{{@$item->price}}</td>
                                                <td class="p-2">{{@$item->quantity}}</td>
                                                <td class="p-2">{{@$item->tax}}</td>
                                                <td class="p-2">{{@$item->discount}}</td>
                                                <td class="p-2">{{@$item->sub_total}}</td>
                                            </tr>
                                        @endforeach
                                        <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: right">Total Products</td>
                                            <td class="p-2">{{$sale->items->sum('quantity')}}</td>
                                            <td colspan="3" style="text-align: right">
                                                <ul>
                                                    <li>SubTotal : {{$sale->items->sum('sub_total')}}</li>
                                                    <li>Tax : {{$sale->items->sum('tax')}}%</li>
                                                    <li>Discount : {{$sale->items->sum('discount')}}</li>
                                                    @php
                                                        $tax = ($sale->items->sum('sub_total') * $sale->items->sum('tax'))/100;
                                                        $total = ($sale->items->sum('sub_total') + $tax) - $sale->items->sum('discount');
                                                    @endphp
                                                    <li class="border-top-0">Total : {{$total}}</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <div class="col-12 mt-10">
                                        <h3>Purchase Note</h3>
                                        <p>{!! $sale->notes !!}</p>
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
                $(document).ready(function () {
                    $(".table").dataTable();
                });
                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                    window.print();

                    document.body.innerHTML = originalContents;
                }
            </script>
    @endpush

@endsection
