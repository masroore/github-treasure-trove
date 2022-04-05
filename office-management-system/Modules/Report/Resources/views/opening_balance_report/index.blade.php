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
                        <form class="" action="{{ route('opening_balance_report.index') }}" method="GET">
                            <div class="row">
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Type') }}</label>
                                        <select class="primary_select mb-15" name="type" id="type">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($type)
                                                <option value="supplier" @if ($type == "supplier") selected @endif>{{__('common.Supplier')}}</option>
                                                <option value="customer" @if ($type == "customer") selected @endif>{{__('common.Customer')}}</option>
                                                <option value="agent" @if ($type == "agent") selected @endif>{{__('common.Agent')}}</option>
                                                <option value="staff" @if ($type == "staff") selected @endif>{{__('common.Staff')}}</option>
                                                <option value="showroom" @if ($type == "showroom") selected @endif>{{__('report.ShowRoom')}}</option>
                                            @else
                                                <option value="supplier">{{__('common.Supplier')}}</option>
                                                <option value="customer">{{__('common.Customer')}}</option>
                                                <option value="agent">{{__('common.Agent')}}</option>
                                                <option value="staff">{{__('common.Staff')}}</option>
                                                <option value="showroom">{{__('report.ShowRoom')}}</option>
                                            @endisset
                                        </select>
                                        <span class="text-danger">{{$errors->first('type')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>

                                <div class="primary_input ml-2">
                                    <a href="{{route('opening_balance_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($opening_balances)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Opening Balance Reports') }}</h3>
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
                                            <th scope="col">{{__('report.Type')}}</th>
                                            <th scope="col">{{__('report.Account Name')}}</th>
                                            <th scope="col">{{__('common.Amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($opening_balances as $key=> $opening_balance)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{date(app('general_setting')->dateFormat->format, strtotime($opening_balance->created_at))}}</td>
                                                    <td>{{@$opening_balance->type}}</td>
                                                    <td>{{@$opening_balance->chartAccount->name}}</td>
                                                    <td>{{single_price(@$opening_balance->amount)}}</td>
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
