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
                        <form class="" action="{{ route('packing.recieve_report.search') }}" method="GET">
                            <div class="row">
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('report.Date From')}}
                                            <small>({{__('report.Date Range')}})</small></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        @isset($dateFrom)
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="fromDate" type="text" name="from_date"
                                                                   value="{{ date('m/d/Y', strtotime($dateFrom)) }}"
                                                                   autocomplete="off">
                                                        @else
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="fromDate" type="text" name="from_date" value=""
                                                                   autocomplete="off">
                                                        @endisset
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('report.Date To')}}
                                            <small>({{__('report.Date Range')}})</small></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        @isset($dateTo)
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="toDate" type="text" name="dateTo"
                                                                   value="{{ date('m/d/Y', strtotime($dateTo)) }}"
                                                                   autocomplete="off">
                                                        @else
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="toDate" type="text" name="to_date" value=""
                                                                   autocomplete="off">
                                                        @endisset
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Product') }}</label>
                                        <select class="primary_select mb-15" name="productSku_id" id="productSku_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($productSku_id)
                                                @foreach ($productSkus as $productSku)
                                                    <option value="{{ $productSku->id }}"
                                                            @if ($productSku->id == $productSku_id) selected @endif>{{ @$productSku->product->product_name }}@if (variantNameFromSku($productSku)) - ({{ variantNameFromSku($productSku) }}) @endif</option>
                                                @endforeach
                                            @else
                                                @foreach ($productSkus as $productSku)
                                                    <option
                                                        value="{{ $productSku->id }}">{{ @$productSku->product->product_name }}@if (variantNameFromSku($productSku)) - ({{ variantNameFromSku($productSku) }}) @endif</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <span class="text-danger">{{$errors->first('productSku_id')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>

                                <div class="primary_input ml-2">
                                    <a href="{{route('packing.report.product')}}" class="primary-btn fix-gr-bg"
                                       id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                @isset($items)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Recieve Products Packing Reports') }}</h3>
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
                                            <th scope="col">{{__('sale.Invoice')}}</th>
                                            <th scope="col">{{__('sale.Reference No')}}</th>
                                            <th scope="col">{{__('inventory.Branch')}}</th>
                                            <th scope="col">{{__('common.Supplier')}}</th>
                                            <th scope="col">{{__('report.Recieve Qty')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $key=> $item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ date(app('general_setting')->dateFormat->format, strtotime($item->created_at)) }}</td>
                                                <td><a href="{{route('packing_order.show',$item->packing_order->id)}}" target="_blank">{{@$item->packing_order->invoice_no}}</a></td>
                                                <td>{{@$item->packing_order->ref_no}}</td>
                                                <td>{{@$item->packing_order->packable->name}}</td>
                                                <td>
                                                    <a href="{{route('supplier.view',$item->packing_order->supplier_id)}}"
                                                       target="_blank">{{@$item->packing_order->supplier->name}}</a>
                                                </td>
                                                <td>{{$item->rcv_quantity}} </td>
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
        function getDetails(el) {
            $.post('{{ route('get_sale_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
