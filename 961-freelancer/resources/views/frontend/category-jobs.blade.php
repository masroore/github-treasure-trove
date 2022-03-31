@extends('frontend.layouts.app')
@section('style')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/jquery-ui.css') }}">
@endsection
@section('content')
<!--Inner Home Banner Start-->
<div class="wt-haslayout wt-innerbannerholder">
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
				<div class="wt-innerbannercontent">
				<div class="wt-title"><h2>Jobs Listing</h2></div>
				<ol class="wt-breadcrumb">
					<li><a href="{{route('home')}}">Home</a></li>
					<li class="wt-active">Job</li>
				</ol>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Inner Home End-->
<!--Main Start-->
<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
	<div class="wt-haslayout wt-main-section">
		<!-- User Listing Start-->
		<div class="wt-haslayout">
			<div class="container">
				<div id="wt-twocolumns" class="row wt-twocolumns wt-haslayout">
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">
						<aside id="wt-sidebar" class="wt-sidebar">
							<div class="wt-widget wt-effectiveholder">
								<div class="wt-widgettitle">
									<h2>Categories</h2>
								</div>
								<div class="wt-widgetcontent">
									<form class="wt-formtheme wt-formsearch">
										<!-- <fieldset>
											<div class="form-group">
												<input type="text" name="Search" class="form-control" placeholder="Search Category">
												<a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
											</div>
										</fieldset> -->
										<fieldset>
											<div class="wt-checkboxholder wt-verticalscrollbar">
												@foreach($categories as $category)
												<span class="wt-radio">
													<input id="wordpress{{$category->id}}" type="radio" name="jobCategory" value="{{$category->category_name}}" onchange="category(this)">
													<label for="wordpress{{$category->id}}"> {{$category->category_name}}</label>
												</span>
												@endforeach
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="wt-widget wt-effectiveholder">
								<div class="wt-widgettitle">
									<h2>Project Type</h2>
								</div>
								<div class="wt-widgetcontent">
									<form class="wt-formtheme wt-formsearch">
										<fieldset>
											<div class="wt-checkboxholder">
												<span class="wt-radio">
													<input id="project" type="radio" name="job_type" value="all_type" checked>
													<label for="project"> Any Project Type</label>
												</span>
												<span class="wt-radio">
													<input id="hourly" type="radio" name="job_type" value="hourly">
													<label for="hourly"> Hourly Based Project</label>
												</span>
												<!-- <div id="wt-productrangeslider" class="wt-productrangeslider wt-themerangeslider"></div>
												<div class="wt-amountbox">
													<input type="text" id="wt-consultationfeeamount" readonly>
												</div> -->
												<span class="wt-radio">
													<input id="fixed" type="radio" name="job_type" value="fixed">
													<label for="fixed"> Fixed Price Project</label>
												</span>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="wt-widget wt-effectiveholder">
								<div class="wt-widgettitle">
									<h2>Location</h2>
								</div>
								<div class="wt-widgetcontent">
									<form class="wt-formtheme wt-formsearch">
										<!-- <fieldset>
											<div class="form-group">
												<input type="text" name="fullname" class="form-control" placeholder="Search Location">
												<a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
											</div>
										</fieldset> -->
										<fieldset>
											<div class="wt-checkboxholder wt-verticalscrollbar">
												@foreach($countries as $country)
												<span class="wt-radio">
													<input id="wt-description{{$country->id}}" type="radio" name="job_location" value="{{$country->name}}">
													<label for="wt-description{{$country->id}}">  {{$country->name}}</label>
												</span>
												@endforeach
												<!-- <span class="wt-radio">
													<input id="us" type="radio" name="job_location" value="company">
													<label for="us"> <img src="{{asset('assets/images/flag/img-02.png')}}" alt="img description"> United States</label>
												</span>
												<span class="wt-radio">
													<input id="canada" type="radio" name="job_location" value="company">
													<label for="canada"> <img src="{{asset('assets/images/flag/img-03.png')}}" alt="img description"> Canada</label>
												</span>
												<span class="wt-radio">
													<input id="england" type="radio" name="job_location" value="company">
													<label for="england"> <img src="{{asset('assets/images/flag/img-04.png')}}" alt="img description"> England</label>
												</span>
												<span class="wt-radio">
													<input id="emirates" type="radio" name="job_location" value="company">
													<label for="emirates"> <img src="{{asset('assets/images/flag/img-05.png')}}" alt="img description"> United Emirates</label>
												</span>
												<span class="wt-radio">
													<input id="wt-description1" type="radio" name="job_location" value="company">
													<label for="wt-description1"> <img src="{{asset('assets/images/flag/img-01.png')}}" alt="img description"> Australia</label>
												</span>
												<span class="wt-radio">
													<input id="us1" type="radio" name="job_location" value="company">
													<label for="us1"> <img src="{{asset('assets/images/flag/img-02.png')}}" alt="img description"> United States</label>
												</span> -->
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="wt-widget wt-effectiveholder">
								<div class="wt-widgettitle">
									<h2>Project Length</h2>
								</div>
								<div class="wt-widgetcontent">
									<form class="wt-formtheme wt-formsearch">
										<fieldset>
											<div class="wt-checkboxholder">
												<span class="wt-radio">
													<input id="anyproject" type="radio" name="job_duration" value="project" checked>
													<label for="anyproject">Any Project Length</label>
												</span>
												<span class="wt-radio">
													<input id="01month" type="radio" name="job_duration" value="Less than 1 month">
													<label for="01month"> Less Than 01 Month</label>
												</span>
												<span class="wt-radio">
													<input id="3months" type="radio" name="job_duration" value="1 to 3 months">
													<label for="3months"> 01 to 03 Months</label>
												</span>
												<span class="wt-radio">
													<input id="6months" type="radio" name="job_duration" value="3 to 6 months">
													<label for="6months"> 03 to 06 Months</label>
												</span>
												<span class="wt-radio">
													<input id="moremonths" type="radio" name="job_duration" value="More than 6 months">
													<label for="moremonths"> More Than 06 Months</label>
												</span>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="wt-widget wt-effectiveholder">
								<div class="wt-widgetcontent">
									<div class="wt-applyfilters">
										<span>Click Clear Filter” to clear latest<br> changes made by you.</span>
										<a href="javascript:void(0);" id="clearFilter" class="wt-btn">Clear Filters</a>
									</div>
								</div>
							</div>
						</aside>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
						
						<div class="notify-box d-flex justify-content-between align-items-center">
							<div class="switch-container">
								<span>{{count($jobs)}} jobs result <em></em></span>
							</div>

							<div class="sort-by align-items-center">
								<span>Sort by:</span>
								<div class="btn-group bootstrap-select hide-tick dropup">
									<!-- <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="button" title="Random" aria-expanded="false">
										<span class="filter-option pull-left">Random</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span>
									</button> -->
									<div class="dropdown-menu open" role="combobox" style="max-height: 216px; overflow: hidden; min-height: 121px;">
										<ul class="dropdown-menu inner" role="listbox" aria-expanded="false" style="max-height: 196px; overflow-y: auto; min-height: 101px;">
											<li data-original-index="1">
												<a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">
													<span class="text">Newest</span>
													<span class="glyphicon glyphicon-ok check-mark"></span>
												</a>
											</li>
											<li data-original-index="2">
												<a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">
													<span class="text">Oldest</span>
													<span class="glyphicon glyphicon-ok check-mark"></span>
												</a>
											</li>
											<li data-original-index="3" class="selected">
												<a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="true">
													<span class="text">Random</span>
													<span class="glyphicon glyphicon-ok check-mark"></span>
												</a>
											</li>
										</ul>
									</div>
									<select class="selectpicker hide-tick" id="sortBy" tabindex="-98">
										<option value="newest">Newest</option>
										<option value="oldest">Oldest</option>
										<option value="random">Random</option>
									</select>
								</div>
							</div>
						</div>
						<div class="listings-container mt-5" id="listings-container">
							
							@foreach($jobs as $job)
							<!-- Job Listing -->
							<a href="{{ route('job.show',$job->job_id)}}" class="job-listing">

								<!-- Job Listing Details -->
								<div class="job-listing-details">
									<!-- Logo -->
									<!-- <div class="job-listing-company-logo">
										<img src="images/company-logo-01.png" alt="">
									</div> -->

									<!-- Details -->
									<div class="job-listing-description">
										<!-- <h4 class="job-listing-company">Hexagon 
											<span class="verified-badge" data-tippy-placement="top" data-tippy="" data-original-title="Verified Employer"></span>
										</h4> -->
										<h3 class="job-listing-title">{{$job->job_title}}</h3>
										<p class="job-listing-text">{{ \Illuminate\Support\Str::limit($job->job_description, 200, $end='...') }}</p>
									</div>

									<!-- Bookmark -->
									@if(Auth::user())
										@if($job->saveJobs != '')
											@foreach($job->saveJobs as $save)
												@if($save->user_id == Auth::user()->id && $save->status == 1)
													<span class="bookmark-icon" style="color: red;" onclick="saveJob({{$job->id}})"></span>
												@endif
												@if($save->user_id == Auth::user()->id && $save->status == 0)
													<span class="bookmark-icon" onclick="saveJob({{$job->id}})"></span>
												@endif
											@endforeach
										@endif
										@if($job->saveJobs == '')
											<span class="bookmark-icon" onclick="saveJob({{$job->id}})"></span>
										@endif
									@endif
								</div>

								<!-- Job Listing Footer -->
								<div class="job-listing-footer">
									<ul>
										<li><i class="fal fa-map-marker-alt"></i> {{$job->job_location}}</li>
										<li class="text-capitalize"><i class="fal fa-briefcase"></i> {{$job->job_type}}</li>
										@if($job->job_type == 'fixed')
										<li><i class="fal fa-wallet"></i> ${{$job->fixed_price}} Fixed-price</li>
										@else
										<li><i class="fal fa-wallet"></i>${{$job->hourly_min_price}}-${{$job->hourly_max_price}} Hourly</li>
										@endif
										<li><i class="fal fa-clock"></i> {{$job->job_duration}}</li>
										<li><i class="fal fa-ribbon"></i> {{$job->service_level}}</li>
										<li><i class="fal fa-ribbon"></i> {{$job->job_cat}}</li>
									</ul>
								</div>
							</a>		
							@endforeach
							
							<!-- Pagination -->
							<div class="clearfix"></div>
							{{ $jobs->links('frontend.pagination.jobs')}}
							<!-- Pagination / End -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- User Listing End-->
	</div>
</main>
<!--Main End-->
@endsection
@section('script')
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script>
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	function saveJob(id){
   	$.ajax({
	    url:"{{ url('save-job') }}",
	    method:"POST",
	    data:{
	    	"_token": CSRF_TOKEN,
        "job_id": id,
        "save_type": 'Freelancer',
      },
	    success:function(data){
	    	console.log(data);
	    	if (data == 1) {
	    		$('.save'+id).html('<i class="fa fa-heart"></i> Saved');
	    	}
	    	if(data == 2){
	    		$('.save'+id).html('<i class="fal fa-heart"></i> Save');
	    	}
	    	// $("#add-project-form")[0].reset();
	    	// $('#pills-home-tab').removeClass('active');
	    	// $('#pills-profile-tab').addClass('active');
	    	// $('#pills-home').removeClass('show active');
	    	// $('#pills-profile').addClass('show active');
    	}
   	})
	}


	$('#sortBy').on('change', function(e){
      e.preventDefault();
      // alert( this.value );
      var sort_by = this.value;
      // console.log(sort_by);
      // console.log(sort_by);
      if (sort_by != undefined || sort_by !='') {
          $.ajax({
            url: "{{url('sort-jobs')}}",
            type: 'get',
            data: {sort_by:sort_by},
            cache : false,
            success:function(data){
              // console.log(data);
              $("#listings-container").html(data);
            }
          });
      }

    })
	function category(event){
		if($(event).is(":checked")){
		
			var category = event.value;
		}
		
		if (category != undefined || category !='') {
        $.ajax({
          url: "{{url('sort-jobs')}}",
          type: 'get',
          data: {category:category},
          cache : false,
          success:function(data){
            // console.log(data);
            $("#listings-container").html(data);
          }
        });
    }
	}

	$('input[name="job_type"]').on('change', function(e){
		e.preventDefault();
		
		var job_type = this.value;
		$.ajax({
		  url: "{{url('sort-jobs')}}",
		  type: 'get',
		  data: {job_type:job_type},
		  cache : false,
		  success:function(data){
		    // console.log(data);
		    $("#listings-container").html(data);
		  }
		});

	})

	$('input[name="job_duration"]').on('change', function(e){
	e.preventDefault();
		if($(this).is(":checked")){
			var duration = this.value;
		}
		if (duration != undefined || duration !='') {
        $.ajax({
          url: "{{url('sort-jobs')}}",
          type: 'get',
          data: {duration:duration},
          cache : false,
          success:function(data){
            // console.log(data);
            $("#listings-container").html(data);
          }
        });
    }
	})

	$('input[name="job_location"]').on('change', function(e){
		e.preventDefault();
		
		var job_location = this.value;
		$.ajax({
		  url: "{{url('sort-jobs')}}",
		  type: 'get',
		  data: {job_location:job_location},
		  cache : false,
		  success:function(data){
		    // console.log(data);
		    $("#listings-container").html(data);
		  }
		});

	})

	$('#clearFilter').on('click', function(e){
		e.preventDefault();
		var clear = 'all';
		$.ajax({
		  url: "{{url('sort-jobs')}}",
		  type: 'get',
		  data: {clear:clear},
		  cache : false,
		  success:function(data){
		    // console.log(data);
		    $("#listings-container").html(data);
		  }
		});

	})
</script>
@endsection