@extends('layouts.auth')

@section('title')
{{ $page->title }}
@endsection

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-10 offset-md-2 col-lg-10 offset-lg-2 col-xl-10 offset-xl-2">
                <div class="login-brand">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
                    </a>
                </div>
                @if($page->status == 'Draft')
                <div class="custom-error">
                    <div class="cerror warning">
                        <strong>@lang('alerts.warning')</strong> {{ __('alerts.admin.pages.visibility') }}
                    </div>
                </div>
                @endif
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="col-8">
                            <h4>{{ $page->title }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4>Last Updated: {{ \Carbon\Carbon::parse($page->last_updated)->format('d-M-Y') }}</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! $page->body !!}
                    </div>

                    @if(setting()->get('app_address') || setting()->get('app_phone'))
                    <div class="card-footer bg-whitesmoke">
                        <div class="row">
                            <div class="col-md-8">
                                @if(setting()->get('app_address'))
                                <small><b>Address : {{ setting()->get('app_address') }}</b></small>
                                @endif
                            </div>
                            <div class="col-md-4 text-right">
                                @if(setting()->get('app_phone'))
                                <small><b>Contact # {{ setting()->get('app_phone') }}</b></small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-5 text-muted text-center">
                    <a href="{{ URL::previous() }}"><b>{{ __('auth.confirm.return') }}</b></a>
                </div>
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>
</section>
@endsection