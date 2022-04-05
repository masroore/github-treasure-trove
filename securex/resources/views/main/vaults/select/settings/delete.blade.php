@extends('layouts.main')

@section('title')
{{ __('vault.delete_vault') }} - {{ $vault->name }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('vaults.select', $vault) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('vault.settings') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults.select', $vault) }}">{{ $vault->name }}</a></div>
            <div class="breadcrumb-item">{{ __('vault.delete_vault') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{!! Lang::get('vault.delete_vault_head', ['vault' => $vault->name] ) !!}</h2>
        <p class="section-lead">
            {{ __('vault.delete_vault_sub') }}
        </p>

        <div id="output-status"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item"><a href="{{ route('vaults.select.settings', $vault) }}" class="nav-link">{{ __('vault.general_settings') }}</a></li>
                            <li class="nav-item"><a href="{{ route('vaults.select.settings.password', $vault) }}" class="nav-link">{{ __('vault.password_settings') }}</a></li>
                            <li class="nav-item"><a href="{{ route('vaults.select.settings.delete', $vault) }}" class="nav-link active">{{ __('vault.delete_vault') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {!! laraflash()->render() !!}
                @include('partials.errors')
                <div class="card" id="settings-card">
                    <div class="card-header bg-secondary">
                        <h4>{{ __('vault.delete_vault_btn') }}</h4>
                    </div>
                    @if($vault->password)
                    <form method="POST" action="{{ route('vaults.select.settings.delete.vault', $vault) }}">
                        @csrf
                        @method('delete')
                        <div class="card-body">
                            <p class="text-muted">{{ __('vault.password_protected') }}</p>
                            <div class="form-group row align-items-center">
                                <label for="password" class="form-control-label col-sm-3 text-md-right">{{ __('vault.current_pass') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="password" data-toggle="password" name="password" class="form-control" id="password" placeholder="{{ __('vault.current_pass') }}" required>
                                </div>
                            </div>
                            @if(Auth::user()->is_2fa_enabled)
                            <div class="form-group row align-items-center">
                                <label for="otp" class="form-control-label col-sm-3 text-md-right">OTP</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="otp" class="form-control" id="otp" placeholder="{{ __('snippets.otp_placeholder') }}" required>
                                </div>
                            </div>
                            @endif
                            <div class="form-group row align-items-right">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right"></label>
                                <div class="col-sm-6 col-md-9">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="confirm" class="custom-control-input" id="confirm" required="">
                                        <label class="custom-control-label" for="confirm">{!! Lang::get('vault.delete_vault_confirm') !!}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-center">
                            <button class="btn btn-danger" type="submit" id="save-btn">{{ __('vault.delete_vault_btn') }}</button>
                        </div>
                    </form>
                    @else
                    <form method="POST" action="{{ route('vaults.select.settings.delete.vault', $vault) }}">
                        @csrf
                        @method('delete')
                        <div class="card-body">
                            @if(Auth::user()->is_2fa_enabled)
                            <div class="form-group row align-items-center">
                                <label for="otp" class="form-control-label col-sm-3 text-md-right">OTP</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="otp" class="form-control" id="otp" placeholder="Enter your Two-Factor Authentication (2FA) OTP from the Google Authenticator App." required>
                                </div>
                            </div>
                            @endif
                            <div class="form-group row align-items-right">
                                <label for="site-title" class="form-control-label col-sm-2 text-md-right"></label>
                                <div class="col-sm-6 col-md-9">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="confirm" class="custom-control-input" id="confirm" required="">
                                        <label class="custom-control-label" for="confirm">I confirm <b>deletion</b> of this Vault. I understand all the related sites and data will also be deleted permanantly.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-center">
                            <button class="btn btn-danger" type="submit" id="save-btn">Delete This Vault</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/bootstrap-show-password.min.js') }}"></script>
<script>
    function resetForm() {
        document.getElementById("password-settings").reset();
    }
</script>
<script src="{{ asset('assets/js/modules/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#otp').mask('000000');
    });
</script>
@endsection
