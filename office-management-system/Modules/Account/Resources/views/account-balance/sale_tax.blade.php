@extends('backEnd.master', ['title' => 'Sale Tax'])
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12 mt-5">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('attendance.Select Criteria') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="white_box_50px box_shadow_white">
                        <form class="" action="{{ route('sale_tax') }}" method="GET">
                            <div class="row">


                                <div class="col-md-6">
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

                                <div class="col-md-3 mt-4">
                                    <div class="primary_input mb-15">
                                        <button type="submit" class="primary-btn fix-gr-bg w-100" id="save_button_parent" ><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>




                    <div class="col-12 mt-5">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('account.Sales Tax')}}</h3>
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

                                                <th scope="col">{{ __('account.Invoice') }}</th>
                                                <th scope="col" class="text-right">{{ __('account.Sales Tax') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @forelse($tax as $t)
                                              <tr>
                                                    <td>{{ $t->voucherable->tx_id }}</td>
                                                    <td class="text-right">{{ single_price($t->amount) }}</td>
                                                  @php
                                                      $total += $t->amount;
                                                  @endphp
                                                </tr>

                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">{{ __('account.No Tax Information Found') }}</td>

                                            </tr>
                                        @endforelse
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>{{ __('common.Total') }}</th>
                                            <th class="text-right">{{ single_price($total) }}</th>
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
    <div id="Voucher_info">

    </div>
    @include('backEnd.partials.delete_modal')
@endsection
@push("scripts")
    <script type="text/javascript">


        $(function() {
            "use strict";
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
