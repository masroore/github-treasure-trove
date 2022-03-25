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
				<form action="{{ route('save-personal-info') }}" method="post" id="personlinfo">
					<legend>Personal Information</legend>
					@csrf
					

					<div class="styled-input agile-styled-input-top form-group">
						<label>Title</label>
						<select class="category2" name="title" id="title" required>
							<option>@if(isset($info->title)){{$info->title ? : '' }}@endif</option>
							<option>Mr</option>
                            <option>Mrs</option>
                            <option>Miss</option>
                            <option>Ms</option>
						</select>
					</div>

					<div class="styled-input form-group">
						<label>Sir name</label>
						<input type="text" class="form-control" value="@if(isset($info->surname)){{$info->surname ? : '' }}@endif"  name="Sname" id="Sname" required="">
					</div>
					<div class="styled-input form-group">
						<label>Middle name</label>
						<input type="text" class="form-control" value="@if(isset($info->middlename)){{$info->middlename ? : '' }}@endif"  name="mname" id="mname">
					</div>
					<div class="styled-input form-group">
						<label>First name</label>
						<input type="text" class="form-control" value="@if(isset($info->firstnames)){{$info->firstnames ? : '' }}@endif"  name="fname" id="fname" required="">
					</div>


					<div class="styled-input agile-styled-input-top form-group">
						<label>Gender</label>
						<select class="category2" name="gender" id="disble" required>
							@if(isset($info->gender))
								@if($info->gender)
									<option value="{{$info->gender}}">{{$info->gender}}</option>
								@endif
							@endif
							<option value=""></option>
							<option value="Male">Male</option>
							<option value="FeMale">FeMale</option>
						</select>
					</div>

					
					<div class="styled-input form-group">
						<label>Date of Birth</label>
						<input id="datepicker" class="dateofb form-control" placeholder="Birth Of Date" value="@if(isset($info->dateofbirth)){{$info->dateofbirth ? : '' }}@endif" name="dateofb" type="date" required="">
					</div>

					<div class="styled-input form-group">
						<label>Religion</label>
						<input type="text" value="@if(isset($info->religion)){{$info->religion ? : '' }}@endif" class="form-control"  name="relig" id="relig" >
					</div>

					<div class="styled-input form-group">
						<label>Denomination</label>
						<input type="text" value="@if(isset($info->denomination)){{$info->denomination ? : '' }}@endif" class="form-control" name="denomina" id="denomina">
					</div>

					<div class="styled-input form-group">
						<label>Place of Birth</label>
						<input type="text" value="@if(isset($info->placeofbirth)){{$info->placeofbirth ? : '' }}@endif" class="form-control" name="plofbir" id="plofbir">
					</div>

					<div class="styled-input form-group">
						<label>Nationality</label>
						<input type="text" class="form-control" value="@if(isset($info->nationality)){{$info->nationality ? : '' }}@endif" name="national" id="national">
					</div>

					<div class="styled-input form-group">
						<label>Hometown</label>
						<input type="text" class="form-control" value="@if(isset($info->hometown)){{$info->hometown ? : '' }}@endif"  name="hometwn" id="hometwn">
					</div>

					<div class="styled-input form-group">
						<label>Region</label>
						<input type="text" class="form-control" value="@if(isset($info->region)){{$info->region ? : '' }}@endif" name="region" id="region">
					</div>

					<div class="styled-input agile-styled-input-top form-group">
						<label>Disability</label>
						<select class="category2" name="disble" id="disble" required>
							@if(isset($info->disability))
								@if($info->disability)
									<option value="{{$info->disability}}">{{$info->disability}}</option>
								@endif
							@endif
							<option value=""></option>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
							<option value="Others">Others</option>
						</select>
					</div>

					<div class="styled-input form-group">
						<label>Post Code</label>
						<input type="text" class="form-control" value="@if(isset($info->postcode)){{$info->postcode ? : '' }}@endif"  id="pcode" name="pcode" >
					</div>

					<div class="styled-input">
						<label class="header-admin-form font-weight-bold text-dark my-3">Residential Address</label>
						<div class="form-group">
							<input type="text" name="residnadd" value="@if(isset($info->address)){{$info->address}}@endif" id="residnadd" class="form-control"  title="Please enter Residential Address" required="">
						</div>
					</div>

					<div class="styled-input form-group">
						<label>Email</label>
						<input type="email" class="form-control" value="@if(isset($info->email)){{$info->email}}@endif" id="Email" name="Email" required="">
					</div>

					<div class="styled-input form-group">
						<label>Phone Number</label>
						<input type="text" class="form-control" value="@if(isset($info->phone)){{$info->phone}}@endif" name="Phone" id="Phone" required="">
					</div>

					<div class="styled-input agile-styled-input-top form-group">
						<label>Marital Status</label>
					<select class="category2" name="mstatus" id="mstatus" required>
						@if(isset($info->maritalstutus))
							@if($info->maritalstutus)
								<option value="{{$info->maritalstutus}}">{{$info->maritalstutus}}</option>
							@endif
						@endif
							<option value=""></option>
							<option value="Married">Married</option>
							<option value="Divorced">Divorced</option>
							<option value="Single">Single</option>
						</select>
					</div>
					<input type="submit" value="save and continue">
				</form>
			</div>
		</div>
	</div>
	<!-- admission form -->

	
@endsection