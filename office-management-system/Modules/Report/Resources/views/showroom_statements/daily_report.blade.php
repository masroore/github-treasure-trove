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
                        <form class="" action="{{ route('showroom_income_expense_report.daily') }}" method="GET">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Date') }}</label>
                                        <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text" name="date"
                                                                   value="{{ date('m/d/Y', strtotime($date)) }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <span class="text-danger">{{$errors->first('type')}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('report.Date From')}} <small>({{__('report.Date Range')}})</small></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        @isset($dateFrom)
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="fromDate" type="text" name="dateFrom" value="{{ date('m/d/Y', strtotime($dateFrom)) }}" autocomplete="off">
                                                        @else
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="fromDate" type="text" name="dateFrom" value="" autocomplete="off">
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
                                <div class="col-sm-12 col-md-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('report.Date To')}} <small>({{__('report.Date Range')}})</small></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        @isset($dateTo)
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="toDate" type="text" name="dateTo" value="{{ date('m/d/Y', strtotime($dateTo)) }}" autocomplete="off">
                                                        @else
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="toDate" type="text" name="dateTo" value="" autocomplete="off">
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
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>

                                <div class="primary_input ml-2">
                                    <a href="{{route('showroom_income_expense_report.daily')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Branch Income - Expense Statement') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table class="table Crm_table_active2">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('account.Account Name')}}</th>
                                            <th scope="col">{{__('report.Income')}}</th>
                                            <th scope="col">{{__('report.Expense')}}</th>
                                            <th scope="col">{{__('report.Profit/Loss')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($no_of_accounts as $key => $no_of_account)
                                                @php
                                                $income = $transactions->where('account_id', $no_of_account->account_id)->where('type', 'Dr')->sum('amount');
                                                $expense = $transactions->where('account_id', $no_of_account->account_id)->where('type', 'Cr')->sum('amount');
                                                @endphp
                                                <tr>
                                                    <td>{{ $no_of_account->account->name }}</td>
                                                    <td>{{ single_price($income) }}</td>
                                                    <td>{{ single_price($expense) }}</td>
                                                    <td>{{ single_price($income - $expense) }}</td>
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
