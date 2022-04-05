@extends('backEnd.master')
@section('mainContent')

    <section class="mb-40">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__('account.Bank Account Details')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="mt-10">{{ $bank->bank_name }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="mt-10">{{__('report.Current Balance')}} {{ $currentBalance }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.Ledger Reports') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table class="table Crm_table_active">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('account.Date') }}</th>
                                            <th scope="col">{{ __('account.Date') }}</th>
                                            <th scope="col">{{ __('account.Description') }}</th>
                                            <th scope="col">{{ __('account.Debit') }}</th>
                                            <th scope="col">{{ __('account.Credit') }}</th>
                                            <th scope="col" class="text-right">{{ __('account.Balance') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                           $currentBalance = 0 + $opening_balance ;
                                        @endphp
                                        <tr>
                                            <td colspan="5">{{ __('account.Openning Balance') }}</td>
                                            <td class="text-right">{{ single_price($opening_balance) }}</td>
                                        </tr>
                                        @foreach ($chartAccount->transactions as $key => $payment)
                                            @if ($payment->type == "Dr")
                                                @php
                                                    $currentBalance += $payment->amount;
                                                @endphp
                                            @else
                                                @php
                                                    $currentBalance -= $payment->amount;
                                                @endphp
                                            @endif
                                            <tr>
                                                <td>{{ date(app('general_setting')->dateFormat->format, strtotime(@$payment->voucherable->date)) }}</td>
                                                <td>{{ @$payment->voucherable->referable->ref_no }}</td>
                                                <td>{{ @$payment->voucherable->narration }}</td>
                                                <td>
                                                    @if ($payment->type == "Dr")
                                                        {{ single_price($payment->amount) }}
                                                        <input type="hidden" name="debit[]" value="{{ $payment->amount }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($payment->type == "Cr")
                                                        {{ single_price($payment->amount) }}
                                                        <input type="hidden" name="credit[]" value="{{ $payment->amount }}">
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ single_price($currentBalance) }}</td>
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
    <div id="getDetails">

    </div>
@endsection
@push('scripts')
    <script>
        function getDetails(el) {
            $.post('{{ route('get_purchase_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#purchase_info_modal').modal('show');
                $('select').niceSelect();
            });
        }

        function getsaleDetails(el) {
            $.post('{{ route('get_sale_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
