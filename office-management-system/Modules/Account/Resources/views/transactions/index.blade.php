@extends('backEnd.master', ['title' => 'Transaction'])
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
                    <div class="white_box_50px box_shadow_white">
                        <form class="" action="{{ route('transaction.search') }}" method="GET">
                            <div class="row">


                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{__('report.Date Range')}}</label>

                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">

                                                            <input placeholder="Date" class="primary_input_field primary-input form-control"  type="text" name="date_range" value="">


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
                                        <label class="primary_input_label" for="">{{ __('account.Account Type') }}</label>
                                        <select class="primary_select mb-15" name="account_type" id="account_type">
                                                    <option value="1">{{__('account.Asset')}}</option>
                                                    <option value="2">{{__('account.Liability')}}</option>
                                                    <option value="3">{{__('account.Expense')}}</option>
                                                    <option value="4">{{__('account.Income')}}</option>
                                                    <option value="5">{{__('account.Equity')}}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('account_type')}}</span>
                                    </div>
                                </div>


                              

                                <div class="col mt-4">
                                    <div class="primary_input mb-15">
                                        <button type="submit" class="primary-btn w-100 fix-gr-bg" id="save_button_parent" ><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($transactionLists)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Transactions') }}({{ __('account.General Ledger') }})</h3>
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

                                                <th scope="col">{{ __('account.ID') }}</th>
                                                <th scope="col">{{ __('account.Type') }}</th>
                                                <th scope="col">{{ __('account.Chart Of Account') }}</th>
                                                <th scope="col">{{ __('account.Amount') }}</th>
                                                <th scope="col">{{ __('account.Date') }}</th>
                                                <th scope="col">{{ __('account.Note') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactionLists as $key => $transactionList)
                                                <tr>

                                                    <td><a onclick="voucher_detail({{ $transactionList->id }})">{{ $transactionList->tx_id }}</a></td>

                                                    <td>
                                                        {{ @$transactionList->voucher_account_type }}
                                                    </td>
                                                    <td>
                                                        {{ @$transactionList->account->name }}
                                                    </td>
                                                    <td>{{ single_price($transactionList->amount) }}</td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($transactionList->date)) }}</td>
                                                    <td>{{ $transactionList->narration }}</td>
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
    <div id="Voucher_info">

    </div>
    @include('backEnd.partials.delete_modal')
@endsection
@push("scripts")
    <script type="text/javascript">


        $(function() {

              $('input[name="date_range"]').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    "startDate": moment().subtract(7, 'days'),
                    "endDate": moment()
                }, function(start, end, label) {
                  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
        });


        $(document).ready(function () {
            $("#toDate").primary_datepicker_input('disable');
        });
        function voucher_detail(el){
            $.post('{{ route('get_voucher_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#Voucher_info').html(data);
                $('#Voucher_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
