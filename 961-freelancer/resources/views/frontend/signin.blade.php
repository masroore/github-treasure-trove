@extends('frontend.layouts.app')
@section('content')
<?php
   $next = Request::input('next') != '' ? '?next='.Request::input('next') : '';
   $package_id = Request::input('package_id') != '' ? Request::input('package_id') : '';
   // dd($next,$package_id);
   ?>
<section class="login-signup">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-md-6">
				<div class="login-signup-wrapper login-wrapper">
					<div class="login-signup-header border-bottom">
						<h3 class="text-center mb-0">Login to 961 Freelancer</h3>
						<!-- <p class="text-center">Don't have an account? <a href="{{ route('register')}}">Sign Up</a></p> -->
					</div>
					<div class="login-with-credentials">
						<form action="{{route('login'.$next)}}" method="POST">
							@if ($errors->any())
							 <div class="alert alert-danger">
							    <ul>
							       @foreach ($errors->all() as $error)
							       <li>{{ $error }}</li>
							       @endforeach
							    </ul>
							 </div>
							@endif
							@if(session()->has('loginAlert'))
                  <div class="alert alert-danger">
                      {{ session()->get('loginAlert') }}
                  </div>
              @endif
              @if(session()->has('verify_success'))
                  <div class="alert alert-success">
                      {{ session()->get('verify_success') }}
                  </div>
              @endif
							@csrf
							<div class="mb-3">
								<label class="control-label">Username</label>
								<input class="form-control" type="text" placeholder="Enter Username or Email" name="username" value="">
								<!--  -->
								<span class="text-danger">{{ $errors->first('username') }}</span>
							</div>
							<div class="mb-3">
								<label class="control-label">Password</label>
								<input class="form-control" type="password" name="password" value="" placeholder="Enter Password">
								<!--  -->
								<span class="text-danger">{{ $errors->first('password') }}</span>
							</div>
							<div class="mb-3 d-flex flex-row align-items-center justify-content-between">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="remember" id="customCheck1">
									<label class="custom-control-label" for="customCheck1">Remember me</label>
									<!--  -->
								</div>
								<a class="fogot-password" href="{{route('forgot-password')}}">Forgot password?</a>
							</div>
							<div class="mb-3">
								<button class="login-button text-white w-100" role="button" type="submit" name="login">Sign in</button>
							</div>
						</form>
						<div class="divider">
							<p><span>or</span></p>
						</div>
					</div>
					
					<div class="login-by-social d-flex flex-column align-items-center justify-content-center">
						<a class="social-button facebook d-flex flex-row align-items-center" href="{{url('login/facebook')}}">
							<span>
								<i class="fab fa-facebook-f"></i>
							</span>
							<span>Login with Facebook</span>
						</a>
						<!-- <a class="social-button linkedin d-flex flex-row align-items-center" href="javascript:void(0);">
							<span>
								<i class="fab fa-linkedin-in"></i>
							</span>
							<span>Login with Linkedin</span>
						</a> -->
						<a class="social-button google d-flex flex-row align-items-center" href="{{url('login/google')}}">
							<span>
								<i class="fab fa-google"></i>
							</span>
							<span>Login with Google</span>
						</a>
					</div>
					<div class="login-signup-header">
						<p class="text-center">Don't have an account? <a href="{{ route('register')}}">Sign Up</a></p>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>
@endsection