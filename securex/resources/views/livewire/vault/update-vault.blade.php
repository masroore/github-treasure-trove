<form id="general-settings" wire:submit.prevent="update">
    @csrf
    <div class="card" id="settings-card">
        <div class="card-header bg-secondary">
            <h4>{{ __('vault.general_settings') }}</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">{{ __('vault.general_settings_info') }}</p>
            <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{ __('vaults.vault_name') }}</label>
                <div class="col-sm-6 col-md-9">
                    <input type="text" wire:model.lazy="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('vaults.vault_name_placeholder') }}">
                </div>
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group row align-items-center">
                <label for="site-description" class="form-control-label col-sm-3 text-md-right">{{ __('vaults.vault_description') }}</label>
                <div class="col-sm-6 col-md-9">
                    <input wire:model.lazy="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('vaults.vault_description_placeholder') }}"/>
                </div>
                @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group row align-items-center">
                <label class="form-control-label col-sm-3 text-md-right">{{ __('vaults.vault_icon') }}</label>
                <div class="col-sm-6 col-md-9">
                    <div class="selectgroup selectgroup-pills">
                        @include('main.vaults.partials.icons')
                    </div>
                </div>
                @error('icon') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group row align-items-center">
                <label class="form-control-label col-sm-3 text-md-right">{{ __('vaults.vault_color') }}</label>
                <div class="col-sm-6 col-md-9">
                    <div class="custom-file">
                        <input type="color" wire:model.lazy="color" class="form-control {{ $errors->has('color') ? ' is-invalid' : '' }}">
                    </div>
                </div>
                @error('color') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-center">
            <button class="btn btn-primary" id="save-btn">{{ __('vault.general_settings_update_btn') }}</button>
            <button class="btn btn-secondary" type="button" onclick="resetForm()">{{ __('snippets.reset_form_btn') }}</button>
        </div>
    </div>
</form>