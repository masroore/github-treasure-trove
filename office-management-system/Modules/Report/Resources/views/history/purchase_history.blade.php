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
                        <form class="" action="{{ route('purchase.history.search') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Select Product')}}
                                            *</label>
                                        <select class="primary_select mb-15 product_info" id="product_info"
                                                name="product">
                                            <option value="">{{__('sale.Select Product')}}</option>
                                            @foreach ($products as $product)
                                                <option
                                                    value="{{$product->id}}" {{ isset($sku) && $sku == $product->id ? 'selected' : '' }}>{{$product->sku}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('product')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('sale.Select User')}}
                                            *</label>
                                        <select class="primary_select mb-15" id="product_info"
                                                name="user_id">
                                            <option value="">{{__('sale.Select User')}}</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}" {{ isset($user_id) && $user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('user')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.WareHouse') }}</label>
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
                                                    $s = "$showroom->id-showroom";
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
                                        <span class="text-danger">{{$errors->first('supplier_id')}}</span>
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
                                            <span class="text-danger">{{$errors->first('from_date')}}</span>
                                        </div>
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
                                            <span class="text-danger">{{$errors->first('to_date')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>
                                <div class="primary_input ml-2">
                                    <a href="{{route('purchase.history')}}" class="primary-btn fix-gr-bg"
                                       id="save_button_parent"><i class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($items)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Purchases Report') }}</h3>
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
                                            <th scope="col">{{__('quotation.Supplier')}} {{__('common.Name')}}</th>
                                            <th scope="col">{{__('quotation.Reference No')}}</th>
                                            <th scope="col">{{__('report.Price')}}</th>
                                            <th scope="col">{{__('report.Qty')}}</th>
                                            <th scope="col">{{__('report.Tax')}}</th>
                                            <th scope="col">{{__('common.Phone')}}</th>
                                            <th scope="col">{{__('purchase.Pay Term')}}</th>
                                            <th scope="col">{{__('purchase.Is Approved')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $key=> $item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{date(app('general_setting')->dateFormat->format, strtotime($item->created_at))}}</td>
                                                <td>{{@$item->itemable->purchasable->name}}</td>
                                                <td>{{@$item->itemable->supplier->name}}</td>
                                                <td>
                                                    <a onclick="getDetails({{ $item->itemable->id }})">{{$item->itemable->invoice_no}}</a>
                                                </td>
                                                <td>{{single_price($item->price)}}</td>
                                                <td class="text-center">{{$item->quantity}}</td>
                                                <td>{{($item->vat) ? $item->vat : 0}} %</td>
                                                <td>
                                                    <a href="tel:{{@$item->itemable->supplier->mobile}}">{{@$item->itemable->supplier->mobile}}</a>
                                                </td>
                                                <td>{{$item->itemable->payment_term}}</td>
                                                <td>
                                                    @if ($item->itemable->status == 0)
                                                        <h6><span
                                                                class="badge_4">{{__('purchase.Pending')}}</span>
                                                        </h6>
                                                    @else
                                                        <h6><span
                                                                class="badge_1">{{__('common.Approved')}}</span>
                                                        </h6>
                                                    @endif
                                                </td>
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
            $.post('{{ route('get_purchase_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#purchase_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
