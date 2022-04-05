<form wire:submit.prevent="activate">
    <div class="card-body bg-secondary">
        <div class="form-group row align-items-center">
            <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.status') }}</label>
            <div class="col-sm-6 col-md-9">
                <button type="button" class="btn btn-success">
                    {{ __('admin.settings.live') }} <span class="badge badge-transparent"><i class="fas fa-globe"></i></span>
                </button>
            </div>
        </div>
        <hr>
        <p class="text-muted">{{ __('admin.settings.maintenance_activate') }}</p>
        <div class="form-group row align-items-center">
            <label for="message" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.maintenance_msg') }}</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" wire:model="message" placeholder="{{ __('admin.settings.maintenance_msg_placeholder') }}">
                <small id="vaultsMsgBlock" class="form-text text-muted">
                    {{ __('snippets.accepts_html') }}
                </small>
                @error('message') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="message" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.maintenance_secret') }}</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" class="form-control {{ $errors->has('secret') ? ' is-invalid' : '' }}" wire:model="secret" placeholder="{{ __('admin.settings.maintenance_secret_placeholder') }}">
                <small id="vaultsSecretBlock" class="form-text text-muted">
                    {{ __('admin.settings.maintenance_secret_warning') }}
                </small>
                @error('secret') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="secret_url" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.maintenance_url') }}</label>
            <div class="col-sm-6 col-md-6">
                <label for="secret_url" class="form-control-label">
                    {!! Lang::get('admin.settings.maintenance_url_placeholder') !!}
                    <br/><a href="{{ Setting::get('app_url') . '/' . $this->secret }}" target="_blank"><b><span id="secret_url-1">{{ Setting::get('app_url') . '/' . $secret }}</span></b></a>
                </label>
            </div>
            <div class="col-md-1">
                <button type="button" name="btn" id="btn" data-clipboard-target="#secret_url-1" class="btn btn-dark"><i class='fas fa-copy'></i> {{ __('snippets.copy') }}</button>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white text-md-center">
        <button class="btn btn-danger" id="save-btn-1">{{ __('admin.settings.maintenance_activate') }}</button>
    </div>
</form>