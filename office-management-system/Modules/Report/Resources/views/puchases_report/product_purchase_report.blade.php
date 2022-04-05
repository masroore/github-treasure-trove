@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('attendance.Select Criteria') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="white_box_50px box_shadow_white pb-3">
                        <form class="" action="{{ route('product_purchase_report.index') }}" method="GET">
                            <div class="row">
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Product') }}</label>
                                        <select class="primary_select mb-15" name="productSku_id" id="productSku_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($productSku_id)
                                                @foreach ($productSkus as $productSku)
                                                    <option value="{{ $productSku->id }}" @if ($productSku->id == $productSku_id) selected @endif>{{ @$productSku->product->product_name }}@if (variantNameFromSku($productSku)) - ({{ variantNameFromSku($productSku) }}) @endif</option>
                                                @endforeach
                                            @else
                                                @foreach ($productSkus as $productSku)
                                                    <option value="{{ $productSku->id }}">{{ @$productSku->product->product_name }}@if (variantNameFromSku($productSku)) - ({{ variantNameFromSku($productSku) }}) @endif</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <span class="text-danger">{{$errors->first('productSku_id')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                    <div class="primary_input">
                                        <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                    </div>

                                    <div class="primary_input ml-2">
                                        <a href="{{route('product_purchase_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                                class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($orders)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Product Purchase & Return Reports') }}</h3>
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
                                            <th scope="col">{{__('sale.Sl')}}</th>
                                            <th scope="col">{{__('sale.Date')}}</th>
                                            <th scope="col">{{__('sale.Product Name')}}</th>
                                            <th scope="col">{{__('sale.Reference No')}}</th>
                                            <th scope="col">{{__('report.House')}}</th>
                                            <th scope="col">{{__('report.Supplier')}}</th>
                                            <th scope="col">{{__('report.Qty')}}</th>
                                            <th scope="col">{{__('report.Return Qty')}}</th>
                                            <th scope="col">{{__('report.Price')}}</th>
                                            <th scope="col">{{__('report.Tax')}}</th>
                                            <th scope="col">{{__('report.Total')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $key=> $sale)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                                <td>{{$sale->productable->product->product_name}}<br>{{variantName($sale)}}</td>
                                                <td><a onclick="getDetails({{ @$sale->itemable->id }})">{{@$sale->itemable->invoice_no}}</a></td>
                                                <td>{{@$sale->itemable->purchasable->name}}</td>
                                                <td>{{@$sale->itemable->supplier->name}}</td>
                                                <td>{{@$sale->quantity}}</td>
                                                <td>{{@$sale->return_quantity}}</td>
                                                <td>{{single_price(@$sale->price * $sale->quantity)}}</td>
                                                <td>{{@$sale->tax}} %</td>
                                                <td>{{single_price(@$sale->sub_total)}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </section>
    <div id="getDetails">

    </div>
@endsection
@push('scripts')
    <script>
        function getDetails(el){
            $.post('{{ route('get_purchase_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#purchase_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
