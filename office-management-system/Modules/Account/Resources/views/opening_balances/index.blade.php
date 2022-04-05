@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Opening Balance') }}</h3>
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
                                        <th scope="col">
                                            <label class="primary_checkbox d-flex ">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('account.Account Period Start') }}</th>
                                        <th scope="col">{{ __('account.Account Period End') }}</th>
                                        <th scope="col">{{ __('common.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($timeIntervals as $key => $timeInterval)
                                        <tr>
                                            <th scope="col">
                                                <label class="primary_checkbox d-flex">
                                                    <input name="sms1" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($timeInterval->start_date)) }}</td>
                                            <td>{{ ($timeInterval->end_date) ? date(app('general_setting')->dateFormat->format, strtotime($timeInterval->end_date)) : "X" }}</td>
                                            <td>
                                                @if ($timeInterval->is_closed == 0)
                                                    <span class="badge_3">{{ __('common.Open') }}</span>
                                                @else
                                                    <span class="badge_4">{{ __('common.Closed') }}</span>
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
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        @if ($timeInterval->is_closed == 0)
                                                        @if(permissionCheck('openning_balance.closeStatement'))
                                                            <a onclick="closingPeriodModal({{ $timeInterval->id }})" class="dropdown-item edit_brand">{{__('account.Close Now')}}</a>
                                                        @endif
                                                            @if(permissionCheck('openning_balance.edit'))
                                                            <a href="{{ route('openning_balance.edit', $timeInterval->id) }}" data-toggle="modal" class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                            @endif
                                                            @if(permissionCheck('openning_balance.destroy'))
                                                            <a onclick="confirm_modal('{{route('openning_balance.destroy', $timeInterval->id)}}');" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif
                                                        @else
                                                            <a href="#" class="dropdown-item">{{__('account.Account Closed')}}</a>
                                                        @endif
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
    <div class="modal fade admin-query" id="closingPeriodModal">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('openning_balance.closeStatement')}}" id="addBalanceModalForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="timeInterval_id" id="timeInterval_id" value="">
                            <div class="col-xl-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('account.Closing Date')}}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date" class="primary_input_field primary-input date form-control" id="startDate" type="text" name="date" value="{{date('m/d/Y')}}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Approve') }} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@include('backEnd.partials.delete_modal')
@endsection

@push("scripts")
    <script type="text/javascript">
        function closingPeriodModal(el)
        {
            $("#timeInterval_id").val(el);
            $("#closingPeriodModal").modal('show');
        }
    </script>
@endpush
