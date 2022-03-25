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
				<form action="{{ route('admission-app-info-save') }}" method="post" id="addchoice">
					@csrf
					<legend>Application Information</legend>
						<div class="styled-input agile-styled-input-top form-group">
							<label>Entry Level</label>
							<select class="category2" name="entry" id="entry" required>
										@if(isset($appinfo->osncode_id))
											@if($appinfo->entrylevel)
												<option value="{{$appinfo->entrylevel}}">{{$appinfo->entrylevel}}</option>
											@endif
										@endif
								<option value=""></option>
								<option value="Level 100">Level 100</option>
								<option value="Level 200">Level 200</option>
								<option value="Level 300">Level 300</option>
								<option value="Level 300">Level 400</option>
							</select>
						</div>
						<div class="styled-input agile-styled-input-top form-group">
							<label>Session</label>
							<select class="category2" name="session" id="session" required>
								@if(isset($appinfo->osncode_id))
											@if($appinfo->session)
												<option value="{{$appinfo->session}}">{{$appinfo->session}}</option>
											@endif
										@endif
								<option value=""></option>
								<option value="Morning Session">Morning Session</option>
								<option value="Evening Session">Evening Session</option>
								<option value="Weekend Session">Weekend Session</option>
							</select>
						</div>
							<div class="styled-input agile-styled-input-top form-group">
								<label>1st Choice Programme</label>
								<select class="category2" name="fcchoice" id="fcchoice" required>
									
									@if(isset($appinfo->osncode_id))
											@if($appinfo->firstchoice)
												<option value="{{$appinfo->firstchoice}} - {{$appinfo->fcode}}">{{$appinfo->firstchoice}}</option>
											@endif
										@endif
									<option value=""></option>
										@foreach($prog as $row)
											<option value="{{$row->name}} - {{$row->code}}">{{$row->name}}</option>
										@endforeach
								</select>
							</div>


						<div class="styled-input agile-styled-input-top form-group">
							<label>2nd Choice Programme</label>
								<select class="category2" name="sndchoice" id="fcchoice" required>
									
									@if(isset($appinfo->osncode_id))
											@if($appinfo->secondchoice)
												<option value="{{$appinfo->secondchoice}} - {{$appinfo->scode}}">{{$appinfo->secondchoice}}</option>
											@endif
										@endif
									<option value=""></option>
										@foreach($prog as $row)
											<option value="{{$row->name}} - {{$row->code}}">{{$row->name}}</option>
										@endforeach
								</select>
							</div>	

						<div class="styled-input agile-styled-input-top form-group">
							<label>3rd Choice Programme</label>
							<select class="category2" name="thrdchoice" id="fcchoice" required>
									@if(isset($appinfo->osncode_id))
											@if($appinfo->thirdchoice)
												<option value="{{$appinfo->thirdchoice}} - {{$appinfo->tcode}}">{{$appinfo->thirdchoice}}</option>
											@endif
										@endif
										<option value=""></option>
										@foreach($prog as $row)
											<option value="{{$row->name}} - {{$row->code}}">{{$row->name}}</option>
										@endforeach
								</select>
							</div>		

						<div class="styled-input form-group">
							<input type="hidden" class="form-control" value="@if(isset($appinfo->osncode_id)){{$appinfo->indexnumber ? : '' }}@endif" name="index1" id="index1" >
						</div>
						<input type="submit" value="save and continue">
				</form>
			</div>
		</div>
	</div>
	<!-- admission form -->

	
@endsection