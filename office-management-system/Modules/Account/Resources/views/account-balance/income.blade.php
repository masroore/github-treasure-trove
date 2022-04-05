@extends('backEnd.master', ['title' => 'Profit and Loss Report'])
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


                <div class="col-lg-12">
                    <div class="white-box">
                        <form method="GET" action="{{ route('profit.index') }}">

                            <div class="row">
                                <div class="col-lg-6 mt-30-md">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input date form-control read-only-input has-content" id="startDate" type="text" name="date_from" value="{{ isset($formDate) ? date('m/d/Y', strtotime($formDate)) : date('m/d/Y') }}" readonly="">
                                                <label>{{ __('common.Date From') }}</label>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-30-md">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input date form-control read-only-input" id="startDate" type="text" name="date_to" value="{{ isset($toDate) ? date('m/d/Y', strtotime($toDate)) : date('m/d/Y') }}" readonly="">
                                                <label>{{ __('common.Date To') }}</label>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        {{ __('common.Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                    <div class="col-12 mt-5">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Profit & Loss') }}</h3>
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
                                            <th scope="col">{{__('account.Time')}}</th>
                                            <th scope="col">{{__('report.Income')}}</th>
                                            <th scope="col">{{__('report.Expense')}}</th>
                                            <th scope="col">{{__('report.Profit / Loss')}}</th>
                                        </tr>
                                        </thead>
                                        @php
                                            $total_income = $income->sum('amount');
                                            $total_expense = $expense->sum('amount');
                                            $profitLoss = $total_income - $total_expense;

                                        @endphp

                                        <tbody>
                                        <tr>
                                            <th>{{ isset($formDate) || isset($toDate) ? date('d,F Y', strtotime($formDate)) .' - '. date('d,F Y', strtotime($toDate))  : 'All'}}</th>
                                            <th>{{ single_price($total_income) }}</th>
                                            <th>{{ single_price($total_expense) }}</th>
                                            <th>{{ single_price($profitLoss) }}</th>
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
