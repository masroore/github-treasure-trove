@extends('layouts.main')

@section('title')
{{ __('vault.password_settings') }} - {{ $vault->name }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('vaults.select', $vault) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('vault.settings') }}s</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults.select', $vault) }}">{{ $vault->name }}</a></div>
            <div class="breadcrumb-item">{{ __('vault.password_settings') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{!! Lang::get('vault.password_settings_head', ['vault' => $vault->name]) !!}</h2>
        <p class="section-lead">
            {{ __('vault.password_settings_sub') }}
        </p>

        <div id="output-status"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item"><a href="{{ route('vaults.select.settings', $vault) }}" class="nav-link">{{ __('vault.general_settings') }}</a></li>
                            <li class="nav-item"><a href="{{ route('vaults.select.settings.password', $vault) }}" class="nav-link active">{{ __('vault.password_settings') }}</a></li>
                            <li class="nav-item"><a href="{{ route('vaults.select.settings.delete', $vault) }}" class="nav-link">{{ __('vault.delete_vault') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {!! laraflash()->render() !!}
                @include('partials.errors')
                <div class="card" id="settings-card">
                    <div class="card-header bg-secondary">
                        <h4>{{ __('vault.password_settings') }}</h4>
                    </div>
                    @if($vault->password)
                    <form method="POST" action="{{ route('vaults.select.settings.password.delete', $vault) }}">
                        @csrf
                        @method('delete')
                        <div class="card-body">
                            <p class="text-muted">{{ __('vault.password_protected') }}</p>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{ __('vault.current_pass') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('vault.current_pass') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-center">
                            <button class="btn btn-danger" type="submit" id="save-btn">{{ __('vault.password_remove_btn') }}</button>
                        </div>
                    </form>
                    @else
                    <form method="POST" action="{{ route('vaults.select.settings.password.store', $vault) }}">
                        @csrf
                        <div class="card-body">
                            <p class="text-muted">{{ __('vault.password_settings_info') }}</p>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{ __('snippets.vault_pass') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="password" data-toggle="password" name="password" class="form-control" id="password" placeholder="{{ __('vaults.vault_password_placeholder') }}" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-description" class="form-control-label col-sm-3 text-md-right">{{ __('snippets.vault_pass_confirm') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="password" data-toggle="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="{{ __('snippets.vault_pass_confirm') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-center">
                            <button class="btn btn-primary" type="submit" id="save-btn">{{ __('vault.password_add_btn') }}</button>
                            <button class="btn btn-secondary" type="button" onclick="resetForm()">{{ __('snippets.reset_form_btn') }}</button>
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
@endsection