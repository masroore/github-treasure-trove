<table class="table Crm_table_active">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">{{ __('leave.Type') }}</th>
        <th scope="col">{{ __('leave.From') }}</th>
        <th scope="col">{{ __('leave.To') }}</th>
        <th scope="col">{{ __('leave.Apply Date') }}</th>
        <th scope="col">{{ __('common.Status') }}</th>
        <th scope="col">{{ __('common.Action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($apply_leaves as $key => $apply_leave)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $apply_leave->leave_type->name }}</td>
            <td>{{ $apply_leave->start_date }} {{$apply_leave->day == 1 ? '('. trans('leave.Single Day') .')' : ($apply_leave->day == 0 ? '('. trans('leave.Half Day') .')' : '')}}</td>
           
            <td>{{ $apply_leave->day == 2 ? $apply_leave->end_date : '' }}</td>
            
            <td>{{ $apply_leave->apply_date }}</td>
            <td>
                @if ($apply_leave->status == 0)
                    <span class="badge_3">Pending</span>
                @elseif ($apply_leave->status == 1)
                    <span class="badge_1">Approved</span>
                @else
                    <span class="badge_4">Cancelled</span>
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
                        @if (permissionCheck('languages.edit_modal'))
                            @if ($apply_leave->status == 0)
                                <a href="javascript:void(0)" class="dropdown-item"
                                   onclick="edit_apply_leave_modal({{ $apply_leave->id }})">{{__('common.Edit')}}</a>
                            @else
                                <a href="#"
                                   class="dropdown-item">{{__('common.Approved')}}</a>
                            @endif
                        @endif
                        <input type="hidden" name="user_id" id="user_id"
                               value="{{ $apply_leave->user_id }}">
                        <a href="javascript:void(0)" id="view_brand" data-id="{{ $apply_leave->id }}"
                           class="dropdown-item">{{__('common.View')}}</a>
                        <a href="{{route('leave.application.download',$apply_leave->id)}}"
                           class="dropdown-item">{{__('common.Download')}}</a>

                        @if ($apply_leave->status == 0)
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
