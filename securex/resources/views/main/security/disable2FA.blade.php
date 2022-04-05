@extends('layouts.auth')

@section('title')
{{ __('security.disable_2step') }}
@endsection

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-brand">
                    <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h4><a href="{{ URL::previous() }}"><i class="fas fa-arrow-left"></i></a> {{ __('security.lost_access') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ url('/pages/tfa') }}" target="_blank"><b>@lang('snippets.whats_this')</b></a>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('partials.errors')
                        <div class="text-center">
                            <h6>{!! Lang::get('security.disable_2step_sub') !!}</h6>
                            <hr>
                        </div>
                        @livewire('security.disable-two-step-without-phone')
                    </div>
                </div>
                <div class="mt-5 text-muted text-center">
                    {!! Lang::get('auth.2fa.not_user', ['user' => Auth::user()->first_name, 'logout' => '/logout']) !!}
                </div>
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>
</section>
@endsection