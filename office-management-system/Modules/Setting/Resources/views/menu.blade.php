@if(permissionCheck('setting.index'))
    @php

        $setting = false;

        if(request()->is('setting/*') or request()->is('setup/*') or request()->is('localization'))
        {
            $setting = true;
        }

    @endphp


    <li class="{{ $setting ?'mm-active' : '' }}">
        <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-store"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('setting.System Settings') }}</span>
            </div>
        </a>
        <ul>

            @if(permissionCheck('setting.index'))
                <li>
                    <a href="{{url('setting')}}"> {{ __('setting.Settings') }}</a>
                </li>
            @endif

            @if(permissionCheck('payment-method-settings'))
                <li>
                    <a href="{{route('payment-method-settings')}}"> {{__('setting.Payment Method Setting')}}</a>
                </li>
            @endif

            @includeIf('setup::menu', ['include_from' => 'setting'])

            @if(permissionCheck('setting.updatesystem'))
                <li>
                    <a href="{{ route('setting.updatesystem') }}"
                       class="{{ spn_active_link('setting.updatesystem', 'active') }}">{{ __('setting.Update') }}</a>
                </li>
            @endif


        </ul>
    </li>

@endif

@if(permissionCheck('style.index'))
    @php
        $style = false;

        if(request()->is('style/*'))
        {
            $style = true;
        }
    @endphp

    <li class="{{ $style ?'mm-active' : '' }}">
        <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-store"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('setting.Styles') }}</span>
            </div>
        </a>
        <ul>


            @if(permissionCheck('guest-background'))
                <li>
                    <a href="{{ route('guest-background') }}"
                       class="{{ spn_active_link('guest-background', 'active') }}">{{ __('setting.Background') }}</a>
                </li>
            @endif
            @if(permissionCheck('themes.index'))
                <li>
                    <a href="{{ route('themes.index') }}"
                       class="{{ spn_active_link('themes.index', 'active') }}">{{ __('setting.Theme Customization') }}</a>
                </li>

            @endif

            @if(permissionCheck('themes.change_view'))
                <li>
                    <a href="{{ route('themes.change_view') }}"
                       class="{{ spn_active_link('themes.change_view', 'active') }}">{{ __('common.Change View') }}</a>
                </li>

            @endif


        </ul>
    </li>

@endif
