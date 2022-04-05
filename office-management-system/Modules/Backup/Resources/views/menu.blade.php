@if(permissionCheck('backup.index'))
   @php

        $backup = false;

        if(request()->is('backup'))
        {
            $backup = true;
        }

    @endphp

<li class="{{ $backup ?'mm-active' : '' }}">
    <a href="{{ route('backup.index') }}" class="{{ $backup ?'active' : '' }}" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-file-download"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('common.Backup') }}</span>
        </div>
    </a>
</li>
@endif
