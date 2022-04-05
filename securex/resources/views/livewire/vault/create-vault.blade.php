<form wire:submit.prevent="createVault">
    @csrf
    <div class="card card-primary mb-0">
        <div class="card-header">
            <h4 class="text-primary">{{ __('vaults.create_new_vault') }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('vaults.vault_name') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" wire:model.lazy="name" placeholder="{{ __('vaults.vault_name_placeholder') }}">
                </div>
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vaults.vault_description') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" wire:model.lazy="description" placeholder="{{ __('vaults.vault_description_placeholder') }}">
                </div>
                @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vaults.vault_icon_select') }} <small class="text-danger">*</small></label>
                <div class="selectgroup selectgroup-pills">
                    @include('main.vaults.partials.icons')
                </div>
                @error('icon') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vaults.vault_preferred_color') }} <small class="text-danger">*</small></label>
                <input type="color" wire:model.lazy="color" class="form-control {{ $errors->has('color') ? ' is-invalid' : '' }}">
                @error('color') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vaults.vault_password') }} <small>({{ __('vaults.vault_password_sm') }})</small></label>
                <div class="input-group">
                    <input type="password" data-toggle="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" wire:model.lazy="password" placeholder="{{ __('vaults.vault_password_placeholder') }}">
                </div>
                @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
        <button type="submit" class="btn btn-primary btn-shadow"><i class="fas fa-plus"></i> {{ __('vaults.create_vault') }}</button>
    </div>
</form>