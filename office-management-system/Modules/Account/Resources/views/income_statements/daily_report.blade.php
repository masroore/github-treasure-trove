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
                        <form class="" action="{{ route('income_statement_report.daily_report') }}" method="GET">
                            <div class="row">
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Date') }}</label>
                                        <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date"
                                                                   class="primary_input_field primary-input date form-control"
                                                                   id="startDate" type="text" name="date"
                                                                   value="{{isset($date) ? $date : date('m/d/Y')}}" autocomplete="off">
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
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>

                                <div class="primary_input ml-2">
                                    <a href="{{route('income_statement_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Income Statement') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('account.Account Name')}}</th>
                                            <th scope="col">{{__('report.Type')}}</th>
                                            <th scope="col">{{__('report.Calculation')}}</th>
                                            <th scope="col">{{__('report.Balance')}}</th>
                                        </tr>
                                        </thead>
                                        @php
                                            $total_expense = 0;
                                            $total_other_income = 0;
                                            $cost_of_goods_sold = $expenseAccounts->where('code', '03-19')->first();
                                            $income_account_list = $incomeAccounts->whereNotIn('code', ['04-24', '04-15']);
                                            $expense_account_list = $expenseAccounts->whereNotIn('code', ['03-23', '03-19']);
                                        @endphp
                                        <tbody>
                                            @foreach ($expense_account_list as $key => $expenseAccount)
                                                @php
                                                    $total_expense += $expenseAccount->BalanceAmount;
                                                @endphp
                                                <tr>
                                                    <td><span class="ml-5"></span>{{ $expenseAccount->name }}</td>
                                                    <td></td>
                                                    <td>{{ single_price($expenseAccount->BalanceAmount) }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>(-) {{__('report.Total Expense')}}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{single_price($total_expense)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('report.Income')}}</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            @foreach ($income_account_list as $key => $incomeAccount)
                                                @php
                                                    $total_other_income += $incomeAccount->BalanceAmount;
                                                @endphp
                                                <tr>
                                                    <td><span class="ml-5"></span>{{ $incomeAccount->name }}</td>
                                                    <td></td>
                                                    <td>{{ single_price($incomeAccount->BalanceAmount) }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>{{__('report.Total Income')}}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ single_price($total_other_income) }}</td>
                                            </tr>
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
