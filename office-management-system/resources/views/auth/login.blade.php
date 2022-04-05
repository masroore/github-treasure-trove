@php
    $bg_image = 'public/backEnd/img/login-bg.png';
   if (app()->bound('general_setting')){
       $setting = app('general_setting');
       $bg_image = $setting->login_bg;
   }
@endphp
@extends('auth.layouts.guest', ['title' => __('common.Login')])

@push('css')


@endpush
@section('content')


        <h3 class="sho_mb ">{{ __('common.Login to your account') }}</h3>

        @if(env('APP_SYNC'))

            @php
                $super_admin =  DB::table('users')->select('email')->where('role_id',1)->first();
                $admin =  DB::table('users')->select('email')->where('role_id',2)->first();
                $staff =  DB::table('users')->select('email')->where('role_id',3)->first();
                $supplier =  DB::table('users')->select('email')->where('role_id',4)->first();
                $customer =  DB::table('users')->select('email')->where('role_id',5)->first();
            @endphp

            <div class="media-link">

                @if($super_admin)
                    <form action="{{ route('login') }}" id="content_form1" class="customer-input" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $super_admin->email }}">
                        <input type="hidden" name="password" value="12345678">
                        <button type="submit" name="submit" class=" submit super_admin_btn">Super Admin</button>
                        <button type="button" class="super_admin_btn submitting" style="display:none" disabled>{{ __('common.Logging in') }}...</button>
                    </form>

                @endif

                @if($admin)
                    <form action="{{ route('login') }}" id="content_form2" class="customer-input" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $admin->email }}">
                        <input type="hidden" name="password" value="12345678">
                        <button type="submit" name="submit" class="super_admin_btn submit">Admin</button>
                        <button type="button" class="super_admin_btn submitting" style="display:none" disabled>{{ __('common.Logging in') }}...</button>
                    </form>
                @endif

                @if($staff)
                    <form action="{{ route('login') }}" id="content_form3" class="customer-input" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $staff->email }}">
                        <input type="hidden" name="password" value="12345678">
                        <button type="submit" name="submit" class="super_admin_btn submit">Staff</button>
                        <button type="button" class="super_admin_btn submitting" style="display:none" disabled>{{ __('common.Logging in') }}...</button>
                    </form>
                @endif

                @if($supplier)
                    <form action="{{ route('login') }}" id="content_form4" class="customer-input" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $supplier->email }}">
                        <input type="hidden" name="password" value="12345678">
                        <button type="submit" name="submit" class="super_admin_btn submit">Supplier</button>
                        <button type="button" class="super_admin_btn submitting" style="display:none" disabled>{{ __('common.Logging in') }}...</button>
                    </form>
                @endif

                @if($customer)
                    <form action="{{ route('login') }}" id="content_form5" class="customer-input" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $customer->email }}">
                        <input type="hidden" name="password" value="12345678">
                        <button type="submit" name="submit" class="super_admin_btn submit">Customer</button>
                        <button type="button" class="super_admin_btn submitting" style="display:none" disabled>{{ __('common.Logging in') }}...</button>
                    </form>
                @endif
            </div>

        @endif


        <form  method="POST" action="{{ route('login') }}" id="content_form6" class="customer-input" >

            @csrf

            <input required name="email" id="email" type="text" placeholder="{{ __('common.Enter Email address') }}" autofocus class="" autocomplete="current-password">

            <input required name="password" id="password" type="password" placeholder="{{ __('common.Password') }}" class="" value="">


            <div class="forgot-pass">
                <div class="check-remamber-field">
                    <div class="round">
                        <input type="checkbox" id="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                        <label for="checkbox"></label>
                    </div>
                    <label class="remember-me"  for="checkbox">
                        {{ __('common.Remember Me') }}
                    </label>
                </div>
                <span>

					@if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
							{{ __('common.Forget Password') }}
						</a>
                    @endif
				</span>
            </div>

            <button type="submit" class="login-res-btn submit">Login</button>
            <button type="button" class="login-res-btn submitting" style="display:none" disabled>{{ __('common.Logging in') }}...</button>
        </form>

        @if(app('business_settings')->where('type', 'system_registration')->first()->status and app('general_setting')->first()->contact_login)
            <div class="text-left">
                <span class=""> {{ __('common.dont_have_account') }}</span>
                <a href="{{ route('register') }}">{{ __('common.Register') }}</a>
            </div>
        @endif




@endsection

@push('js')

    <script>
        $(document).ready(function () {
            _formValidation('content_form1');
            _formValidation('content_form2');
            _formValidation('content_form3');
            _formValidation('content_form4');
            _formValidation('content_form5');
            _formValidation('content_form6');
        });
    </script>

    @endpush
