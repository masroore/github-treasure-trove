@extends('layouts.main2')

@section('infos')
Student login
@endsection


@section('login_here')

     <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form  action="{{ route('login') }}" method="post">

    @csrf

      <div class="form-group has-feedback">
        <input type="text" class="form-control  @error('id-number') is-invalid @enderror" name="id-number" placeholder="Enter Student ID Number" value="{{ old('id-number') }}" required  autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @error('id-number')
                 <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                 </span>
             @enderror
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password"  name="password" required autocomplete="current-password">
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

    <!-- <a href="{{ route('register') }}" class="text-center">new membership</a> -->

  </div>
  <!-- /.login-box-body -->
@endsection
