@extends('layouts.main')

@section('title')
General Settings - {{ $vault->name }}
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
            <div class="breadcrumb-item">{{ __('vault.settings') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">
            <span>{!! Lang::get('vault.general_settings_head', ['vault' => $vault->name]) !!}</span>
        </h2>
        <p class="section-lead">
            {{ __('vault.general_settings_sub') }}
        </p>

        <div id="output-status"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item"><a href="{{ route('vaults.select.settings', $vault) }}" class="nav-link active">{{ __('vault.general_settings') }}</a></li>
                            <li class="nav-item"><a href="{{ route('vaults.select.settings.password', $vault) }}" class="nav-link">{{ __('vault.password_settings') }}</a></li>
                            <li class="nav-item"><a href="{{ route('vaults.select.settings.delete', $vault) }}" class="nav-link">{{ __('vault.delete_vault') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Alerts --> 
                {!! laraflash()->render() !!}

                <!-- Vault Update Card Livewired -->
                @livewire('vault.update-vault', ['vault' => $vault])
                
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    function resetForm() {
        document.getElementById("general-settings").reset();
    }
</script>
@endsection