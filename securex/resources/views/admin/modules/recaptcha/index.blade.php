@extends('layouts.admin')

@section('title')
{{ __('admin.modules.recaptcha.title') }} | {{ __('nav.admin.modules') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.modules.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('admin.modules.recaptcha.title') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.modules.index') }}">{{ __('nav.admin.modules') }}</a></div>
            <div class="breadcrumb-item">{{ __('admin.modules.recaptcha.title') }}</div>
        </div>
    </div>
    <!-- Alerts -->
    {!! laraflash()->render() !!}
    <!-- Errors -->
    @include('partials.errors')
    <div class="section-body">
        <div class="row mt-sm-4">
            <div class="col-xl-8">
                <div class="card" id="recaptcha-card">
                    <div class="card-header bg-white">
                            <h4>{{ __('admin.modules.recaptcha.title') }}</h4>
                    </div>
                    <form id="recaptcha-settings" method="POST" action="{{ route('admin.modules.recaptcha.update') }}">
                        @csrf
                        <div class="card-body bg-secondary">
                            <p class="text-muted">{{ __('admin.modules.recaptcha.sub') }}</p>
                            <div class="form-group row align-items-center">
                                <label for="recaptcha_site_key" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.recaptcha.site_key') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="recaptcha_site_key" class="form-control" id="recaptcha_site_key" value="{{ Setting::get('recaptcha_site_key') }}">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="recaptcha_secret_key" class="form-control-label col-sm-3 text-md-right">{{ __('admin.modules.recaptcha.secret_key') }}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="recaptcha_secret_key" class="form-control" id="recaptcha_secret_key" value="{{ Setting::get('recaptcha_secret_key') }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-md-center">
                            <button class="btn btn-primary" id="save-btn-3">{{ __('admin.settings.update_setting') }}</button>
                            <a class="btn btn-warning" href="{{ URL::previous() }}">{{ __('snippets.go_back') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
