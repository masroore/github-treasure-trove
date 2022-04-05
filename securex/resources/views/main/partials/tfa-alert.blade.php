@if(setting()->get('tfa_enabled') && setting()->get('tfa_show_alert'))
    @if(! Auth::user()->two_factor_enabled)
    <div class="row">
        <div class="col-12 custom-error">
            <div class="cerror danger">
                <strong>Alert!</strong> <a class="text-decoration-none text-gray" href="{{ route('security.index') }}">{{ __('dashboard.2step_alert') }}</a>
            </div>
        </div>
    </div>
    @endif
@endif