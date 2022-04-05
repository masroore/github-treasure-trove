@extends('backEnd.master')
@section('mainContent')
    @include("backEnd.partials.alertMessage")
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h4>{{__('common.Select')}} {{__('common.Criteria')}}</h4>
                    <div class="white_box_50px box_shadow_white mb-50 pb-5">
                        <form action="{{route('search.leave.department')}}" method="get">
                            <div class="row">
                                <div class="col-4">
                                    <div class="primary_input mb-15">
                                        <select class="primary_select select_dept" onchange="staffs()"
                                                name="department_id">
                                            <option
                                                value="">{{__('common.Select')}} {{__('organization.Department')}}</option>
                                            @foreach($departments as $department)
                                                <option
                                                    value="{{$department->id}}" {{isset($dept_id) && $dept_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="primary_input mb-15">
                                        <select class="primary_select staffs" name="user_id">
                                            <option value="">{{__('common.Select')}} {{__('staff.Staff')}}</option>
                                            @isset($staffs)
                                                @foreach($staffs as $user)
                                                    <option
                                                        value="{{$user->id}}" {{isset($user_id) && $user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg"><i
                                            class="ti-search"></i> {{__('common.Search')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @isset($leaves)
                    <div class="mt-5 col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="apply_leave_list">
                                    <table class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.ID') }}</th>
                                            <th scope="col">{{ __('leave.Type') }}</th>
                                            <th scope="col">{{ __('staff.Staff') }}</th>
                                            <th scope="col">{{ __('common.Email') }}</th>
                                            <th scope="col">{{ __('leave.From') }}</th>
                                            <th scope="col">{{ __('leave.To') }}</th>
                                            <th scope="col">{{ __('leave.Apply Date') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leaves as $key => $apply_leave)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $apply_leave->leave_type->name }}</td>
                                                <td>{{ $apply_leave->user->name }}</td>
                                                <td>{{ $apply_leave->user->email }}</td>
                                                <td>{{ date(generalSetting()->dateFormat->format, strtotime($apply_leave->start_date)) }}</td>
                                                <td>{{ date(generalSetting()->dateFormat->format, strtotime($apply_leave->end_date)) }}</td>
                                                <td>{{ date(generalSetting()->dateFormat->format, strtotime($apply_leave->apply_date)) }}</td>
                                                <td>
                                                    @if ($apply_leave->status == 0)
                                                        <span class="badge_3">{{__('leave.Pending')}}</span>
                                                    @elseif ($apply_leave->status == 1)
                                                        <span class="badge_1">{{__('leave.Approved')}}</span>
                                                    @else
                                                        <span class="badge_4">{{__('leave.Cancelled')}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="hidden" name="user_id" id="user_id"
                                                           value="{{ $apply_leave->user_id }}">
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
                                                            @if (permissionCheck('languages.edit_modal'))
                                                                <a href="javascript:void(0)" class="dropdown-item"
                                                                   onclick="edit_apply_leave_modal({{ $apply_leave->id }})">{{__('common.View')}}</a>
                                                            @endif
                                                            @if (1)
                                                                <a onclick="confirm_modal('{{route('apply_leave.destroy', $apply_leave->id)}}');"
                                                                   class="dropdown-item">{{__('common.Delete')}}</a>
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
                @endisset
            </div>
        </div>
    </section>
    <div class="edit_form">

    </div>
    @include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        function edit_apply_leave_modal(el) {
            var user_id = $('#user_id').val();
            $.post('{{ route('apply_leave.view') }}', {
                _token: '{{ csrf_token() }}',
                id: el,
                user_id: user_id
            }, function (data) {
                $('.edit_form').html(data);
                $('#Apply_Leave_Edit').modal('show');
                $('select').niceSelect();
            });
        }

        function staffs() {
            let dept = $('.select_dept').val();
            $.ajax({
                method: 'POST',
                url: '{{route('organization.staff')}}',
                data: {
                    department_id: dept,
                    _token: '{{csrf_token()}}',
                },
                success: function (result) {
                    $('.staffs').html(result);
                    $('select').niceSelect('update');
                }
            })
        }

    </script>
@endpush
