@extends('layouts.admin')

@section('title')
{{ __('admin.settings.system') }}
@endsection

@section('css')
<style>
    .form-icon-right {
        left: auto;
        right: -1px;
    }

    .form-icon {
        position: absolute;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        top: 50%;
        transform: translateY(-50%);
        width: calc(1rem + 24px);
        height: calc(1rem + 24px);
    }

    .form-icon-right+.form-control {
        padding-left: 1rem;
        padding-right: calc(1rem + 24px);
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('admin.settings.system') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings.index') }}">{{ __('nav.admin.settings') }}</a></div>
            <div class="breadcrumb-item">{{ __('admin.settings.system') }}</div>
        </div>
    </div>

    <div class="section-body">

        <div id="output-status"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4>{{ __('admin.settings.jump_to') }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item"><a href="{{ route('admin.settings.system.index') }}" class="nav-link active">{{ __('admin.settings.system') }}</a></li>


                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Alerts -->
                {!! laraflash()->render() !!}

                <!-- Errors -->
                @include('partials.errors')

                <!-- Maintenance Settings Card -->
                @include('admin.settings.system.partials.maintenance-settings')

                <!-- App Settings Card -->
                @include('admin.settings.system.partials.app-settings')

                <!-- Access Settings Card -->
                @include('admin.settings.system.partials.access-settings')

            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/bootstrap-show-password.min.js') }}"></script>
<script>
    function resetForm() {
        document.getElementById("database-settings").reset();
    }
</script>
@endsection
