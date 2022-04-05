@extends('layouts.admin')

@section('title')
{{ __('nav.admin.modules') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('nav.admin.modules') }}</h1>
    </div>

    <!-- Alerts -->
    {!! laraflash()->render() !!}

    <div class="row">
        <!-- Two-Factor Authentication (2FA) Module -->
        @if(setting()->get('tfa_enabled') == 'true')
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-primary pull-up">
                <div class="card-header">
                    <h4 class="text-primary">Two-Factor Authentication (2FA)</h4>
                    <div class="card-header-action">
                        <!-- Toggle Livewired -->
                        @livewire('admin.modules.tfa.toggle', ['enabled' => true])
                    </div>
                </div>
                <div class="card-body">
                    <small>Increases security by adding a Two factor authentication step using TOTPs (Time-based One Time Passwords).</small>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <a href="{{ route('admin.modules.tfa.index') }}" class="btn btn-block btn-outline-primary">Configure</a>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-danger pull-up">
                <div class="card-header">
                    <h4 class="text-danger">Two-Factor Authentication (2FA)</h4>
                    <div class="card-header-action">
                        <!-- Toggle Livewired -->
                        @livewire('admin.modules.tfa.toggle', ['enabled' => false])
                    </div>
                </div>
                <div class="card-body">
                    <small>Increases security by adding a Two factor authentication step using TOTPs (Time-based One Time Passwords).</small>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <a href="{{ route('admin.modules.tfa.index') }}" class="btn btn-block btn-outline-danger">Configure</a>
                </div>
            </div>
        </div>
        @endif

</section>
@endsection
