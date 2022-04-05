@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="white_box_50px box_shadow_white">
                <div class="row">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('report.Product Information')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                @php
                                    $quantity = $purchase_price = $selling_price = $min_selling_price = 0;
                                @endphp
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.Sl')}}</th>
                                        <th scope="col">{{__('common.Image')}}</th>
                                        <th scope="col">{{__('common.Name')}}</th>
                                        <th scope="col">{{__('product.SKU')}}</th>
                                        <th scope="col">{{__('product.In Stock')}}</th>
                                        <th scope="col">{{__('common.Purchase Price')}}</th>
                                        <th scope="col">{{__('common.Selling Price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stocks as $key => $product_stock)
                                        @php
                                        $quantity += $product_stock->stock;
                                        $purchase_price += $product_stock->productSku->cost_of_goods * $product_stock->stock;
                                        $selling_price += $product_stock->productSku->selling_price * $product_stock->stock;
                                        @endphp
                                        <tr>
                                            <th>{{$key+1}}</th>
                                            <td>
                                                <img style="height: 22px;"
                                                     src="{{asset(@$product_stock->productSku->product->image_source ?? 'public/backEnd/img/no_image.png')}}">
                                            </td>
                                            <td>{{@$product_stock->productSku->product->product_name}}</td>
                                            <td>{{@$product_stock->productSku->sku}}</td>
                                            <td>{{$product_stock->stock}} <small>{{@$product_stock->productSku->product->unit_type->name}}</small> </td>
                                            <td>{{single_price(@$product_stock->productSku->cost_of_goods * $product_stock->stock)}}</td>
                                            <td>{{single_price($product_stock->productSku->selling_price * $product_stock->stock)}}</td>

                                        </tr>
                                    @endforeach
                                    <tfoot>
                                    <tr>
                                        <td colspan="4"><b>{{__('common.Total')}}</b></td>
                                        <td>{{$stocks->sum('stock')}}</td>
                                        <td>{{single_price($purchase_price)}}</td>
                                        <td>{{single_price($selling_price)}}</td>
                                    </tr>
                                    </tfoot>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script type="text/javascript">
        function submit() {
            $('#searchStock').submit();
        }
    </script>
@endpush
