@extends('layouts.main')

@section('title')
{{ __('nav.security_settings') }}
@endsection

@section('content')
@include('main.security.partials.confirm-reset')
<section class="section">
    <div class="section-header">
        <h1>{{ __('nav.security_settings') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('nav.security_settings') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ __('snippets.hi_user', ['user' => Auth::user()->first_name]) }}!</h2>
        <p class="section-lead">
            {{ __('security.sub') }}
        </p>
        <div class="row">
            <div class="col-md-12">
                @include('partials.errors')
                {!! laraflash()->render() !!}
            </div>
            @if(Auth::user()->security_questions)
            @if(!setting()->get('tfa_enabled'))
            <div class="col-xl-6 order-xl-1">
                <div class="card bg-secondary shadow pull-up">
                    <div class="card-header bg-white">
                        <div class="col-8">
                            <h4>{{ __('security.2step_ga') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-sm btn-warning" >{{ __('snippets.unavailable') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            @else
                @if(! Auth::user()->two_factor_enabled)
                <div class="col-xl-6">
                    <div class="card bg-secondary shadow pull-up">
                        <div class="card-header bg-white">
                            <div class="col-8">
                                <h4>{{ __('security.2step_ga') }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Two-Factor Authentication (2FA) Dsiabled">{{ __('snippets.disabled') }}</button>
                            </div>
                        </div>
                        <div class="card-body bg-secondary">
                            <div class="text-center">
                                <h6>{!! Lang::get('security.ga_info', ['url' => 'https://support.google.com/accounts/answer/1066447?hl=en' ]) !!}
                                    <br />{{ __('security.ga_info2') }}
                                </h6>
                                <div class="visible-print text-center">
                                    {!! QrCode::size(300)->backgroundColor(247, 250, 252)->generate($google2fa_url); !!}
                                </div>
                                @if(setting()->get('tfa_show_key'))
                                <p>[ App Key: <b>{{ decrypt(Auth::user()->two_factor_secret) }}</b> ]</p>
                                @endif
                                <form role="form" method="POST" id="activate" name="activate" action="{{ route('security.2fa.activate') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-control-label">{!! Lang::get('security.ga_info3') !!}</label>
                                        <div class="input-group input-group-alternative">
                                            <input type="text" class="form-control" id="otp" name="otp" placeholder="{{ __('security.ga_input') }}" required="">
                                            <button type="submit" class="btn btn-success btn-sm text-uppercase waves-effect waves-light">{{ __('security.ga_confirm') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" data-toggle="modal" data-target="#confirm-reset" class="btn btn-info">{{ __('security.ga_reset_btn') }}</button>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <p><span class="text-danger">*</span> {{ __('security.ga_reset_info') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-xl-6">
                    <div class="card bg-secondary shadow pull-up">
                        <div class="card-header bg-white">
                            <div class="col-8">
                                <h4>{{ __('security.2step_ga') }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('security.2step_enabled') }}">{{ __('snippets.enabled') }}</button>
                            </div>
                        </div>
                        <div class="card-body bg-secondary">
                            <div class="text-center">
                                <h6>{{ __('security.2step_disable') }} -</h6>
                                <form role="form" method="POST" id="deactivate" name="deactivate" action="{{ route('security.2fa.deactivate') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <div class="input-group">
                                                <select id="confirmation" name="confirmation" class="form-control" required>
                                                    <option value="" selected disabled>{{ __('security.2step_disable_confirm') }}</option>
                                                    <option value="true">{{ __('security.2step_disable_confirmed') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('profile.current_pass_placeholder') }}" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <input type="text" class="form-control" id="otp" name="otp" placeholder="{{ __('security.ga_input') }}" required="">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-danger text-uppercase waves-effect waves-light">{{ __('security.2step_disable_btn') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
            <div class="col-xl-6">
                <div class="card bg-secondary shadow pull-up">
                    <div class="card-header bg-white">
                        <div class="col-8">
                            <h4>{{ __('security.questions') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('security.questions_stored') }}">{{ __('snippets.locked') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-xl-6">
                <div class="card bg-secondary shadow pull-up">
                    <div class="card-header bg-white">
                        <div class="col-8">
                            <h4>{{ __('security.questions') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('security.questions_unlock_pop') }}">{{ __('snippets.unlocked') }}</button>
                        </div>
                    </div>
                    <div class="card-body bg-secondary">
                        @livewire('security.add-security-questions')
                    </div>
                    <div class="card-footer bg-white text-center">
                        <span class="text-danger"><b>{{ __('security.questions_alert') }}</b></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 order-xl-1">
                <div class="card bg-secondary shadow pull-up">
                    <div class="card-header bg-white">
                        <div class="col-8">
                            <h4>{{ __('security.2step_ga') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('security.2step_unlock_pop') }}">{{ __('snippets.unavailable') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
