<form wire:submit.prevent="login">
    @csrf
    <div class="form-group">
        <label for="email">{{ __('profile.email') }}</label>
        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" wire:model.lazy="email" placeholder="{{ __('profile.email_placeholder') }}" required auto-complete="email">
        @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <div class="d-block">
            <label for="password" class="control-label">{{ __('auth.register.password') }}</label>
            <div class="float-right">
                <a href="{{ route('password.request') }}" class="text-small">
                    {{ __('auth.login.forgot') }}?
                </a>
            </div>
        </div>
        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" wire:model.lazy="password" placeholder="{{ __('auth.login.password_placeholder') }}" required auto-complete="password">
        @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" wire:model="remember" class="custom-control-input" id="remember-me">
            <label class="custom-control-label" for="remember-me">{{ __('auth.login.remember') }}</label>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            {{ __('auth.login.btn') }}
        </button>
    </div>
</form>