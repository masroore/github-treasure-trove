<form wire:submit.prevent="authenticateCode">
    @csrf
    <div class="form-group row">
        <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('auth.2fa.otp') }}</label>

        <div class="col-md-6">
            <input type="text" wire:model.lazy="otp" class="form-control {{ $errors->has('otp') ? ' is-invalid' : '' }}">
            @error('otp') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('auth.2fa.btn') }}
            </button>

            <a class="btn btn-link" href="{{ route('security.2fa.disable') }}">
                {{ __('auth.2fa.no_access') }}
            </a>
        </div>
    </div>
</form>