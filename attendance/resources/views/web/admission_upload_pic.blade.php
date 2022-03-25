@extends('web.layouts.web_layout')


@section('title', 'Oguses IT Solutions | Purchase OSN Code')

@section('addcss')
		<link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
@endsection

@section('content')
	<!-- banner -->
	<div class="banner-agile-2">
		@include('web.layouts.admsion_nav')
	</div>
	<!-- breadcrumb -->
	@include('web.layouts.breadcrumb')
	<!-- breadcrumb -->
	<!-- //banner -->

	<!-- admission form -->
	<div class="form-w3l py-5">
		<div class="container py-xl-5 py-lg-3">
			<h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">Admission
				<span class="font-weight-bold">form</span>
			</h3>
			
			<div class="register-form pt-md-4">
				<div class="row">
					<div class="col-md-4">
						<legend>Profile Image</legend>
							@if(!empty($profile->profileimg)){
								<img src="{{asset('storage')}}/{{$profile->profileimg}}" height="200" width="200" id="imgs" class="img-thumbnail">
							@else
								<img src="{{ URL::to('images/co.png')}}" height="200" width="200" id="imgs" class="img-thumbnail">
							@endif	
							<hr>
							<label> Make sure all required fields are filled, before submitting the application. </label>
							<hr>
						<form action="{{ route('sub-application-now', ['id'=> $profile->id ]) }}" method="POST">@csrf
							<input type="submit" name="" value="Submit Application Now" class="btn btn-success">
						</form>	
							



							<!-- livewire here -->
							<!-- @livewire('counter') -->





					</div>
					<div class="col-md-6">
						<form action="{{ route('profile-img-submit')}}" method="post" id="uploadimg" enctype="multipart/form-data">
							@csrf
							<legend>Upload Image</legend>
								<div class="styled-input form-group">
									<input type="file" class="form-control" placeholder="Index Number" name="fileToUpload" id="InputFile" required="">
								</div>
								@if($profile->profileimg)
										<input type="submit" value="Update Image" id="hideimg">
								@else
								<input type="submit" value="Upload Image" id="hideimg">
							@endif
						</form>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- admission form -->

	
@endsection