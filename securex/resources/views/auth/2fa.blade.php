@extends('layouts.auth')

@section('title')
{{ __('auth.2fa.title') }}
@endsection

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-brand">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
                    </a>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{!! Lang::get('auth.2fa.welcome', ['user' => Auth::user()->first_name]) !!}</h4>
                        <div class="card-header-action">
                            <a href="{{ url('/pages/tfa') }}" target="_blank"><b>@lang('snippets.whats_this')</b></a>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('partials.errors')
                        <div class="text-center">
                            <h6>{!! Lang::get('auth.2fa.sub') !!}</h6>
                            <hr>
                        </div>
                        @livewire('auth.two-step')
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

@section('js')
<script>
    $('.disable').click(function() {
        $(this).prop('disabled', true);
        $(this).text("Authenticating...");
        $("#authenticate").submit();
    });
</script>
@endsection