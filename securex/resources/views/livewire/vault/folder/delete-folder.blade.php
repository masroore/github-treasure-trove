<form wire:submit.prevent="deleteFolder">
    @csrf
    <div class="card card-danger mb-0">
        <div class="card-header">
            <h4 class="text-danger">{!! Lang::get('vault.folder.delete_head', ['name' => $folder->name]) !!}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('vault.folder.confirm') }}<small class="text-danger">*</small></label>
                <div class="input-group">
                    <select class="form-control" wire:model.lazy="confirm">
                        <option value="" selected>{{ __('vault.folder.confirm_select') }}</option>
                        <option value="1">{{ __('vault.folder.confirm_select_yes') }}</option>
                    </select>
                </div>
                @error('confirm') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vault.folder.confirm_sites') }} <small class="text-danger">*</small></label>
                <select class="form-control" wire:model.lazy="delete_sites">
                    <option value="" selected>{{ __('vault.folder.confirm_sites_select') }}</option>
                    <option value="0">{{ __('vault.folder.confirm_sites_no') }}</option>
                    <option value="1">{{ __('vault.folder.confirm_sites_yes') }}</option>
                </select>
                @error('delete_sites') <span class="error text-danger">{{ $message }}</span> @enderror
                <small id="sitesHelpBlock" class="form-text text-muted">
                    {{ __('vault.folder.confirm_sites_help') }}
                </small>
            </div>
            <div class="form-group">
                <label>{{ __('security.master_pass') }} <small class="text-danger">*</small></label>
                <input type="password" wire:model.lazy="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('security.master_pass') }}">
                @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
        <button type="submit" class="btn btn-danger btn-shadow"><i class="fas fa-trash-alt"></i> {{ __('vault.folder.delete') }}</button>
    </div>
</form>