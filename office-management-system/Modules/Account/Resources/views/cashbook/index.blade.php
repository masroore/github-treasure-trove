@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{__("account.Cashbook")}}</h3>
                    </div>
                </div>
            </div>
            <div class="white_box_50px p-5 mb-20">
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <div class="white_box_50px box_shadow_white p-5">
                            <form class="" action="index.html" method="post">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for=""> {{ __('account.Opening Balance') }} </label>
                                    <input class="primary_input_field" name="narration" type="text" value="{{single_price($total_transactions->where('type', 'Cr')->sum('amount') - $total_transactions->where('type', 'Dr')->sum('amount'))}}" readonly>
                                    <span class="text-danger">{{$errors->first('narration')}}</span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="white_box_50px box_shadow_white p-5">
                            <form class="" action="{{ route('cashbook.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Select Date')}}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            @isset($date)
                                                                <input placeholder="Date" class="primary_input_field primary-input date form-control" id="fromDate" type="text" name="date" value="{{ date('m/d/Y', strtotime($date)) }}" autocomplete="off">
                                                            @else
                                                                <input placeholder="Date" class="primary_input_field primary-input date form-control" id="fromDate" type="text" name="date" value="" autocomplete="off">
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
                                    <div class="col-md-2">
                                        <button class="primary_btn_2 mt-30" type="submit" width="100%">{{ __('attendance.Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white_box_50px p-5">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Debit / Expense') }}</h3>
                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <div class="">
                                    <table class="table Crm_table_active2">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('account.Account Name') }}</th>
                                            <th scope="col">{{ __('account.Narration') }}</th>
                                            <th scope="col">{{ __('account.Amount') }}</th>
                                        </tr>
                                        </thead>
                                        @isset($debit_transactions)
                                            <tbody>
                                                @foreach($debit_transactions as $key => $debit)
                                                    <tr>
                                                        <th>{{$debit->account->name}}</th>
                                                        <td>{{$debit->voucherable->narration}}</td>
                                                        <td>{{single_price($debit->amount)}}</td>
                                                    </tr>
                                                @endforeach
                                                <tfoot>
                                                    <td>{{ __('common.Total') }}</td>
                                                    <td></td>
                                                    <td>{{ single_price($debit_transactions->sum('amount')) }}</td>
                                                </tfoot>
                                            </tbody>
                                        @endisset
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Credit / Income') }}</h3>
                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <div class="">
                                    <table class="table Crm_table_active2">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('account.Account Name') }}</th>
                                            <th scope="col">{{ __('account.Narration') }}</th>
                                            <th scope="col">{{ __('account.Amount') }}</th>
                                        </tr>
                                        </thead>
                                        @isset($credit_transactions)
                                            <tbody>
                                                @foreach($credit_transactions as $key => $credit)
                                                    <tr>
                                                        <th>{{$credit->account->name}}</th>
                                                        <td>{{$credit->voucherable->narration}}</td>
                                                        <td>{{single_price($credit->amount)}}</td>
                                                    </tr>
                                                @endforeach
                                                <tfoot>
                                                    <td>{{ __('common.Total') }}</td>
                                                    <td></td>
                                                    <td>{{ single_price($credit_transactions->sum('amount')) }}</td>
                                                </tfoot>
                                            </tbody>
                                        @endisset
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $till_now_balance = $total_transactions->where('type', 'Cr')->sum('amount') - $total_transactions->where('type', 'Dr')->sum('amount');
                $today_balance_in_hand = $credit_transactions->sum('amount') - $debit_transactions->sum('amount');
            @endphp
            <div class="row justify-content-center">
                <div class="col-lg-12 mt-20">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('account.Opening Balance') }}</td>
                                            <td class="text-right">{{ single_price($till_now_balance) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('account.Today Total Income') }}</td>
                                            <td class="text-right">{{ single_price($credit_transactions->sum('amount')) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('account.Today Total Expense') }}</td>
                                            <td class="text-right">{{ single_price($debit_transactions->sum('amount')) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('account.Today Balance\Cash in Hand') }}</td>
                                            <td class="text-right">{{ single_price($today_balance_in_hand) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>{{ __('common.Today Closing Balance') }}</td>
                                            <td class="text-right">{{single_price($till_now_balance + $today_balance_in_hand)}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
