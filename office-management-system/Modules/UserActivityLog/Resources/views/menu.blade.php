@if(permissionCheck('activity_log'))
   @php
        $useractivitylog = false;
        if(request()->is('useractivitylog/*') || request()->is('useractivitylog'))
        {
            $useractivitylog = true;
        }
    @endphp
    <li class="{{ $useractivitylog ?'mm-active' : '' }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-clock-o"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('common.All Activity Logs') }}</span>
            </div>
        </a>
        <ul>
            <li>
                <a href="{{route('activity_log')}}" class="{{request()->is('useractivitylog') ? 'active' : ''}}">{{ __('common.Activity Logs') }}</a>
            </li>
            <li>
                <a href="{{ route('activity_log.login') }}" class="{{request()->is('useractivitylog/*') ? 'active' : ''}}">{{ __('common.Login Activity') }}</a>
            </li>
        </ul>
    </li>
@endif
