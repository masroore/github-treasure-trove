@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Product Costing') }} ({{__('inventory.Sales')}})</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{__('product.Image')}}</th>
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('common.Address') }}</th>
                                        <th scope="col">{{__('product.Product Name')}}</th>
                                        <th scope="col">{{__('inventory.Previous Stock')}}</th>
                                        <th scope="col">{{__('inventory.Newly added Stock')}}</th>
                                        <th scope="col">{{__('inventory.Last Costing Price (unit)')}}</th>
                                        <th scope="col">{{__('inventory.New Costing Price (unit)')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cost_of_goods as $key => $cost_of_good)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>
                                                @if (@$cost_of_good->productSku->product->product_type == "Single" && @$cost_of_good->productSku->product->image_source != null)
                                                    <img style="height: 36px;" src="{{asset($cost_of_good->productSku->product->image_source ?? 'public/backEnd/img/no_image.png')}}" alt="{{$cost_of_good->productSku->product->product_name}}">
                                                @elseif(@$cost_of_good->productSku->product->product_type == "Variable" && @$cost_of_good->productSku->product->image_source != null)
                                                    <img style="height: 36px;" src="{{asset($cost_of_good->productSku->product_variation->image_source ?? 'backEnd/img/no_image.png')}}" alt="{{$cost_of_good->productSku->product->product_name}}">
                                                @else
                                                    <img style="height: 36px;" src="{{asset('backEnd/img/no_image.png')}}" alt="{{@$cost_of_good->productSku->product->product_name}}">
                                                @endif
                                            </td>
                                            <td>{{ ($cost_of_good->costable->invoice_no) ? $cost_of_good->costable->invoice_no : "Begining" }}</td>
                                            <td>{{ @$cost_of_good->storeable->name }}</td>
                                            <td>{{ @$cost_of_good->productSku->product->product_name }}</td>
                                            <td>{{ @$cost_of_good->previous_remaining_stock }}</td>
                                            <td>{{ @$cost_of_good->newly_stock }}</td>
                                            <td>{{ single_price(@$cost_of_good->previous_cost_of_goods_sold) }} <small>/{{ @$cost_of_good->productSku->product->unit_type->name }}</small> </td>
                                            <td>{{ single_price(@$cost_of_good->new_cost_of_goods_sold) }} <small>/{{ @$cost_of_good->productSku->product->unit_type->name }}</small></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
