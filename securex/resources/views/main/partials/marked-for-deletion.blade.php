@if(Auth::user()->delete_on)
<div class="row">
    <div class="col-12">
        <div class="custom-error">
            <div class="cerror danger pull-up">
                <a href="{{ route('profile.index') }}">
                    <strong>{{ __('dashboard.profile_deletion_alert', [ 'delete_on' => \Carbon\Carbon::parse(Auth::user()->delete_on)->format('d-M-Y | H:i:s') ])}}</strong>
                </a>
            </div>
        </div>
    </div>
</div>
@endif