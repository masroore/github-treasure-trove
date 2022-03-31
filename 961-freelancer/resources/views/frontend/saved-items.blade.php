@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
</style>
@endsection
@section('content')
<!--Main Start-->
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<main id="wt-main" class="wt-main wt-haslayout">
			<!--Sidebar Start-->
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			<!--Sidebar Start-->
			<!--Register Form Start-->
			<section class="wt-haslayout wt-dbsectionspace">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
						<div class="wt-dashboardbox wt-dashboardtabsholder wt-saveitemholder">
							<div class="wt-dashboardtabs">
								<ul class="wt-tabstitle nav navbar-nav">
									@if(Auth::user()->account_type != 'Client')
									<li class="nav-item" role="presentation">
										<a class="@if(Auth::user()->account_type != 'Client') active @endif" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Saved Jobs</a>
									</li>
									@endif
									<li class="nav-item" role="presentation">
										<a class="@if(Auth::user()->account_type == 'Client') active @endif" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Liked Freelancers</a>
									</li>
								</ul>
							</div>
							<div class="wt-tabscontent tab-content tab-savecontent">
								<div class="wt-personalskillshold tab-pane fade @if(Auth::user()->account_type != 'Client') active show @endif" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
									<div class="wt-yourdetails">
										<div class="wt-tabscontenttitle">
											<h2>Saved Jobs</h2>
										</div>
										<div class="wt-dashboradsaveitem">
											@foreach($saveJobs as $key=>$saveJob)
											<div class="wt-userlistinghold wt-featured wt-dashboradsaveditems">
												
												<div class="wt-userlistingcontent">
													<div class="wt-contenthead wt-dashboardsavehead">
														<div class="wt-title">
															<!-- <a href="usersingle.html"><i class="fa fa-check-circle"></i> Choosen Design -->
															</a>
															<h2><a href="{{ route('job.show',$saveJob->jobData->job_id)}}" class="text-reset" style="font-size: 18px;">{{$saveJob->jobData->job_title}}</a></h2>
														</div>
														<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
															<li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{$saveJob->jobData->service_level}}</span></li>
															<!-- <li><span><img src="images/flag/img-04.png" alt="img description"> {{$saveJob->jobData->country}}</span></li> -->
															<li><a href="javascript:void(0);" class="wt-clicksavefolder text-capitalize"><i class="far fa-folder"></i> Type: {{$saveJob->jobData->job_type}}</a></li>
															<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> Duration: {{$saveJob->jobData->job_duration}}</span></li>
															<li><a href="javascript:void(0);" class="wt-clicksave" onclick="saveJob({{$saveJob->jobData->id}})"><i class="fa fa-heart"></i> Saved</a></li>															
														</ul>
													</div>
												</div>	
											</div>
											@endforeach																								
										</div>										
									</div>
									<!-- <nav class="wt-pagination wt-savepagination">
										<ul>
											<li class="wt-prevpage"><a href="javascrip:void(0);"><i class="fal fa-chevron-left"></i></a></li>
											<li><a href="javascrip:void(0);">1</a></li>
											<li><a href="javascrip:void(0);">2</a></li>
											<li><a href="javascrip:void(0);">3</a></li>
											<li><a href="javascrip:void(0);">4</a></li>
											<li><a href="javascrip:void(0);">...</a></li>
											<li><a href="javascrip:void(0);">50</a></li>
											<li class="wt-nextpage"><a href="javascrip:void(0);"><i class="fal fa-chevron-right"></i></a></li>
										</ul>
									</nav> -->	
								</div>
								<div class="wt-educationholder tab-pane fade @if(Auth::user()->account_type == 'Client') active show @endif"  id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
									<div class="wt-addprojectsholder wt-likefreelan">
										<div class="wt-tabscontenttitle">
											<h2>Liked Freelancers</h2>
										</div>
										<div class="wt-likedfreelancers wt-haslayout">
											@foreach($saveFreelancers as $savefree)
											<div class="wt-userlistinghold wt-featured saveuser{{$savefree->userData->id}}">
												<!-- <span class="wt-featuredtag"><img src="images/featured.png" alt="img description" data-tipso="Plus Member" class="template-content tipso_style"></span> -->
												<figure class="wt-userlistingimg">
													<img src="{{asset('assets/images/user/profile/'.$savefree->userData->profile_image)}}" alt="image description">
												</figure>
												<div class="wt-userlistingcontent">
													<div class="wt-contenthead">
														<div class="wt-title">
															<a href="{{ route('freelancers.show',$savefree->userData->username)}}"><i class="fa fa-check-circle"></i> {{$savefree->userData->first_name}} {{$savefree->userData->last_name}}
															</a>
															<h2>{{$savefree->userData->tagline}}</h2>
														</div>
														<ul class="wt-userlisting-breadcrumb">
															<li><span><i class="far fa-money-bill-alt"></i> ${{$savefree->userData->hourly_rate}}.00 / hr</span></li>
															<li><span><!-- <img src="images/flag/img-02.png" alt="img description"> --> {{$savefree->userData->country}}</span></li>
															<li><a href="javascript:void(0);" class="wt-clicksave" onclick="saveUser({{$savefree->userData->id}});"><i class="fa fa-heart"></i> Save</a></li>
														</ul>
													</div>
													<!-- <div class="wt-rightarea">
														<span class="wt-starsvtwo">
															<i class="fa fa-star fill"></i>
															<i class="fa fa-star fill"></i>
															<i class="fa fa-star fill"></i>
															<i class="fa fa-star fill"></i>
															<i class="fa fa-star fill"></i>
														</span>
														<span class="wt-starcontent">4.5/<sub>5</sub> <em>(860 Feedback)</em></span>
													</div> -->
												</div>	
											</div>
											@endforeach
										</div>
									</div>
									<!-- <nav class="wt-pagination wt-savepagination">
										<ul>
											<li class="wt-prevpage"><a href="javascrip:void(0);"><i class="fal fa-chevron-left"></i></a></li>
											<li><a href="javascrip:void(0);">1</a></li>
											<li><a href="javascrip:void(0);">2</a></li>
											<li><a href="javascrip:void(0);">3</a></li>
											<li><a href="javascrip:void(0);">4</a></li>
											<li><a href="javascrip:void(0);">...</a></li>
											<li><a href="javascrip:void(0);">50</a></li>
											<li class="wt-nextpage"><a href="javascrip:void(0);"><i class="fal fa-chevron-right"></i></a></li>
										</ul>
									</nav> -->	
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
						<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
							@if(Auth::user()->account_type != 'Client')
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent">
									<figure>
										<img src="{{asset('assets/images/save-1.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{$jobCount}}</h3>
										<span>Jobs you saved</span>
									</div>
								</div> 
							</div>	
							@endif							
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent  wt-freelancelike">
									<figure>
										<img src="{{asset('assets/images/save-3.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{$freelancerCount}}</h3>
										<span>Freelancers you liked</span>
									</div>
								</div> 
							</div>								
						</aside>
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
<script>
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	function saveUser(id){
   	$.ajax({
	    url:"{{ url('save-freelancer') }}",
	    method:"POST",
	    data:{
	    	"_token": CSRF_TOKEN,
        "freelancer_id": id,
        "save_type": 'Freelancer',
      },
	    success:function(data){
	    	$('.saveuser'+id).addClass('d-none');
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
	function saveJob(id){
   	$.ajax({
	    url:"{{ url('save-job') }}",
	    method:"POST",
	    data:{
	    	"_token": CSRF_TOKEN,
        "job_id": id,
        "save_type": 'Job',
      },
	    success:function(data){
	    	console.log(data);
	    	if (data == 1) {
	    		$('.save'+id).html('<i class="fa fa-heart"></i> Saved');
	    	}
	    	if(data == 2){
	    		$('.save'+id).html('<i class="far fa-heart"></i> Click to save');
	    	}
	    	// $("#add-project-form")[0].reset();
	    	// $('#pills-home-tab').removeClass('active');
	    	// $('#pills-profile-tab').addClass('active');
	    	// $('#pills-home').removeClass('show active');
	    	// $('#pills-profile').addClass('show active');
    	}
   	})
	}
</script>
@endsection