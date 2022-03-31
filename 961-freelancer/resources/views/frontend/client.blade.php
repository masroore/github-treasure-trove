@extends('frontend.layouts.app')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
	.mCSB_inside > .mCSB_container {
	    margin: 0;
	    margin-right: 0 !important;
	}
	.wt-companysdetails {
    margin: 1px 0 !important;
  }
  @media (max-width: 1360px){
	  .wt-wrapper .wt-sidebarwrapper {
	      margin-top: 100px;
	  }
	}
</style>
@if(Auth::user() != '' && Auth::user()->account_type == 'Client')
<style>
	@media(min-width: 768px){
		.footer-social a {
		    display: inline-grid !important;
		    align-content: center;
		}
	}
</style>
@endif
@section('content')
<?php 
	if($client->cover_image != ''){
		$background = 'background: url(/assets/images/user/cover/'.$client->cover_image.') no-repeat center'.';'.'background-size: cover';
	}else{
		$background = 'background : #ed1c24';
	}
		
?>
<!--Inner Home Banner Start-->
<div class="wt-haslayout wt-innerbannerholder wt-innerbannerholdervtwo" style="{{$background}}">
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
			</div>
		</div>
	</div>
</div>
<!--Inner Home End-->
<!--Main Start-->
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout" style="overflow: visible;">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
			@if(Auth::user() != '' && Auth::user()->account_type == 'Client')
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			@endif
			<!-- User Profile Start-->
			<div class="wt-main-section wt-paddingtopnull wt-haslayout">
				<div class="container">
					<div class="row justify-content-center">	
						<div class="col-12 col-sm-12 col-md-11 col-lg-11">
							<div class="wt-userprofileholder row">
								<!-- <span class="wt-featuredtag"><img src="{{asset('assets/images/joblisting/featured.png')}}" alt="img description" data-tipso="Plus Member" class="template-content tipso_style"></span> -->
								<div class="col-12 col-sm-12 col-md-12 col-lg-3 float-left">
									<div class="row">
										<div class="wt-userprofile">
											<figure>
												@if($client->profile_image != '')
												<img src="{{asset('assets/images/user/profile/'.$client->profile_image)}}" alt="img description">
												@else
												<img src="{{asset('assets/images/user-login.png')}}" alt="img description">
												@endif
												<div class="wt-userdropdown {{$client->user_status == 'online' ? 'wt-online' : 'wt-offline'}}">
												</div>
											</figure>
											<div class="wt-title">
												<!-- <h3><i class="fa fa-check-circle"></i> {{$client->first_name}} {{$client->last_name}}</h3> -->
												<span>{{$rating_avg}}/5 <a class="javascript:void(0);">({{$client->freelancer_rating_count}} Feedback)</a> <br>Member since {{$client->created_at->format('F j, Y')}}<br><a href="javascript:void(0);">@ {{$client->username}}</a> </span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-12 col-lg-9 float-left">
									<div class="row">
										<div class="wt-proposalhead wt-userdetails col-md-7">
											<h2 class="mb-1">{{$client->first_name}} {{$client->last_name}}</h2>
											<h5>{{$client->tagline}}</h5>
											<ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
												<!-- <li><span><i class="far fa-money-bill-alt"></i> ${{$client->hourly_rate}}.00 / hr</span></li> -->
												<li><span><i class="fal fa-map-marker-alt"></i> {{$client->country}}</span></li>
												<!-- <li><a href="javascript:void(0);" class="wt-clicksave"><i class="fa fa-heart"></i> Save</a></li> -->
											</ul>
											<div class="wt-description">
												<p>{{$client->description}}</p>
											</div>
										</div>
										<div id="wt-statistics" class="wt-statistics wt-profilecounter col-md-5">
											<div class="wt-statisticcontent wt-countercolor1">
												<h3 data-from="0" data-to="03" data-speed="800" data-refresh-interval="03">{{App\Models\Job::clientOngoingCount($client->id)}}</h3>
												<h4>Ongoing <br>Projects</h4>
											</div>
											<div class="wt-statisticcontent wt-countercolor2">
												<h3 data-from="0" data-to="1503" data-speed="8000" data-refresh-interval="100">{{App\Models\Job::clientCompletedCount($client->id)}}</h3>
												<h4>Completed <br>Projects</h4>
											</div>
											<div class="wt-statisticcontent wt-countercolor4">
												<h3 data-from="0" data-to="02" data-speed="800" data-refresh-interval="02">{{App\Models\Job::clientCancelledCount($client->id)}}</h3>
												<h4>Cancelled <br>Projects</h4>
											</div>
											<div class="wt-statisticcontent wt-countercolor3">
												<h3 data-from="0" data-to="25" data-speed="8000" data-refresh-interval="100">00</h3>
												<em>k</em>
												<h4>Served <br>Hours</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- User Profile End-->
				<!-- User Listing Start-->
				<div class="container">
					<div id="wt-twocolumns" class="row wt-twocolumns wt-haslayout justify-content-center">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-11 px-md-0 float-left">
							<div class="wt-usersingle">
								<div class="wt-clientfeedback">
									<div class="wt-usertitle wt-titlewithselect">
										<h2>Freelancers Feedback</h2>
										<!-- <div class="form-group">
											<span class="wt-select">
												<select>
													<option value="Show All">Show All</option>
													<option value="One Page">One Page </option>
													<option value="Two Page">Two Page</option>
												</select>
											</span>
										</div> -->
									</div>
									@foreach($client->freelancerRating as $rating)
									<div class="wt-userlistinghold wt-userlistingsingle">	
										<figure class="wt-userlistingimg">
											<img src="{{asset('assets/images/client/img-02.jpg')}}" alt="image description">
										</figure>
										<div class="wt-userlistingcontent">
											<div class="wt-contenthead">
												<div class="wt-title">
													<a href="javascript:void(0);"><i class="fa fa-check-circle"></i> {{App\Models\Job::client($rating->rating_by)->first_name}} {{App\Models\Job::client($rating->rating_by)->last_name}}</a>
													<h3>{{App\Models\Job::jobData($rating->job_id)->job_title}}</h3>
												</div>
												<ul class="wt-userlisting-breadcrumb">
													<li><span><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i> {{App\Models\Job::jobData($rating->job_id)->service_level}}</span></li>
													<li><span><i class="fal fa-map-marker-alt"></i>  {{App\Models\Job::jobData($rating->job_id)->job_location}}</span></li>
													<li><span><i class="far fa-calendar"></i> Completed</span></li>
													<li>
														<span class="rating-star">
															@if($rating->general_rating == 5)
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															@elseif($rating->general_rating == 4)
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fal fa-star"></i>
															@elseif($rating->general_rating == 3)
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															@elseif($rating->general_rating == 2)
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															@elseif($rating->general_rating == 1)
															<i class="fa fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															@else
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															<i class="fal fa-star"></i>
															@endif
														</span>
													</li>
												</ul>
											</div>
										</div>
										<div class="wt-description">
											<p>“ {{$rating->feedback}} ”</p>
										</div>
									</div>
									@endforeach
									<!-- <div class="wt-btnarea">
										<a href="javascript:void(0);" class="wt-btn">Load More</a>
									</div> -->
								</div>
								<!-- @if($client->userProjects != '')
								<div class="wt-craftedprojects">
									<div class="wt-usertitle">
										<h2>Projects</h2>
									</div>
									<div class="wt-projects">
										@foreach($client->userProjects as $project)
										<div class="wt-project">
											<figure>
												<img src="{{asset('assets/images/projects/'.$project->project_img)}}" alt="img description" style="height: 140px;">
											</figure>
											<div class="wt-projectcontent">
												<h3><a href="{{$project->project_url}}" class="text-reset">{{$project->project_title}}</a></h3>
											</div>
										</div>
										@endforeach
									</div>
								</div>
								@endif -->
								@if($client->userInfo != '')
								<div class="wt-experience">
									<div class="wt-usertitle">
										<h2>Experience</h2>
									</div>
									<div class="wt-experiencelisting-hold">
										@foreach($client->userInfo as $key=>$experience)
										<div class="wt-experiencelisting wt-bgcolor">
											<div class="wt-title">
												<h3>{{$experience->job_title}}</h3>
											</div>
											<div class="wt-experiencecontent">
												<ul class="wt-userlisting-breadcrumb">
													<li><span><i class="far fa-building"></i> {{$experience->company_title}}</span></li>
													<li><span><i class="far fa-calendar"></i>  {{ \Carbon\Carbon::parse($experience->start_date)->format('F Y')}} - 
														@if($experience->end_date == '')
														Till Now
														@else
														{{ \Carbon\Carbon::parse($experience->end_date)->format('F Y')}}
														@endif
													</span></li>
												</ul>
												<div class="wt-description">
													<p>{{$experience->job_description}}</p>
												</div>
											</div>
										</div>
										@endforeach
										<div class="divheight"></div>
									</div>
								</div>
								@endif
								<!-- @if($client->education != '')
								<div class="wt-experience wt-education">
									<div class="wt-usertitle">
										<h2>Education</h2>
									</div>
									<div class="wt-experiencelisting-hold">
										@foreach($client->education as $key=>$education)
										<div class="wt-experiencelisting wt-bgcolor">
											<div class="wt-title">
												<h3>{{$education->degree}}</h3>
											</div>
											<div class="wt-experiencecontent">
												<ul class="wt-userlisting-breadcrumb mb-0">
													<li><span><i class="far fa-building"></i> {{$education->institute}}</span></li>
													<li><span><i class="far fa-calendar"></i> {{\Carbon\Carbon::parse($education->start_date)->format('F Y')}} - {{\Carbon\Carbon::parse($education->end_date)->format('F Y')}}</span></li>
												</ul>
											</div>
										</div>
										@endforeach
										<div class="divheight"></div>
									</div>
								</div>
								@endif -->
							</div>
						</div>
						<!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 pe-md-0">
							<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
								<div class="wt-proposalsr">
									<div class="wt-proposalsrcontent">
										<figure>
											<img src="{{asset('assets/images/thumbnail/img-17.png')}}" alt="image">
										</figure>
										<div class="wt-title">
											<h3>{{App\Models\Job::clientOngoingCount(Auth::user()->id)}}</h3>
											<span>Total Ongoing Jobs</span>
										</div>
									</div> 
								</div>
								<div class="wt-proposalsr">
									<div class="wt-proposalsrcontent wt-componyfolow">
										<figure>
											<img src="{{asset('assets/images/thumbnail/img-16.png')}}" alt="image">
										</figure>
										<div class="wt-title">
											<h3>{{App\Models\Job::clientCompletedCount(Auth::user()->id)}}</h3>
											<span>Total Completed Jobs</span>
										</div>
									</div> 
								</div>								
								<div class="wt-proposalsr">
									<div class="wt-proposalsrcontent  wt-freelancelike">
										<figure>
											<img src="{{asset('assets/images/thumbnail/img-15.png')}}" alt="image">
										</figure>
										<div class="wt-title">
											<h3>{{App\Models\Job::clientCancelledCount(Auth::user()->id)}}</h3>
											<span>Total Cancelled Jobs</span>
										</div>
									</div> 
								</div>								
							</aside>
						</div> -->
						<!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 float-left">
							<aside id="wt-sidebar" class="wt-sidebar">
								@if($client->userSkills != '')
								<div id="wt-ourskill" class="wt-widget">
									<div class="wt-widgettitle">
										<h2>My Skills</h2>
									</div>
									<div class="wt-widgetcontent wt-skillscontent">
										@foreach($client->userSkills as $key=>$skill)
										<div class="wt-skillholder" data-percent="{{$skill->skill_rate}}%">
											<span>{{ App\Models\User::skillTitle($skill->skill_id)->skill_name }} </span>
										</div>
										@endforeach
									</div>
								</div>
								@endif
								@if($client->certificates != '')
								<div class="wt-widget wt-widgetarticlesholder wt-articlesuser">
									<div class="wt-widgettitle">
										<h2>Awards &amp; Certifications</h2>
									</div>
									<div class="wt-widgetcontent">
										@foreach($client->certificates as $key=>$certificate)
										<div class="wt-particlehold">
											<figure>
												<img src="{{asset('assets/images/thumbnail/img-07.jpg')}}" alt="image description">
											</figure>
											<div class="wt-particlecontent">
												<h3><a href="javascript:void(0);">{{$certificate->certificate_title}}</a></h3>
												<span><i class="fal fa-calendar"></i> {{\Carbon\Carbon::parse($certificate->issue_date)->format('F Y')}}</span>
											</div>
										</div>
										@endforeach
									</div>
								</div>
								@endif
							</aside>
						</div> -->
					</div>
				</div>
				<!-- User Listing End-->
			</div>
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
@endsection