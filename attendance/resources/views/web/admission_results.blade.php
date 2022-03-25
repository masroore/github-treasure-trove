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
<div class="form-w3l py-5">
	<div class="container py-xl-5 py-lg-3">
		<h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">Results
			<span class="font-weight-bold">form</span>
		</h3>
		<div class="register-form pt-md-4">

			<div class="col-md-offset-3 col-md-8" style="margin-top: 20px;">
				<form action="{{route('save-result')}}" method="post">
					@csrf
					<div class="panel panel-info" style="width:100%;">
						<div class="panel-heading" style="background-color: rgb(249 246 249 / 30%);">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#collapse1">Results 1 Click to View</a></h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
							<div class="panel-body">
								<input type="hidden" name="result" value="result1" />
								<div class="styled-input agile-styled-input-top form-group">
									<select class="category2" name="extype" id="extyp1" >
										@if(isset($result1->examtype))
										@if($result1->examtype)
										<option value="{{$result1->examtype}}">{{$result1->examtype}}</option>
										@endif
										@endif
										<option value="">Examination Type</option>
										<option value="WASSCE">WASSCE</option>
										<option value="SSSCE">SSSCE</option>
										<option value="GBCE">GBCE</option>
										<option value="ABCE">ABCE</option>
									</select>
								</div>
								<div class="styled-input agile-styled-input-top form-group">
									<select class="category2" name="exyr" id="exyr1">
										@if(isset($result1->examtype))
										@if($result1->examyear)
										<option value="{{$result1->examyear}}">{{$result1->examyear}}</option>
										@endif
										@endif
										<option value="">Examination Year</option>
										<option value="MAY/JUNE">MAY/JUNE</option>
										<option value="NOVDEC">NOVDEC</option>
										<option value="Others">Others</option>
									</select>
								</div>
								<div class="styled-input form-group">
									<input type="text" class="form-control" placeholder="Index Number" value="@if(isset($result1->examtype)){{$result1->indexnumber ? : '' }}@endif"name="indexnember" id="index1">
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject1" id="exsub1" >
												@if(isset($result1->examtype))
												@if($result1->subject1)
												<option value="{{$result1->subject1}}">{{$result1->subject1}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade1" id="exgrade1">
												@if(isset($result1->examtype))
												@if($result1->grade1)
												<option value="{{$result1->grade1}}">{{$result1->grade1}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject2" id="exsub11" >
												@if(isset($result1->examtype))
												@if($result1->subject2)
												<option value="{{$result1->subject2}}">{{$result1->subject2}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade2" id="exgrade11">
												@if(isset($result1->examtype))
												@if($result1->grade2)
												<option value="{{$result1->grade2}}">{{$result1->grade2}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject3" id="exsub12" >
												@if(isset($result1->examtype))
												@if($result1->subject3)
												<option value="{{$result1->subject3}}">{{$result1->subject3}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade3" id="exgrade12">
												@if(isset($result1->examtype))
												@if($result1->grade3)
												<option value="{{$result1->grade3}}">{{$result1->grade3}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject4" id="exsub13" >
												@if(isset($result1->examtype))
												@if($result1->subject4)
												<option value="{{$result1->subject4}}">{{$result1->subject4}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade4" id="exgrade13">
												@if(isset($result1->examtype))
												@if($result1->grade4)
												<option value="{{$result1->grade4}}">{{$result1->grade4}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject5" id="exsub14" >
												@if(isset($result1->examtype))
												@if($result1->subject5)
												<option value="{{$result1->subject5}}">{{$result1->subject5}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade5" id="exgrade14">
												@if(isset($result1->examtype))
												@if($result1->grade5)
												<option value="{{$result1->grade5}}">{{$result1->grade5}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject6" id="exsub15" >
												@if(isset($result1->examtype))
												@if($result1->subject6)
												<option value="{{$result1->subject6}}">{{$result1->subject6}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade6" id="exgrade15">
												@if(isset($result1->examtype))
												@if($result1->grade6)
												<option value="{{$result1->grade6}}">{{$result1->grade6}}</option>
												@endif
												@endif

												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
									<input type="submit" class="btn btn-info" value="save information" id="saveresult1">
								</div>
							</div>
						</div>
						
					</div>
				</form>



				<!--- results2 save-result2 -->

				<form action="{{route('save-result2')}}" method="post">
					@csrf
					<div class="panel panel-info" style="width:100%;">
						<div class="panel-heading" style="background-color: rgb(249 246 249 / 30%);">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#collapse2">Results 2 Click to View</a></h4>
						</div>
						<div id="collapse2" class="panel-collapse collapse">
							<div class="panel-body">
								<input type="hidden" name="result" value="result2" />
								<div class="styled-input agile-styled-input-top form-group">
									<select class="category2" name="extype" id="extyp1" >
										@if(isset($result2->examtype))
										@if($result2->examtype)
										<option value="{{$result2->examtype}}">{{$result2->examtype}}</option>
										@endif
										@endif
										<option value="">Examination Type</option>
										<option value="WASSCE">WASSCE</option>
										<option value="SSSCE">SSSCE</option>
										<option value="GBCE">GBCE</option>
										<option value="ABCE">ABCE</option>
									</select>
								</div>
								<div class="styled-input agile-styled-input-top form-group">
									<select class="category2" name="exyr" id="exyr1">
										@if(isset($result2->examtype))
										@if($result2->examyear)
										<option value="{{$result2->examyear}}">{{$result2->examyear}}</option>
										@endif
										@endif
										<option value="">Examination Year</option>
										<option value="MAY/JUNE">MAY/JUNE</option>
										<option value="NOVDEC">NOVDEC</option>
										<option value="Others">Others</option>
									</select>
								</div>
								<div class="styled-input form-group">
									<input type="text" class="form-control" placeholder="Index Number" value="@if(isset($result2->examtype)){{$result2->indexnumber ? : '' }}@endif"name="indexnember" id="index1">
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject1" id="exsub1" >
												@if(isset($result2->examtype))
												@if($result2->subject1)
												<option value="{{$result2->subject1}}">{{$result2->subject1}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade1" id="exgrade1">
												@if(isset($result2->examtype))
												@if($result2->grade1)
												<option value="{{$result2->grade1}}">{{$result2->grade1}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject2" id="exsub11" >
												@if(isset($result2->examtype))
												@if($result2->subject2)
												<option value="{{$result2->subject2}}">{{$result2->subject2}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade2" id="exgrade11">
												@if(isset($result2->examtype))
												@if($result2->grade2)
												<option value="{{$result2->grade2}}">{{$result2->grade2}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject3" id="exsub12" >
												@if(isset($result2->examtype))
												@if($result2->subject3)
												<option value="{{$result2->subject3}}">{{$result2->subject3}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade3" id="exgrade12">
												@if(isset($result2->examtype))
												@if($result2->grade3)
												<option value="{{$result2->grade3}}">{{$result2->grade3}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject4" id="exsub13" >
												@if(isset($result2->examtype))
												@if($result2->subject4)
												<option value="{{$result2->subject4}}">{{$result2->subject4}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade4" id="exgrade13">
												@if(isset($result2->examtype))
												@if($result2->grade4)
												<option value="{{$result2->grade4}}">{{$result2->grade4}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject5" id="exsub14" >
												@if(isset($result2->examtype))
												@if($result2->subject5)
												<option value="{{$result2->subject5}}">{{$result2->subject5}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade5" id="exgrade14">
												@if(isset($result2->examtype))
												@if($result2->grade5)
												<option value="{{$result2->grade5}}">{{$result2->grade5}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject6" id="exsub15" >
												@if(isset($result2->examtype))
												@if($result2->subject6)
												<option value="{{$result2->subject6}}">{{$result2->subject6}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade6" id="exgrade15">
												@if(isset($result2->examtype))
												@if($result2->grade6)
												<option value="{{$result2->grade6}}">{{$result2->grade6}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
									<input type="submit" class="btn btn-info" value="save information" id="saveresult1">
								</div>
							</div>
						</div>
						
					</div>
				</form>




				<!--- results 3 save-result3 -->


				<form action="{{route('save-result3')}}" method="post">
					@csrf
					<div class="panel panel-info" style="width:100%;">
						<div class="panel-heading" style="background-color: rgb(249 246 249 / 30%);">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#collapse3">Results 3 Click to View</a></h4>
						</div>
						<div id="collapse3" class="panel-collapse collapse">
							<div class="panel-body">
								<input type="hidden" name="result" value="result3" />
								<div class="styled-input agile-styled-input-top form-group">
									<select class="category2" name="extype" id="extyp1" >
										@if(isset($result3->examtype))
										@if($result3->examtype)
										<option value="{{$result3->examtype}}">{{$result3->examtype}}</option>
										@endif
										@endif
										<option value="">Examination Type</option>
										<option value="WASSCE">WASSCE</option>
										<option value="SSSCE">SSSCE</option>
										<option value="GBCE">GBCE</option>
										<option value="ABCE">ABCE</option>
									</select>
								</div>
								<div class="styled-input agile-styled-input-top form-group">
									<select class="category2" name="exyr" id="exyr1">
										@if(isset($result3->examtype))	
										@if($result3->examyear)
										<option value="{{$result3->examyear}}">{{$result3->examyear}}</option>
										@endif
										@endif
										<option value="">Examination Year</option>
										<option value="MAY/JUNE">MAY/JUNE</option>
										<option value="NOVDEC">NOVDEC</option>
										<option value="Others">Others</option>
									</select>
								</div>
								<div class="styled-input form-group">
									<input type="text" class="form-control" placeholder="Index Number" value="@if(isset($result3->examtype)){{$result3->indexnumber ? : '' }}@endif"name="indexnember" id="index1">
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject1" id="exsub1" >
												@if(isset($result3->examtype))
												@if($result3->subject1)
												<option value="{{$result3->subject1}}">{{$result3->subject1}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade1" id="exgrade1">
												@if(isset($result3->examtype))
												@if($result3->grade1)
												<option value="{{$result3->grade1}}">{{$result3->grade1}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject2" id="exsub11" >
												@if(isset($result3->examtype))
												@if($result3->subject2)
												<option value="{{$result3->subject2}}">{{$result3->subject2}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade2" id="exgrade11">
												@if(isset($result3->examtype))
												@if($result3->grade2)
												<option value="{{$result3->grade2}}">{{$result3->grade2}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject3" id="exsub12" >
												@if(isset($result3->examtype))
												@if($result3->subject3)
												<option value="{{$result3->subject3}}">{{$result3->subject3}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade3" id="exgrade12">
												@if(isset($result3->examtype))
												@if($result3->grade3)
												<option value="{{$result3->grade3}}">{{$result3->grade3}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject4" id="exsub13" >
												@if(isset($result3->examtype))
												@if($result3->subject4)
												<option value="{{$result3->subject4}}">{{$result3->subject4}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade4" id="exgrade13">
												@if(isset($result3->examtype))
												@if($result3->grade4)
												<option value="{{$result3->grade4}}">{{$result3->grade4}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject5" id="exsub14" >
												@if(isset($result3->examtype))
												@if($result3->subject5)
												<option value="{{$result3->subject5}}">{{$result3->subject5}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade5" id="exgrade14">
												@if(isset($result3->examtype))
												@if($result3->grade5)
												<option value="{{$result3->grade5}}">{{$result3->grade5}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
								</div><div class="row">
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="subject6" id="exsub15" >
												@if(isset($result3->examtype))
												@if($result3->subject6)
												<option value="{{$result3->subject6}}">{{$result3->subject6}}</option>
												@endif
												@endif
												<option value="">Subject</option>
												<option value="Mathematics(Core)">Mathematics(Core)</option>
												<option value="Mathematics(Elec)">Mathematics(Elec)</option>
												<option value="English Language">English Language</option>
												<option value="English Language (Elect)">English Language (Elect)</option>
												<option value="Integrated Science">Integrated Science</option>
												<option value="Social Studies">Social Studies</option>
												<option value="Econimics">Econimics</option>
												<option value="Financial Accounting">Financial Accounting</option>
												<option value="Cost Accounting">Cost Accounting</option>
												<option value="Geography">Geography</option>
												<option value="Twi">Twi</option>
												<option value="French">French</option>
												<option value="Agriculture">Agriculture</option>
												<option value="Chemistry">Chemistry</option>
												<option value="Biology">Biology</option>
												<option value="Physics">Physics</option>
												<option value="Art">Art</option>
												<option value="Animal Crob and Husbandry"></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="styled-input agile-styled-input-top form-group">
											<select class="category2" name="grade6" id="exgrade15">
												@if(isset($result3->examtype))
												@if($result3->grade6)
												<option value="{{$result3->grade6}}">{{$result3->grade6}}</option>
												@endif
												@endif
												<option value="">Grade</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="B1">B1</option>
												<option value="B2">B2</option>
												<option value="B3">B3</option>
												<option value="C">C</option>
												<option value="C4">C4</option>
												<option value="C5">C5</option>
												<option value="C6">C6</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>
										</div>
									</div>
									<input type="submit" class="btn btn-info" value="save information" id="saveresult1">
								</div>
							</div>
						</div>
						
					</div>
				</form>



				<div class="col-md-offset-5 col-md-3" style="margin-bottom:20px;margin-top: 20px;">
					<a href="{{ route('admission-personal-school')}}" class="btn btn-success">Continue</a>
				</div>
				<div class="clearfix"></div>

			</div>

		</div>
	</div>
</div>





<!-- admission form -->	

@endsection