@extends('layouts.main2')

@section('infos')
Student | LMS | login
@endsection


@section('login_here')

  @include('notify_status.notify')

     <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form  action="{{ route('lms-login-check') }}" method="post">

    @csrf

      <div class="form-group has-feedback">
        <input type="text" class="form-control  @error('index') is-invalid @enderror" name="index" placeholder="Index Number" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @error('index')
                 <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                 </span>
             @enderror
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password"  name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    
    <!-- /.social-auth-links -->

    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
    <a href="{{ route('home') }}" class="text-center">HomePage</a>                            

    <!-- <a href="{{ route('register') }}" class="text-center">new membership</a> -->

  </div>
  <!-- /.login-box-body -->
@endsection