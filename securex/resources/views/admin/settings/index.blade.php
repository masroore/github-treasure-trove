@extends('layouts.admin')

@section('title')
{{ __('nav.admin.settings') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('nav.admin.settings') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('nav.admin.settings') }}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{ __('admin.settings.overview') }}</h2>
        <p class="section-lead">
            {{ __('admin.settings.overview_sub') }}
        </p>
        </div>
            <div class="col-lg-6">
                <div class="card card-large-icons">
                    <div class="card-icon bg-primary text-white">
                        <i class="fas fa-power-off"></i>
                    </div>
                    <div class="card-body">
                        <h4>{{ __('admin.settings.system') }}</h4>
                        <p>{{ __('admin.settings.system_sub') }}</p>
                        <a href="{{ route('admin.settings.system.index') }}" class="card-cta">{{ __('admin.settings.change_setting') }} <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>


</section>
@endsection
