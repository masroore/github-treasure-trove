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
                        <form class="" action="{{ route('purchase_report.index') }}" method="GET">
                            <div class="row">
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.WareHouse') }}</label>
                                        <select class="primary_select mb-15" name="warehouse_id" id="warehouse_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @if (Auth::user()->role->type == "system_user")
                                                @isset($warehouse_id)
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}" @if ($warehouse->id == $warehouse_id) selected @endif>{{ $warehouse->name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                    @endforeach
                                                @endisset
                                            @else
                                                @isset($warehouse_id)
                                                    <option value="{{ Auth::user()->staff->warehouse_id }}" @if (Auth::user()->staff->warehouse_id == $warehouse_id) selected @endif>{{@Auth::user()->staff->warehouse->name}}</option>
                                                @else
                                                    <option value="{{ Auth::user()->staff->warehouse_id }}">{{@Auth::user()->staff->warehouse->name}}</option>
                                                @endisset
                                            @endif
                                        </select>
                                        <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('inventory.Branch') }}</label>
                                        <select class="primary_select mb-15" name="showRoom_id" id="showRoom_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @if (Auth::user()->role->type == "system_user")
                                                @isset($showRoom_id)
                                                    @foreach ($showrooms as $showroom)
                                                        <option value="{{ $showroom->id }}" @if ($showroom->id == $showRoom_id) selected @endif>{{ $showroom->name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($showrooms as $showroom)
                                                        <option value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                    @endforeach
                                                @endisset
                                            @else
                                                @isset($showRoom_id)
                                                    <option value="{{ Auth::user()->staff->showroom_id }}" @if (Auth::user()->staff->showroom_id == $showRoom_id) selected @endif>{{showroomName()}}</option>
                                                @else
                                                    <option value="{{ Auth::user()->staff->showroom_id }}">{{showroomName()}}</option>
                                                @endisset
                                            @endif
                                        </select>
                                        <span class="text-danger">{{$errors->first('showRoom_id')}}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Supplier') }}</label>
                                        <select class="primary_select mb-15" name="supplier_id" id="supplier_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($supplier_id)
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" @if ($supplier->id == $supplier_id) selected @endif>{{ $supplier->name }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <span class="text-danger">{{$errors->first('customer_id')}}</span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row justify-content-center">
                                    <div class="primary_input">
                                        <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                    </div>

                                    <div class="primary_input ml-2">
                                        <a href="{{route('purchase_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
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
                                            <th scope="col">{{__('report.Return Qty')}}</th>
                                            <th scope="col">{{__('report.Tax')}}</th>
                                            <th scope="col">{{__('retailer.Phone')}}</th>
                                            <th scope="col">{{__('purchase.Pay Term')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $key=> $order)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{date(app('general_setting')->dateFormat->format, strtotime($order->created_at))}}</td>
                                                    <td>{{@$order->purchasable ? $order->purchasable->name : ''}}</td>
                                                    <td>{{@$order->supplier->name}}</td>
                                                    <td><a onclick="getDetails({{ $order->id }})">{{$order->invoice_no}}</a></td>
                                                    <td>{{@single_price($order->amount)}}</td>
                                                    <td class="text-center">{{$order->total_quantity}}</td>
                                                    <td class="text-center">{{$order->items->sum('return_quantity')}}</td>
                                                    <td>{{$order->total_vat}} %</td>
                                                    <td><a href="tel:{{@$order->supplier->mobile}}">{{@$order->supplier->mobile}}</a></td>
                                                    <td>{{$order->payment_term}}</td>
                                                    
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
