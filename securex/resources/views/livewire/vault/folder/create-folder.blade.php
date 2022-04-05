<form wire:submit.prevent="createFolder">
    @csrf
    <div class="card card-info mb-0">
        <div class="card-header">
            <h4 class="text-info">{!! Lang::get('vault.create_folder_in', ['vault' => $vault->name]) !!}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('vault.folder_name') }} <small class="text-danger">*</small></label>
                <div class="input-group">
                    <input type="text" wire:model.lazy="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('vault.folder_name_placeholder') }}">
                </div>
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{ __('vault.folder_icon') }} <small class="text-danger">*</small></label>
                <div class="selectgroup selectgroup-pills">
                    @include('main.vaults.partials.icons')
                </div>
                @error('icon') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <div class="mr-auto"><span class="text-danger">*</span> {{ __('vaults.input_req') }}</div>
        <button type="submit" class="btn btn-info btn-shadow"><i class="fas fa-plus"></i> {{ __('vault.create_folder') }}</button>
    </div>
</form>