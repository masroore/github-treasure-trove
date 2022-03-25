@extends('layouts.main2')

@section('infos')
Reset Password
@endsection


@section('login_here')

     <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"> Reset Password
    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

    </p>

    <form  action="{{ route('password.email') }}" method="post">

    @csrf

      <div class="form-group has-feedback">
        <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @error('email')
                 <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                 </span>
             @enderror
      </div>

          <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
        <!-- /.col -->
        <div class="clearfix"></div>
      </div>
    </form>



  </div>
  <!-- /.login-box-body -->
@endsection