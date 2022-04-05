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
                        <form class="" action="{{ route('staff_report.search_index') }}" method="GET">
                            <div class="row">

                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('inventory.Branch') }}</label>
                                        <select class="primary_select mb-15" name="showRoom_id" id="showRoom_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>
                                            @if (Auth::user()->role->type == "system_user")
                                                @isset($showRoom_id)
                                                    @foreach ($showrooms as $showroom)
                                                        <option value="{{ $showroom->id }}" @if ($showroom->id == $showRoom_id) selected @endif>{{ $showroom->name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($showrooms as $showroom)
                                                        <option value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                    @endforeach
                                                @endisset
                                            @else
                                                @isset($showRoom_id)
                                                    <option value="{{ Auth::user()->staff->showroom_id }}" @if (Auth::user()->staff->showroom_id == $showRoom_id) selected @endif>{{showroomName()}}</option>
                                                @else
                                                    <option value="{{ Auth::user()->staff->showroom_id }}">{{showroomName()}}</option>
                                                @endisset
                                            @endif
                                        </select>
                                        <span class="text-danger">{{$errors->first('showRoom_id')}}</span>
                                    </div>
                                </div>


                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('inventory.Department') }}</label>
                                        <select class="primary_select mb-15" name="department_id" id="department_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>

                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}" @if ($department->id == $department_id) selected @endif>{{ $department->name }}</option>
                                                @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('department_id')}}</span>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('inventory.WareHouse') }}</label>
                                        <select class="primary_select mb-15" name="warehouse_id" id="warehouse_id">
                                            <option value="">{{__('attendance.Choose One')}}</option>

                                                @foreach ($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}" @if ($warehouse->id == $warehouse_id) selected @endif>{{ $warehouse->name }}</option>
                                                @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('warehouse_id')}}</span>
                                    </div>
                                </div>


                            </div>
                            <div class="row justify-content-center">
                                    <div class="primary_input">
                                        <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                    </div>

                                    <div class="primary_input ml-2">
                                        <a href="{{route('staff_report.index')}}" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                                class="fa fa-refresh"></i>{{ __('report.Reset') }}</a>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($staffs)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Staff Report') }}</h3>
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
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('common.Username') }}</th>
                                        <th scope="col">{{ __('common.Email') }}</th>
                                        <th scope="col">{{ __('common.Phone') }}</th>
                                        <th scope="col">{{ __('role.Role') }}</th>
                                        <th scope="col">{{ __('department.Department') }}</th>
                                        <th scope="col">{{ __('showroom.Branch') }}</th>
                                        <th scope="col">{{ __('common.Registered Date') }}</th>
                                        <th scope="col">{{ __('common.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($staffs as $key => $staff)
                                        @if ($staff->user != null)
                                            <tr>
                                                <th scope="col">
                                                    <label class="primary_checkbox d-flex">
                                                        <input name="sms1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th>{{ $key+1 }}</th>
                                                <td>{{ @$staff->user->name }}</td>
                                                <td>{{ @$staff->user->username }}</td>
                                                <td>{{ @$staff->user->email }}</td>
                                                <td>{{ @$staff->phone }}</td>
                                                <td>{{ @$staff->user->role->name }}</td>
                                                <td>{{ @$staff->department->name }}</td>
                                                <td>{{ @$staff->showroom->name }}</td>
                                                <td>{{ date(app('general_setting')->dateFormat->format, strtotime($staff->created_at)) }}</td>
                                                <td>
                                                    <label class="switch_toggle" for="active_checkbox{{ $staff->id }}">
                                                        <input type="checkbox" id="active_checkbox{{ $staff->id }}" {{ permissionCheck('staffs.edit') ? '' : 'disabled' }} @if ($staff->user->is_active == 1) checked @endif value="{{ $staff->id }}" onchange="update_active_status(this)">
                                                        <div class="slider round"></div>
                                                    </label>
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

                                                            @if($staff->user->role_id !== 1)
                                                            <a href="{{ route('staff_report.history', $staff->id) }}" data-toggle="modal" class="dropdown-item">{{__('account.Account History')}}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.view'))
                                                            <a href="{{ route('staffs.view', $staff->id) }}" class="dropdown-item">{{__('common.View')}}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <!-- shortby  -->
                                                </td>
                                            </tr>
                                        @endif
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
    <div id="getDetails">

    </div>
@endsection
@push('scripts')
    <script>
        function getDetails(el){
            $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
