@extends('auth.layouts.guest', ['title' => __('common.Login')])
@section('content')
<section class="login-area up_login mt-5">

    <div class="container">

        <input type="hidden" id="url" value="{{url('/')}}">
        <div class="row login-height justify-content-center align-items-center">
            <div class="col-lg-5 col-md-8">
                <div class="form-wrap text-center">
                    <div class="logo-container">
                        <a href="{{url('/')}}">
                            <img src="{{ app('general_setting')->logo }}" alt="" class="logoimage">
                        </a>
                    </div>
                    <h5 class="text-uppercase">{{ __('common.Login Details') }}</h5>

                    @if(session()->has('message-success'))
                        @if(session()->has('message-success'))
                            <p class="text-success">{{ session()->get('message-success') }}</p>
                        @endif
                    @endif
                    @if(session()->has('message-danger'))
                        @if(session()->has('message-danger'))
                            <p class="text-danger">{{ session()->get('message-danger') }}</p>
                        @endif
                    @endif
                    <form method="POST" class="" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group input-group mb-4 p-3">
                            <span class="input-group-addon">
                                <i class="ti-email"></i>
                            </span>
                            <input class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" type="text" autofocus name='login' id="email" placeholder="{{ __('common.Enter Email address') }}"/>
                            @if ($errors->has('username') || $errors->has('email'))
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group input-group mb-4 p-3">
                            <span class="input-group-addon">
                                <i class="ti-key"></i>
                            </span>
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"  name='password' id="password" placeholder="{{ __('common.Enter Password') }}"/>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between pl-30">
                            <div class="checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }} value="1">
                                <label for="rememberMe">{{ __('common.Remember Me') }}</label>
                            </div>
                            <div>
                                <a href="{{ route('password.request') }}">{{ __('common.Forget Password') }}?</a>
                            </div>
                        </div>

                        <div class="form-group mt-30">
                            <button type="submit" class="primary-btn fix-gr-bg">
                                <span class="ti-lock mr-2"></span>
                                {{ __('common.Login') }}
                            </button>
                        </div>
                        @if(app('business_settings')->where('type', 'system_registration')->first()->status and app('general_setting')->first()->contact_login)
                        <div class="text-center">
                       <span class="text-white"> {{ __('common.dont_have_account') }}</span>
                            <a href="{{ route('register') }}">{{ __('common.Register') }}</a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>


        </div>

         @if(env('APP_SYNC'))
        <div class="row justify-content-center align-items-center" >
                <div class="col-lg-5 col-md-8 text-center mt-30 btn-group" id="btn-group" style="display: block;">

                    <div class="loginButton">
                        @php
                            $user =  DB::table('users')->select('email')->where('role_id',1)->first();
                        @endphp

                        @if (!empty($user))
                        <div class="singleLoginButton">

                                <form method="POST" class="loginForm" action="{{ route('login') }}">
                                    @csrf()
                                    <?php

                                    $email = @$user->email;
                                    ?>
                                    <input type="hidden" name="login" value="{{@$email}}">
                                    <input type="hidden" name="password" value="12345678">
                                    <button type="submit" class="white get-login-access">Super Admin</button>
                                </form>

                        </div>
                        @endif

                        @php
                              $user =  DB::table('users')->select('email')->where('role_id',2)->first();
                        @endphp

                        @if (!empty($user))


                        <div class="singleLoginButton">

                                <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                    <?php
                                    echo csrf_field();

                                    $email = @$user->email; ?>
                                    <input type="hidden" name="login" value="{{@$email}}">
                                    <input type="hidden" name="password" value="12345678">

                                    <button type="submit" class="white get-login-access">Admin</button>
                                </form>
                        </div>
                        @endif
                        @php
                              $user =  DB::table('users')->select('email')->where('role_id',3)->first();
                        @endphp

                        @if (!empty($user))
                        <div class="singleLoginButton">

                                <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                    <?php
                                    echo csrf_field();
                                    $email = @$user->email; ?>

                                    <input type="hidden" name="login" value="{{@$email}}">
                                    <input type="hidden" name="password" value="12345678">

                                    <button type="submit" class="white get-login-access">Staff</button>
                                </form>
                        </div>
                        @endif
                        @php
                              $user =  DB::table('users')->select('email')->where('role_id',4)->first();
                        @endphp

                        @if (!empty($user))
                        <div class="singleLoginButton">

                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                <?php
                                echo csrf_field();
                                $email = @$user->email; ?>
                                <input type="hidden" name="login" value="{{@$email}}">

                                <input type="hidden" name="password" value="12345678">

                                <button type="submit" class="white get-login-access">Supplier</button>
                            </form>
                        </div>
                        @endif
                        @php
                              $user =  DB::table('users')->select('email')->where('role_id',5)->first();
                        @endphp

                        @if (!empty($user))
                        <div class="singleLoginButton">

                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                <?php
                                echo csrf_field();
                                $email = @$user->email; ?>
                                <input type="hidden" name="login" value="{{@$email}}">
                                <input type="hidden" name="password" value="12345678">

                                <button type="submit" class="white get-login-access">Customer</button>
                            </form>
                        </div>
                        @endif

                    </div>

                </div>
            </div>
        @endif


        <div class="row justify-content-center d-block d-md-block">
            <div class="col-lg-12 text-center">
                <p  style="margin-top: 25px !important;">{!! app('general_setting')->copyright_text !!}</p>
            </div>
        </div>
    </div>
</section>
@endsection
