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
                        <form class="" action="{{ route('cash_flow_report.index') }}" method="GET">
                            <div class="row">
                                <div class="col">
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
                                <div class="col">
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
                                    <a href="{{route('cash_flow_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($set)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Cash Flow Statement') }}</h3>
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
                                            <th scope="col">{{__('common.Date')}}</th>
                                            <th scope="col">{{__('report.Calculation')}}</th>
                                            <th scope="col">{{__('report.Balance')}}</th>
                                        </tr>
                                        </thead>
                                        @php
                                            $total_Payments = 0;
                                            $total_Recieves = 0;
                                        @endphp
                                        <tbody>
                                            @foreach ($cashflowSatementsPayments as $key => $expenseAccount)
                                                @php
                                                    $total_Payments += $expenseAccount->amount;
                                                @endphp
                                                <tr>
                                                    <td><span class="ml-5"></span>- {{ $expenseAccount->account->name }}</td>
                                                    <td>{{ $expenseAccount->type }}</td>
                                                    <td>{{ $expenseAccount->voucherable->date }}</td>
                                                    <td>{{ single_price($total_Payments) }}</td>
                                                    <td>{{ single_price($expenseAccount->amount) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>{{__('report.Total Payments')}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ single_price($cashflowSatementsPayments->sum('amount')) }}</td>
                                            </tr>
                                            @foreach ($cashflowSatementsRecieves as $key => $incomeAccount)
                                                @php
                                                    $total_Recieves += $incomeAccount->amount;
                                                @endphp
                                                <tr>
                                                    <td><span class="ml-5"></span>- {{ $incomeAccount->account->name }}</td>
                                                    <td>{{ $incomeAccount->type }}</td>
                                                    <td>{{ $incomeAccount->voucherable->date }}</td>
                                                    <td>{{ single_price($total_Recieves) }}</td>
                                                    <td>{{ single_price($incomeAccount->amount) }}</td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td>{{__('report.Total Recieves')}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ single_price($cashflowSatementsRecieves->sum('amount')) }}</td>
                                            </tr>
                                            @if ($cashflowSatementsRecieves->sum('amount') > $cashflowSatementsRecieves->sum('amount'))
                                                <tr>
                                                    <td>{{__('report.Total Difference')}} <small>({{ __('report.Total Payments') }} - {{__('report.Total Recieves')}})</small> </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ single_price($cashflowSatementsPayments->sum('amount') - $cashflowSatementsRecieves->sum('amount')) }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{__('report.Total Difference')}} <small>( {{__('report.Total Recieves')}} - {{ __('report.Total Payments') }})</small> </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ single_price($cashflowSatementsRecieves->sum('amount') - $cashflowSatementsPayments->sum('amount')) }}</td>
                                                </tr>
                                            @endif

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
@endsection
