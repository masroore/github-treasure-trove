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
                        <form class="" action="{{ route('balance_statement_report.index') }}" method="GET">
                            <div class="row">
                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.Accounting Time Period') }}</label>
                                        <select class="primary_select mb-15" name="interval" id="interval">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($timePeriod)
                                                @foreach ($timePeriods->where('is_closed', 1) as $key => $timeInterval)
                                                    <option value="{{ $timeInterval->id }}" @if ($timePeriod == $timeInterval->id) selected @endif>{{ ($timeInterval->end_date) ? $timeInterval->end_date : "Present" }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($timePeriods->where('is_closed', 1) as $key => $timeInterval)
                                                    <option value="{{ $timeInterval->id }}">{{ ($timeInterval->end_date) ? $timeInterval->end_date : "Present" }}</option>
                                                @endforeach
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
                                    <a href="{{route('balance_statement_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($closedBalanceList)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Balance Statement') }}</h3>
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
                                            <th scope="col">{{__('account.Description')}}</th>
                                            <th scope="col">{{__('report.Amount')}}</th>
                                            <th scope="col">{{__('report.Total Amount')}}</th>
                                        </tr>
                                        </thead>
                                        @php
                                            $total_asset = 0;
                                            $total_liability = 0;
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <td>{{__('report.Asset')}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($closedBalanceList->where('acc_type','asset') as $key => $assetAccount)
                                                <tr>
                                                    <td><span class="ml-5"></span>{{ $assetAccount->account->name }}</td>
                                                    <td>
                                                        @php
                                                             $total_asset += $assetAccount->amount;
                                                        @endphp
                                                        {{ single_price($assetAccount->amount) }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th>{{__('report.Total Asset')}}</th>
                                                <th></th>
                                                <th>{{ single_price($total_asset) }}</th>
                                            </tr>
                                            <tr>
                                                <td>{{__('report.Liability')}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($closedBalanceList->where('acc_type','liability') as $key => $liability_account)
                                                <tr>
                                                    <td><span class="ml-5"></span>{{ $liability_account->account->name }}</td>
                                                    <td>
                                                        @php
                                                            $total_liability += $liability_account->amount;
                                                        @endphp
                                                        {{ single_price($liability_account->amount) }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                                <tr>
                                                    <td>{{__('report.Total Liability')}}</td>
                                                    <td></td>
                                                    <td>{{ single_price($total_liability) }}</td>
                                                </tr>
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
