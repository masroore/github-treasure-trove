@extends('backEnd.master', ['title' => 'Statement'])
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
                        <form class="" action="{{ route('statement.index') }}" method="GET">

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
                                 <div class="col" class="account_type1" id="account_type1">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.Type') }}</label>
                                        <select class="primary_select mb-25 account_type" id="account_type" required>
                                            <option value="1">{{__('account.Asset')}}</option>
                                            <option value="2">{{__('account.Liability')}}</option>
                                            <option value="3">{{__('account.Expense')}}</option>
                                            <option value="4">{{__('account.Income')}}</option>
                                            <option value="5">{{__('account.Equity')}}</option>
                                        </select>
                                        <span class="text-danger" id="name_error"></span>
                                    </div>
                                </div>


                                <div class="col">
                                    <div class="primary_input mb-15" id="select_account">
                                        <label class="primary_input_label" for="">{{ __('report.Account') }}</label>
                                        <select class="primary_select mb-15 account_id" name="account_id" id="account_id" required>
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @isset($account_id)
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" @if ($account->id == $account_id) selected @endif>{{ @$account->name }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ @$account->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <span class="text-danger">{{$errors->first('account_id')}}</span>
                                    </div>
                                </div>


                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>

                                <div class="primary_input ml-2">
                                    <a href="{{route('statement.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($transactions)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Statement') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                @if ($accont_type == 2 || $accont_type == 4)
                                    @include('account::statement.credit_transaction_list_table')
                                @else
                                    @include('account::statement.debit_transaction_list_table')
                                @endif
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </section>


     <div id="Voucher_info_statement">

    </div>
@endsection
@push('scripts')
    <script>

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

     

         function voucher_detail1(el){
            $.post('{{ route('get_voucher_details_form_statetment') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){

                $('#Voucher_info_statement').html(data);
                $('#Voucher_statement_info_modal').modal('show');
                $('select').niceSelect();
            });
        }


        $(document).on('change', '.account_type', function(){

            var type = $(this).val();

            let url = "{{ route('filterAccountBytype', ":id") }}"
            url = url.replace(":id", type);
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    if (data) {

                        $('#select_account').html('')

                            var option_value = '';
                            $.each(data.accounts, function (key, item) {
                                option_value += `<option value="${item.id}">${item.name}</option>`
                            });

                        $('#select_account').append(
                                '<label class="primary_input_label" for="">{{ __('report.Account') }}</label>'+

                                '<div class="primary_input mb-25">'+
                                    '<select class="primary_select mb-15 account_id" name="account_id" id="account_id">'+
                                     ' <option value="">{{__('attendance.Choose One')}}</option>'+
                                    option_value+
                                   '</select'+
                                '</div>'
                            );

                        $('select').niceSelect();

                    }
                }
            });

            console.log(type)
        })

    </script>
@endpush
