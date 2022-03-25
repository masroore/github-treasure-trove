@extends('web.layouts.web_layout')


@section('title', 'Oguses IT Solutions | Purchase OSN Code')

@section('addcss')
		<link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
@endsection

@section('content')
	<!-- banner -->
	<div class="banner-agile-2">
		@include('web.layouts.navigation')
	</div>
	<!-- breadcrumb -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.html">Home</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Online Admission</li>
		</ol>
	</nav>
	<!-- breadcrumb -->
					
	<!-- admission form -->
	<div class="form-w3l py-5">
		<div class="container py-xl-5 py-lg-3">
			<h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">OSN
				<span class="font-weight-bold">Verify</span>
			</h3>
			@if(Session::has('message'))
				 		<div class="alert alert-danger">
					 		 	{{Session::get('message')}}
					 	</div>
					@endif 	
			<div class="register-form pt-md-4">
				<form action="{{route('admission-login')}}" method="post" id="verifyosd">
					@csrf
					<div class="styled-input form-group">
						<input type="text" class="form-control" placeholder="Enter OSN Code" name="osncode" required>
					</div>
					<input type="submit" value="Submit">
				</form>
			</div>
		</div>
	</div>
	<!-- admission form -->
	
@endsection