@extends('frontend.layouts.app')
@section('dashboardstyle')

<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<link href="{{URL::asset('admin-assets/assets/css/select2.min.css')}}" rel="stylesheet" />
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
	.select2-container{
		height: 50px;
	}
	.select2-container .select2-selection--single{
		height: 50px;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered{
		line-height: 50px;
	}
	.select2-results__option{
		list-style: none;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow{
		display: none;
	}
	textarea:invalid {
	  border: 1px solid red;
	}
	textarea:invalid:focus {
	  border: 1px solid red;
	}
	textarea:valid:focus {
	  border: 1px solid green;
	}
</style>
@endsection
@section('content')
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<!--Main Start-->
		<main id="wt-main" class="wt-main wt-haslayout">
			<!--Sidebar Start-->
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			<!--Sidebar Start-->
			<!--Register Form Start-->
			<section class="wt-haslayout wt-dbsectionspace">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>Post a Job</h2>
							</div>
							<div class="wt-dashboardboxcontent">
								<div class="wt-jobdescription wt-tabsinfo">
									<div class="wt-tabscontenttitle">
										<h2>Job Description</h2>
									</div>
									<form class="wt-formtheme wt-userform wt-userformvtwo" method="post" action="{{ route('job.store') }}" enctype="multipart/form-data" id="job-post-form">
										@if ($errors->any())
			               <div class="alert alert-danger">
			                  <ul>
			                     @foreach ($errors->all() as $error)
			                     <li>{{ $error }}</li>
			                     @endforeach
			                  </ul>
			               </div>
			              @endif
										@csrf
										<fieldset>
											<div class="form-group">
												<input type="text" name="job_title" class="form-control" minlength="30" placeholder="Job Title" value="{{old('job_title')}}" title="Job title should be minimum 30 charaters">
											</div>
											
											<div class="form-group form-group-half wt-formwithlabel">
												<span class="wt-select">
													<label for="selectoption">Service Level:</label>
													<select name="service_level">
														<option value="Expert">Expert</option>
														<option value="Intermediate">Intermediate</option>
														<option value="Beginner">Beginner</option>
													</select>
												</span>
											</div>
											<div class="form-group form-group-half wt-formwithlabel">
												<span class="wt-select">
													<label for="selectoption">Job Type:</label>
													<select name="job_type" onchange="jobType(this)">
														<option value="fixed">Fixed</option>
														<option value="hourly">Hourly</option>
													</select>
												</span>
											</div>
											<div id="hourly_price" class="d-none">
												<div class="form-group  form-group-half">
													<!-- <label for="selectoption">Hourly Price:</label> -->
													<input type="text" name="hourly_min_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Hourly Min Price $10" value="{{old('hourly_min_price')}}">
												</div>
												<div class="form-group  form-group-half">
													<!-- <label for="selectoption">Hourly Price:</label> -->
													<input type="text" name="hourly_max_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Hourly Max Price $40" value="{{old('hourly_max_price')}}">
												</div>
											</div>
											
											<div class="form-group" id="fixed_price">
												<!-- <label for="selectoption">Fixed Price:</label> -->
												<input type="text" name="fixed_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Fixed Price $500" value="{{old('fixed_price')}}">
											</div>
											<div class="form-group form-group-half wt-formwithlabel">
												<span class="wt-select">
													<label for="selectoption">Project Length:</label>
													<select name="job_duration">
														<option value="Less than 1 month">Less than 1 month</option>
														<option value="1 to 3 months">1 to 3 months</option>
														<option value="3 to 6 months">3 to 6 months</option>
														<option value="More than 6 months">More than 6 months</option>
													</select>
												</span>
											</div>
											<!-- <div class="form-group form-group-half wt-formwithlabel">
												<span class="wt-select">
													<label for="selectoption">Featured Job:</label>
													<select id="selectoption" name="is_featured">
														<option value="">Yes</option>
														<option value="">No</option>
													</select>
												</span>
											</div> -->
										</fieldset>
									</form>
								</div>
								<div class="wt-jobdetails wt-tabsinfo">
									<div class="wt-tabscontenttitle">
										<h2>Job Categories</h2>
									</div>
									<div class="wt-formtheme wt-userform wt-userformvtwo">
										<fieldset style="overflow: initial;">
											<div class="form-group">
												<span class="wt-select">
													<!-- <label for="selectoption">Job Category:</label> -->
													<select name="job_cat" form="job-post-form" class="chosen-select Skills">
														@foreach($categories as $category)
														<option value="{{$category->category_name}}">{{$category->category_name}}</option>
														@endforeach
													</select>
												</span>
											</div>
										</fieldset>
									</div>
								</div>
								<div class="wt-jobdetails wt-tabsinfo">
									<div class="wt-tabscontenttitle">
										<h2>Job Location</h2>
									</div>
									<div class="wt-formtheme wt-userform wt-userformvtwo">
										<fieldset style="overflow: initial;">
											<div class="form-group">
												<span class="wt-select">
													<!-- <label for="selectoption">Job Category:</label> -->
													<select name="job_location" form="job-post-form" class="select2 Skills">
														<option value="None">None</option>
														@foreach($countries as $country)
														<option value="{{$country->name}}">{{$country->name}}</option>
														@endforeach
													</select>
												</span>
											</div>
										</fieldset>
									</div>
								</div>
								<div class="wt-jobdetails wt-tabsinfo">
									<div class="wt-tabscontenttitle">
										<h2>Job Details</h2>
									</div>
									<div class="wt-formtheme wt-userform wt-userformvtwo">
										<fieldset>
											<div class="form-group">
												<textarea name="job_description" form="job-post-form" cols="10" rows="5" class="form-control" minlength="50" placeholder="Add Job Detail Here" title="Description should be minimum 50 charaters">{{old('job_description')}}</textarea>
											</div>
										</fieldset>
									</div>
								</div>
								<div class="wt-jobskills wt-tabsinfo">
									<div class="wt-tabscontenttitle">
										<h2>Skills Required</h2>
									</div>
									<div class="wt-formtheme wt-userform wt-userformvtwo">
										<fieldset style="overflow: initial;">
											<div class="form-group w-100">
												<select class="chosen-select Skills" data-placeholder="Skills" name="job_skills[]" form="job-post-form" multiple>
													@foreach($skills as $skill)
													<option value="{{$skill->skill_name}}">{{$skill->skill_name}}</option>
													@endforeach
												</select>
											</div>
										</fieldset>
									</div>
								</div>
								<div class="wt-attachmentsholder">
									<div class="wt-tabscontenttitle">
										<h2>Attachments</h2>
									</div>
									<div class="wt-formtheme wt-formprojectinfo wt-formcategory">
										<fieldset>
											<div class="form-group form-group-label">
												<div class="wt-labelgroup">
													<label for="file">
														<span class="wt-btn">Select Files</span>
														<input type="file" name="job_attachement[]" form="job-post-form" id="file" onchange="JobImages(this)" multiple>
													</label>
													<span>Attach Files</span>
													<em class="wt-fileuploading">Uploading<i class="fa fa-spinner fa-spin"></i></em>
												</div>
											</div>
											<div class="form-group">
												<ul class="wt-attachfile">
													
												</ul>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
						<div class="wt-updatall">
							<i class="fal fa-megaphone"></i>
							<span>Post job by just clicking on “Post Job Now” button.</span>
							<button class="wt-btn" type="submit" form="job-post-form">Post Job Now</button>
						</div>
					</div>
				</div>
			</section>
			<!--Register Form End-->
		</main>
		<!--Main End-->	
	</div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('admin-assets/assets/js/select2.min.js')}}"></script>
<script>
	$('.select2').select2();
	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
			jQuery(selector).chosen(config[selector]);
	}
	function jobType(select){
		if(select.value == 'hourly'){
			$('#hourly_price').removeClass('d-none');
			$('#fixed_price').addClass('d-none');
		}else{
			$('#fixed_price').removeClass('d-none');
			$('#hourly_price').addClass('d-none');
		}
	}

 	function JobImages(input) {
 		console.log(input);

 		var fi = input;

      // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
      if (fi.files.length > 0) {

          // THE TOTAL FILE COUNT.
          // document.getElementById('fp').innerHTML =
              // 'Total Files: <b>' + fi.files.length + '</b></br >';

          // RUN A LOOP TO CHECK EACH SELECTED FILE.
          for (var i = 0; i <= fi.files.length - 1; i++) {

              var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
              var _size = fi.files.item(i).size;      // THE SIZE OF THE FILE.
              var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                    		j=0;while(_size>900){_size/=1024;j++;}
                        var exactSize = (Math.round(_size*100)/100)+' '+fSExt[j];

              $('.wt-attachfile').append('<li class="wt-uploaded"><span class="uploadprogressbar"></span><span>'+fname+'</span><em>File size: '+exactSize+'</em></li>');
              // $('.fileSizea').html(fsize);
              // SHOW THE EXTRACTED DETAILS OF THE FILE.
          }
      }
      else { 
          alert('Please select a file.') 
      }


 		


    // if (input.files && input.files[0]) {
    //     var reader = new FileReader();
    //     console.log(reader);
    //     reader.onload = function (e) {
    //         $('.JobImg')
    //             .attr('src', e.target.result);
    //     };

    //     reader.readAsDataURL(input.files[0]);

    //     var _size = input.files[0].size;
    //       var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
    //   		i=0;while(_size>900){_size/=1024;i++;}
    //       var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
    //   	$('#projectImg_size'+id).html(exactSize)
    // }
    // var filename = $('#filen'+id).val().split('\\').pop();
    // $('#projectimg_name'+id).html(filename);
    
	}
</script>
@endsection