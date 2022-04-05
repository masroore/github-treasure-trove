@extends('backEnd.master')
@section('mainContent')
    @if(session()->has('message-success'))
        <div class="alert alert-success mb-25" role="alert">
            {{ session()->get('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.All Vouche Lists') }}</h3>
                            <a href="javascript:void(0)" style="display: none"
                               class="primary-btn semi_large2 fix-gr-bg all_approved"
                               onclick="approve_modal('{{route('voucher.all.approval')}}')">{{__('common.Approved All')}}</a>
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
                                        @if ($payments->where('is_approve',0)->count() > 0)
                                            <th scope="col">
                                                <label class="primary_checkbox d-flex ">
                                                    <input type="checkbox" onchange="approveBtn()" class="check_all">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                        @endif
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('role.Details') }}</th>
                                        <th scope="col">{{ __('account.Approved') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payments as $key => $payment)
                                        <tr>
                                            @if ($payments->where('is_approve',0)->count() > 0)
                                            <th scope="col">
                                                @if ($payment->is_approve == 0)
                                                    <label class="primary_checkbox d-flex">
                                                        <input name="sms1" type="checkbox" class="approve">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                @endif
                                            </th>
                                            @endif
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $payment->tx_id }}</td>
                                            <td>{{ single_price($payment->amount) }}</td>
                                            <td>
                                                @if ($payment->is_approve == 0)
                                                    <span class="badge_3">{{ __('common.Pending') }}</span>
                                                @elseif ($payment->is_approve == 1)
                                                    <span class="badge_1">{{ __('common.Approved') }}</span>
                                                @else
                                                    <span class="badge_4">{{ __('common.Cancelled') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        <a href="#" data-toggle="modal" class="dropdown-item"
                                                           onclick="voucher_detail({{ $payment->id }})">{{__('account.Approval')}}</a>
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
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
    <div id="Voucher_info">

    </div>
    @include('backEnd.partials.approve_modal')
@endsection

@push("scripts")
    <script type="text/javascript">
        function voucher_detail(el) {
            $.post('{{ route('get_voucher_details') }}', {_token: '{{ csrf_token() }}', id: el}, function (data) {
                $('#Voucher_info').html(data);
                $('#Voucher_info_modal').modal('show');
                $('select').niceSelect();
            });
        }

        function approveBtn() {
            $('.all_approved').toggle();
            let selector = $('.approve');
            if (selector.is(':checked'))
                selector.attr('checked', false);
            else
                selector.attr('checked', true);
        }

    </script>
@endpush
