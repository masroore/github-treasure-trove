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
                        <form class="" action="{{ route('sales_return_report.index') }}" method="GET">
                            <div class="row">
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
                                        <label class="primary_input_label" for="">{{ __('report.Customer') }}</label>
                                        <select class="primary_select mb-15" name="customer_id" id="customer_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($customer_id)
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" @if ($customer->id == $customer_id) selected @endif>{{ $customer->name }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                        <a href="{{route('sales_return_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                                class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                    </div>


                            </div>
                        </form>
                    </div>
                </div>
                @isset($sales)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Sales Return Reports') }}</h3>
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
                                            <th scope="col">{{__('sale.User')}}</th>
                                            <th scope="col">{{__('common.Customer')}}</th>
                                            <th scope="col">{{__('report.Return Qty')}}</th>
                                            <th scope="col">{{__('report.Price')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sales as $key=> $sale)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                                <td><a onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                                <td><a onclick="getDetails({{ $sale->id }})">{{$sale->ref_no}}</a></td>
                                                <td>{{@$sale->saleable->name}}</td>
                                                <td>{{@$sale->user->name}}</td>
                                                <td>
                                                    @if ($sale->customer_id)
                                                        <a href="{{route('customer.view',$sale->customer_id)}}" target="_blank">{{@$sale->customer->name}}</a>
                                                    @else
                                                        <a href="{{ route('agent.show', @$sale->agentuser->id) }}" target="_blank">{{@$sale->agentuser->name}}</a>
                                                    @endif
                                                </td>
                                                <td>{{ $sale->items->sum('return_quantity') }}</td>
                                                <td>{{single_price(@$sale->items->sum('return_amount'))}}</td>
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
            $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
