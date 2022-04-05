
@if (permissionCheck('human_resource'))
    @php

        $hr = false;
        $attendance = false;
        $events = false;
        $location = false;

        if(request()->is('hr/*'))
        {
            $hr = true;
        }
        if(request()->is('attendance/*'))
        {
            $attendance = true;
        }
        if(request()->is('events') || request()->is('events/*'))
        {
            $events = true;
        }
        if(request()->is('location/*'))
        {
            $location = true;
        }

    @endphp

    @if (permissionCheck('showroom.index') || permissionCheck('warehouse.index'))
        <li class="{{ $location ?'mm-active' : '' }}">
         <a href="javascript:;" class="has-arrow" aria-expanded="false">
             <div class="nav_icon_small">
                 <span class="fas fa-location-arrow"></span>
             </div>
             <div class="nav_title">
                 <span>{{ __('inventory.Location') }}</span>
             </div>
         </a>
         <ul class="{{request()->is('inventory/showroom') || request()->is('inventory/warehouse') || request()->is('inventory/showroom/*') || request()->is('inventory/warehouse/*') ? 'mm-collapse mm-show' : ''}}">
             @if(permissionCheck('showroom.index'))
         <li>
             <a href="{{ route('showroom.index') }}" class="{{request()->is('inventory/showroom') || request()->is('inventory/showroom/*') ? 'active' : ''}}">{{ __('inventory.Branch') }}</a>
         </li>
         @endif
         @if(permissionCheck('warehouse.index'))
         <li>
             <a href="{{ route('warehouse.index') }}" class="{{request()->is('inventory/warehouse') || request()->is('inventory/warehouse/*') ? 'active' : ''}}">{{ __('inventory.Warehouse') }}</a>
         </li>
         @endif
         </ul>
     </li>
    @endif
    <li class="{{ $hr || $attendance|| $events ?'mm-active' : '' }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="true">
            <div class="nav_icon_small">
                <span class="fas fa-users"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('common.Human Resource') }}</span>
            </div>
        </a>
        <ul>
            @if (permissionCheck('staffs.index'))
                <li>
                    <a href="{{ route('staffs.index') }}" class="{{request()->is('hr/staffs') || request()->is('hr/staffs/*') ? 'active' : ''}}">{{ __('common.Staff') }}</a>
                </li>
            @endif
            @if (permissionCheck('permission.roles.index'))
                <li>
                    <a href="{{ route('permission.roles.index') }}" class="{{request()->is('hr/role-permission/*') ? 'active' : '/*'}}">{{ __('role.Role') }}</a>
                </li>
            @endif
            @if (permissionCheck('departments.index'))
                <li>
                    <a href="{{ route('departments.index') }}" class="{{request()->is('hr/departments') ? 'active' : ''}}">{{ __('department.Department') }}</a>
                </li>
            @endif
            @if (permissionCheck('attendances.index'))
                <li>
                    <a href="{{ route('attendances.index') }}" class="{{request()->is('attendance/hr/attendance') ? 'active' : ''}}">{{ __('attendance.Attendance') }}</a>
                </li>
            @endif
            @if (permissionCheck('attendance_report.index'))
                <li>
                    <a href="{{ route('attendance_report.index') }}" class="{{ request()->is('attendance/hr/attendance/*') ? 'active' : ''}}">{{ __('attendance.Attendance Report') }}</a>
                </li>
            @endif
            @if (permissionCheck('events.index'))
                <li>
                    <a href="{{ route('events.index') }}" class="{{request()->is('events') || request()->is('events/*') ? 'active' : ''}}">{{ __('event.Event') }}</a>
                </li>
            @endif
           
            @if (permissionCheck('payroll.index'))
                <li>
                    <a href="{{ route('payroll.index') }}" class="{{request()->is('hr/payroll') || request()->is('hr/payroll/*') ? 'active' : ''}}">{{ __('payroll.Payroll') }}</a>
                </li>
            @endif
            @if (permissionCheck('payroll_reports.index'))
                <li>
                    <a href="{{ route('payroll_reports.index') }}">{{ __('payroll.Payroll Reports') }}</a>
                </li>
            @endif
            @if (permissionCheck('apply_loans.index'))
                <li>
                    <a href="{{ route('apply_loans.index') }}" class="{{request()->is('hr/apply-loans') ? 'active' : ''}}">{{ __('common.Loan Apply') }}</a>
                </li>
            @endif
            @if (permissionCheck('apply_loans.history'))
                <li>
                    <a href="{{ route('apply_loans.history') }}" class="{{request()->is('hr/apply-loans/history') ? 'active' : ''}}">{{ __('setup.Loan History') }}</a>
                </li>
            @endif
            @if (permissionCheck('apply_loans.loan_approval_index'))
                <li>
                    <a href="{{ route('apply_loans.loan_approval_index') }}" class="{{request()->is('hr/loan-approval') ? 'active' : ''}}">{{ __('common.Loan Approval') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
