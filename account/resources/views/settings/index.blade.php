@extends('layouts.admin')
@section('page-title')
    {{__('Settings')}}
@endsection
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $lang=\App\Utility::getValByName('default_language');
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="nav-tabs">
                <div class="col-lg-12 our-system">
                    <div class="row">
                        <ul class="nav nav-tabs my-4">
                            <li>
                                <a data-toggle="tab" href="#site-settings" class="active">{{__('Site Setting')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#email-settings" class="">{{__('Email Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#payment-settings" class="">{{__('Payment Setting')}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="site-settings" class="tab-pane in active">
                        {{Form::model($settings,array('url'=>'systems','method'=>'POST','enctype' => "multipart/form-data"))}}
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Site settings')}}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Logo')}}</h4>
                                    <div class="card setting-card setting-logo-box">
                                        <div class="logo-content">
                                            <img src="{{$logo.'/logo.png'}}" class="big-logo" alt=""/>
                                        </div>
                                        <div class="choose-file mt-4">
                                            <label for="logo">
                                                <div>{{__('Choose file here')}}</div>
                                                <input type="file" class="form-control" name="logo" id="logo" data-filename="edit-logo">
                                            </label>
                                            <p class="edit-logo"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Landing Page Logo')}}</h4>
                                    <div class="card setting-card setting-logo-box">
                                        <div class="col-12">
                                            <div class="logo-content">
                                                <img src="{{$logo.'/landing_logo.png'}}" class="landing-logo" alt=""/>
                                            </div>
                                            <div class="choose-file mt-4">
                                                <label for="landing-logo">
                                                    <div>{{__('Choose file here')}}</div>
                                                    <input type="file" class="form-control" name="landing_logo" id="landing-logo" data-filename="edit-landing-logo">
                                                </label>
                                                <p class="edit-landing-logo"></p>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="display_landing_page" id="display_landing_page" {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="display_landing_page">{{__('Landing Page Display')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Favicon')}}</h4>
                                    <div class="card setting-card setting-logo-box">
                                        <div class="logo-content">
                                            <img src="{{$logo.'/favicon.png'}}" class="small-logo" alt=""/>
                                        </div>
                                        <div class="choose-file mt-5">
                                            <label for="small-favicon">
                                                <div>{{__('Choose file here')}}</div>
                                                <input type="file" class="form-control" name="favicon" id="small-favicon" data-filename="edit-favicon">
                                            </label>
                                            <p class="edit-favicon"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-md-6">
                                    <h4 class="small-title">{{__('Settings')}}</h4>
                                    <div class="card setting-card">
                                        <div class="form-group">
                                            {{Form::label('title_text',__('Title Text'),array('class'=>'form-control-label')) }}
                                            {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                            @error('title_text')
                                            <span class="invalid-title_text" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                             </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('footer_text',__('Footer Text'),array('class'=>'form-control-label')) }}
                                            {{Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                            @error('footer_text')
                                            <span class="invalid-footer_text" role="alert">
                                                                         <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('default_language',__('Default Language')) }}
                                            <div class="changeLanguage">
                                                <select name="default_language" id="default_language" class="form-control select2">
                                                    @foreach(\App\Utility::languages() as $language)
                                                        <option @if($lang == $language) selected @endif value="{{$language }}">{{Str::upper($language)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('SITE_RTL',__('RTL'),array('class'=>'form-control-label')) }}
                                            <div class="">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="SITE_RTL" id="SITE_RTL" {{ env('SITE_RTL') == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="custom-control-label form-control-label" for="SITE_RTL"></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                            <div class="col-lg-12 text-right">
                                <input type="submit" value="{{__('Save Changes')}}" class="btn-submit">
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    <div id="email-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Email settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                {{Form::open(array('route'=>'email.settings','method'=>'post'))}}
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_driver',__('Mail Driver'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                        @error('mail_driver')
                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_host',__('Mail Host'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Host')))}}
                                        @error('mail_host')
                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_port',__('Mail Port'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                        @error('mail_port')
                                        <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_username',__('Mail Username'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                        @error('mail_username')
                                        <span class="invalid-mail_username" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_password',__('Mail Password'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                        @error('mail_password')
                                        <span class="invalid-mail_password" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_encryption',__('Mail Encryption'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                        @error('mail_encryption')
                                        <span class="invalid-mail_encryption" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_from_address',__('Mail From Address'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                        @error('mail_from_address')
                                        <span class="invalid-mail_from_address" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_from_name',__('Mail From Name'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Name')))}}
                                        @error('mail_from_name')
                                        <span class="invalid-mail_from_name" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-12 ">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <a href="#" data-url="{{route('test.mail' )}}" data-ajax-popup="true" data-title="{{__('Send Test Mail')}}" class="btn btn-sm btn-info">
                                                {{__('Send Test Mail')}}
                                            </a>
                                        </div>
                                        <div class="form-group col-md-6 text-right">
                                            <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                        </div>
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div id="payment-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Payment settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                {{Form::open(array('route'=>'payment.settings','method'=>'post'))}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('currency_symbol',__('Currency Symbol *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('currency_symbol',env('CURRENCY_SYMBOL'),array('class'=>'form-control','required','placeholder'=>__('Enter Currency Symbol')))}}
                                            @error('currency_symbol')
                                            <span class="invalid-currency_symbol" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('currency',__('Currency *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('currency',env('CURRENCY'),array('class'=>'form-control font-style','required','placeholder'=>__('Enter Currency')))}}
                                            <small> {{__('Note: Add currency code as per three-letter ISO code.')}}<br> <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small> <br>
                                            @error('currency')
                                            <span class="invalid-currency" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-6 py-2">
                                        <h5 class="h5">{{__('Stripe')}}</h5>
                                    </div>
                                    <div class="col-6 py-2 text-right">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="enable_stripe" id="enable_stripe" {{ env('ENABLE_STRIPE') == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="enable_stripe">{{__('Enable Stripe')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('stripe_key',__('Stripe Key'),array('class'=>'form-control-label')) }}
                                            {{Form::text('stripe_key',env('STRIPE_KEY'),['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])}}
                                            @error('stripe_key')
                                            <span class="invalid-stripe_key" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                         </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('stripe_secret',__('Stripe Secret'),array('class'=>'form-control-label')) }}
                                            {{Form::text('stripe_secret',env('STRIPE_SECRET'),['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])}}
                                            @error('stripe_secret')
                                            <span class="invalid-stripe_secret" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                         </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-6 py-2">
                                        <h5 class="h5">{{__('PayPal')}}</h5>
                                    </div>
                                    <div class="col-6 py-2 text-right">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="enable_paypal" id="enable_paypal" {{ env('ENABLE_PAYPAL') == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="enable_paypal">{{__('Enable Paypal')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 pb-4">
                                        <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paypal Mode')}}</label> <br>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-primary btn-sm  {{ env('PAYPAL_MODE') == '' || env('PAYPAL_MODE') == 'sandbox' ? 'active' : '' }}">
                                                <input type="radio" name="paypal_mode" value="sandbox">{{__('Sandbox')}}
                                            </label>
                                            <label class="btn btn-primary btn-sm  {{ env('PAYPAL_MODE') == 'live' ? 'active' : '' }}">
                                                <input type="radio" name="paypal_mode" value="live">{{__('Live')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="paypal_client_id">{{ __('Client ID') }}</label>
                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{env('PAYPAL_CLIENT_ID')}}" placeholder="{{ __('Client ID') }}"/>
                                            @if ($errors->has('paypal_client_id'))
                                                <span class="invalid-feedback d-block">
                                            {{ $errors->first('paypal_client_id') }}
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="paypal_secret_key">{{ __('Secret Key') }}</label>
                                            <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="{{env('PAYPAL_SECRET_KEY')}}" placeholder="{{ __('Secret Key') }}"/>
                                            @if ($errors->has('paypal_secret_key'))
                                                <span class="invalid-feedback d-block">
                                            {{ $errors->first('paypal_secret_key') }}
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
