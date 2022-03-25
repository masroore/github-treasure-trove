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
			<ul class="list-inline">
			<div class="register-form pt-md-4">
				<form action="{{ route('admission-personal-school-save') }}" method="post" id="schoolattended">
					<legend>Schools Attended</legend>
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="styled-input form-group">
								<label>Name of Institution 1</label>
								<input type="text" class="form-control" value="@if(isset($school->name)){{$school->name ? : '' }}@endif" name="iname1" id="iname1" required="">
							</div>
						</div>
						<div class="col-md-3">
							<div class="styled-input form-group">
								<label>Start Date</label>
								<input id="datepicker" class="stdate1 form-control" placeholder="Start Date" name="stdate1" type="date" value="@if(isset($school->schstart)){{$school->schstart ? : '' }}@endif" required="">
							</div>
						</div>
						<div class="col-md-3">
							<div class="styled-input form-group">
								<label>End Date</label>
								<input id="datepicker1" class="eddate1 form-control" placeholder="End Date" name="eddate1" value="@if(isset($school->schend)){{$school->schend ? : '' }}@endif" type="date" value="" onfocus="this.value = '';"
								 onblur="if (this.value == '') {this.value = 'mm/dd/yyyy';}" required="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="styled-input form-group">
								<label>Name of Institution 2</label>
								<input type="text" class="form-control" name="iname2" value="@if(isset($school->name2)){{$school->name2 ? : '' }}@endif" id="iname2" required="">
							</div>
						</div>
						<div class="col-md-3">
							<div class="styled-input form-group">
								<label>Start Date</label>
								<input id="datepicker2" class="stdate2 form-control" placeholder="Start Date" name="stdate2" value="@if(isset($school->schstart2)){{$school->schstart2 ? : '' }}@endif" type="date"  required="">
							</div>
						</div>
						<div class="col-md-3">
							<div class="styled-input form-group">
								<label>End Date</label>
								<input id="datepicker3" class="eddate2 form-control" placeholder="End Date" name="eddate2" value="@if(isset($school->schend2)){{$school->schend2 ? : '' }}@endif" type="date" required="">
							</div>
						</div>
					</div>
					<input type="submit" value="save and continue">
				</form>
			</div>
		</div>
	</div>
	<!-- admission form -->


	
@endsection