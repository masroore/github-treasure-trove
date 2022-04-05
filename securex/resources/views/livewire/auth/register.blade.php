<form wire:submit.prevent="register">
    @csrf
    <div class="row">
        <div class="form-group col-6">
            <label for="frist_name">{{ __('profile.firstname') }}</label>
            <input id="first_name" type="text" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" wire:model.lazy="first_name" name="first_name" placeholder="{{ __('profile.firstname_placeholder') }}" value="{{ old('first_name') }}" autofocus>
            @error('first_name') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-6">
            <label for="last_name">{{ __('profile.lastname') }}</label>
            <input id="last_name" type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" wire:model.lazy="last_name" placeholder="{{ __('profile.lastname_placeholder') }}" name="last_name" value="{{ old('last_name') }}">
            @error('last_name') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="email">{{ __('profile.email') }}</label>
        <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" wire:model.lazy="email" placeholder="{{ __('profile.email_placeholder') }}" value="{{ old('email') }}">
        @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="row">
        <div class="form-group col-6">
            <label for="password" class="d-block">{{ __('auth.register.password') }}
                <a href="javascript:;" data-toggle="popover" title="{{ __('auth.register.password_head') }}" data-content="{{ __('auth.register.password_body') }}" data-trigger="focus"><i class="fas fa-question-circle"></i></a>
            </label>
            <input id="password" type="password" class="form-control pwstrength {{ $errors->has('password') ? ' is-invalid' : '' }}" data-indicator="pwindicator" wire:model.lazy="password" placeholder="{{ __('auth.register.password_placeholder') }}">
            @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
            <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
            </div>
        </div>
        <div class="form-group col-6">
            <label for="password_confirmation" class="d-block">{{ __('auth.register.password_confirm') }}</label>
            <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" wire:model.lazy="password_confirmation" placeholder="{{ __('auth.register.password_confirm') }}">
            @error('password_confirmation') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="hint">{{ __('auth.register.password_hint') }}
            <a href="javascript:;" data-toggle="popover" title="{{ __('auth.register.password_hint_head') }}" data-content="{{ __('auth.register.password_hint_body') }}" data-trigger="focus"><i class="fas fa-question-circle"></i></a>
        </label>
        <input id="hint" type="text" class="form-control {{ $errors->has('password_hint') ? ' is-invalid' : '' }}" wire:model.lazy="password_hint" value="{{ old('password_hint') }}">
        @error('password_hint') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" wire:model.lazy="agree" checked class="custom-control-input" id="agree">
            <label class="custom-control-label" for="agree">{!! Lang::get('auth.register.agree', ['terms' => '/pages/terms', 'privacy' => '/pages/privacy', 'app' => setting()->get('app_name')]) !!}</label>
        </div>
        @error('agree') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>
    @if(setting()->get('recaptcha_enabled') == "true")
    <div class="mb-4">
        <div wire:ignore>
        {!! htmlFormSnippet() !!}
        </div>
        @error('captcha') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>
    @endif
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block"
            wire:click="$set('captcha', grecaptcha.getResponse())"
        >
            {{ __('auth.register.btn') }}
        </button>
    </div>
</form>