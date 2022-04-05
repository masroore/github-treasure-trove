<form wire:submit.prevent="addUser">
    @csrf
    <div class="card card-primary mb-0">
        <div class="card-header">
            <h4>{{ __('admin.users.add') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-6">
                    <label for="frist_name">{{ __('profile.firstname') }} <small class="text-danger">*</small></label>
                    <input type="text" wire:model.lazy="first_name" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                    @error('first_name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-6">
                    <label for="last_name">{{ __('profile.lastname') }}</label>
                    <input type="text" wire:model.lazy="last_name" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                    @error('last_name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">{{ __('profile.email') }} <small class="text-danger">*</small></label>
                <input type="email" wire:model.lazy="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                <small id="sitesHelpBlock" class="form-text text-muted">
                    {{ __('admin.users.password_alert') }}
                </small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
        <button type="submit" class="btn btn-primary btn-shadow"><i class="fas fa-plus"></i> {{ __('admin.users.add') }}</button>
    </div>
</form>