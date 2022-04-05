@if(Auth::user()->vaults()->count() === 0)
<div class="row">
    <div class="col-12">
        <div class="custom-error">
            <div class="cerror info">
                <div class="alert-icon">
                    <a href="{{ route('vaults') }}" class="text-decoration-none">
                        <i class="fas fa-piggy-bank text-info"></i>
                        <strong>{{ __('dashboard.create_vault_alert') }}</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif