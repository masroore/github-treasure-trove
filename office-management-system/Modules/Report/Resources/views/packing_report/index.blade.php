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
                        <form class="" action="{{ route('packing.report.search') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Sent From') }}</label>
                                        <select class="primary_select mb-15" name="house_id" id="warehouse_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @foreach ($warehouses as $warehouse)
                                                @php
                                                    $w = "$warehouse->id-warehouse";
                                                @endphp
                                                <option
                                                    value="{{ $warehouse->id }}-warehouse" {{isset($house) && $house == $w ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                            @endforeach
                                            @foreach ($showrooms as $showroom)
                                                @php
                                                    $s = "$showroom->id-warehouse";
                                                @endphp
                                                <option
                                                    value="{{ $showroom->id }}-showroom" {{isset($house) && $house == $s ? 'selected' : '' }}>{{ $showroom->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('house_id')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Supplier') }}</label>
                                        <select class="primary_select mb-15" name="supplier_id" id="supplier_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option
                                                    value="{{ $supplier->id }}" {{ isset($supplier_id) && $supplier->id == $supplier_id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.From Date') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="date" type="text" name="from_date"
                                                               value="{{isset($from_date) ? $from_date : ''}}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('from_date')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.To Date') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="date" type="text" name="to_date"
                                                               value="{{isset($to_date) ? $to_date : ''}}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('to_date')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md- col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Receive') }}</label>
                                        <select class="primary_select mb-15" name="receive" id="receive">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                                <option value="0" {{ isset($receive) && $receive == 0 ? 'selected' : '' }}>{{ __('report.Not Received Yet') }}</option>
                                                <option value="1" {{ isset($receive) && $receive == 1 ? 'selected' : '' }}>{{ __('report.Received') }}</option>
                                                <option value="2" {{ isset($receive) && $receive == 2 ? 'selected' : '' }}>{{ __('report.Partially') }}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>
                                <div class="primary_input ml-2">
                                    <a href="{{route('packing.report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($packings)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Packing Report') }}</h3>
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
                                            <th scope="col">{{__('quotation.Date')}}</th>
                                            <th scope="col">{{__('report.House')}}</th>
                                            <th scope="col">{{__('report.Supplier')}} {{__('common.Name')}}</th>
                                            <th scope="col">{{__('quotation.Reference No')}}</th>
                                            <th scope="col">{{__('quotation.Invoice No')}}</th>
                                            <th scope="col">{{__('report.Price')}}</th>
                                            <th scope="col">{{__('report.Qty')}}</th>
                                            <th scope="col">{{__('report.Tax')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($packings as $key=> $packing)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{date(app('general_setting')->dateFormat->format, strtotime($packing->date))}}</td>
                                                <td>{{@$packing->packable->name}}</td>
                                                <td>{{@$packing->supplier->name}}</td>
                                                <td>{{$packing->ref_no}}</td>
                                                <td>{{$packing->invoice_no}}</td>
                                                <td>{{single_price($packing->payable_amount)}}</td>
                                                <td class="text-center">{{$packing->total_quantity}}</td>
                                                <td>{{$packing->total_vat}} %</td>
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
@endpush
