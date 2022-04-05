<form wire:submit.prevent="add">
    @csrf
    <div class="card card-primary mb-0">
        <div class="card-header">
            <h4 class="text-primary">{{ __('admin.dashboard.add_new_announcement') }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('admin.dashboard.message') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" wire:model.lazy="body" class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" placeholder="{{ __('admin.dashboard.message_placeholder') }}" name="body" id="body">
                </div>
                @error('body') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
        <button type="submit" class="btn btn-primary btn-shadow"><i class="fas fa-plus"></i> {{ __('admin.dashboard.add_new_announcement') }}</button>
    </div>
</form>