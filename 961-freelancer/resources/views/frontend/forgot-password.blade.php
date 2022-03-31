@extends('frontend.layouts.app')
@section('title', 'Forgot Password')
@section('styling')
@endsection
@section('content')
<div class="container">
  <!-- <div class="outer-box left-side">
    <div class="inner-box">
      <div class="img-container">
        <img src="{{asset('images/sign-up-bg.jpg')}}" alt="">
      </div>

      <div class="logo-and-text">
        <img src="{{asset('images/logo-white.svg')}}" alt="">
        <p>Find The Perfect Services
          with Engezly For Your Business</p>
      </div>
    </div>
  </div> -->
  <div class="row outer-box right-side d-flex justify-content-center my-5 py-4">
    <div class="inner-box col-md-4 shadow p-3 rounded login-with-credentials">
      @if(Session::has('resetAlert'))
      <div class="alert alert-danger">
        {{ Session::get('resetAlert') }}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      
      @if(Session::has('resetSuccess'))
      <div class="alert alert-success">
        {{ Session::get('resetSuccess') }}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="color: black;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      <form action="{{url('/password/email')}}" method="post" class="form">
        @csrf
        <h4>Reset Your Password</h4>
        <p class="reset-text">Please enter your email and you will receive a link to reset your password</p>

        <div class="form-group">
          <label for="">Email</label>
            <input type="text" class="form-control" name="email" placeholder="">
        </div>

        <div class="btn-container">
          <button type="submit" class="btn login-button w-100 text-white">Reset Password</button>
        </div>

        <p class="account-btn mt-3 text-center">Back to <a href="{{route('login')}}">Sing in</a></p>

      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
@endsection
