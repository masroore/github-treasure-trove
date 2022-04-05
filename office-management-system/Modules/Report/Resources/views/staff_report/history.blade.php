@extends('backEnd.master')
@section('mainContent')

    <section class="mb-40">
        <div class="container-fluid p-0">

            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>{{ $staff->user->name }}</h3>
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
                                    <h3>{{__('report.Current Balance')}} {{ single_price($currentBalance) }}</h3>
                                    <p class="mb-0"></p>
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

                @isset($account_id)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('report.Staff')}} {{ __('report.Ledger Reports') }}</h3>
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" target="_blank"
                                       href="{{Illuminate\Support\Facades\Request::fullUrl()}}?print=1"><i
                                            class="ti-printer"></i>{{__('report.Print')}}</a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    @include('report::staff_report.debit_transaction_list_table', ['chartAccount' => Modules\Account\Entities\ChartAccount::where('contactable_type', 'App\User')->where('contactable_id', $account_id)->first()])
                                </div>
                            </div>
                        </div>
                        @endisset
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
