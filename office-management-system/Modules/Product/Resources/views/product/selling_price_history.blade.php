@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.Selling Price History')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active4">
                            <thead>
                            <tr>
                                <th scope="col">{{__('sale.Sl')}}</th>
                                <th scope="col">{{__('common.Name')}}</th>
                                @if (app('general_setting')->origin == 1)
                                    <th scope="col">{{__('common.Part Number')}}</th>
                                @endif
                                <th scope="col">{{__('product.Brand')}}</th>
                                <th scope="col">{{__('product.Model')}}</th>
                                <th scope="col">{{__('common.Purchase Invoice')}}</th>
                                <th scope="col">{{__('common.Old Sell Price')}}</th>
                                <th scope="col">{{__('common.Updated Sell Price')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sell_histories as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ @$item->productSku->product->product_name }}</td>
                                    @if (app('general_setting')->origin == 1)
                                        <td>{{@$item->productSku->product->origin}}</td>
                                    @endif
                                    <td>{{@$item->productSku->product->brand->name}}</td>
                                    <td>{{@$item->productSku->product->model->name}}</td>
                                    <td><a href="{{route('purchase_order.show',@$item->purchase_order->id)}}" target="_blank" class="pointer">{{ @$item->purchase_order->invoice_no }}</a></td>
                                    <td>{{ single_price(@$item->old_price) }}</td>
                                    <td>{{ single_price(@$item->new_selling_price) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
