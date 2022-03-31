@extends('frontend.layouts.app')
@section('content')
<style>
	.wt-userdetails .wt-description[data-readmore] {
	  transition: height 500ms;
	  overflow: hidden;
	}
	.wt-userdetails .wt-description + [data-readmore-toggle], .wt-userdetails .wt-description[data-readmore] {
	    display: block;
	    width: 100%;
	}
	.carousel-control-next-icon, .carousel-control-prev-icon{
		background-color: #000;
	}
	.img-size{
	/* 	padding: 0;
		margin: 0; */
		height: 400px;
		width: 700px;
		background-size: cover;
		overflow: hidden;
	}
</style>
<?php 
	if($freelancer->cover_image != ''){
		$background = 'background: url(/assets/images/user/cover/'.$freelancer->cover_image.') no-repeat center'.';'.'background-size: cover';
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
<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
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
										@if($freelancer->profile_image != '')
										<img src="{{asset('assets/images/user/profile/'.$freelancer->profile_image)}}" alt="img description">
										@else
										<img src="{{asset('assets/images/user-login.png')}}" alt="img description">
										@endif
										<div class="wt-userdropdown {{$freelancer->user_status == 'online' ? 'wt-online' : 'wt-offline'}}">
										</div>
									</figure>
									<div class="wt-title">
										<!-- <h3><i class="fa fa-check-circle"></i> {{$freelancer->first_name}} {{$freelancer->last_name}}</h3> -->
										<span>{{$rating_avg}}/5 <a class="javascript:void(0);">({{$freelancer->freelancer_rating_count}} Feedback)</a> <br>Member since {{$freelancer->created_at->format('F j, Y')}}<br><a href="javascript:void(0);">@ {{$freelancer->username}}</a> </span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-12 col-lg-9 float-left">
							<div class="row">
								<div class="wt-proposalhead wt-userdetails col-md-7">
									<h2 class="mb-1">{{$freelancer->first_name}} {{$freelancer->last_name}} </h2>
									<h5>{{$freelancer->tagline}}</h5>
									<ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
										<li><span><i class="far fa-money-bill-alt"></i> ${{$freelancer->hourly_rate}}.00 / hr</span></li>
										<li><span><i class="fal fa-map-marker-alt"></i> {{$freelancer->country}}</span></li>
										<li><a href="javascript:void(0);" class="wt-clicksave"><i class="fa fa-heart"></i> Save</a></li>
									</ul>
									<div class="wt-description">
										<p>{{$freelancer->description}}</p>
									</div>
								</div>
								<div id="wt-statistics" class="wt-statistics wt-profilecounter col-md-5">
									<div class="wt-statisticcontent wt-countercolor1">
										<h3 data-from="0" data-to="03" data-speed="800" data-refresh-interval="03">{{App\Models\Proposal::freelancerOngoingCount($freelancer->id)}}</h3>
										<h4>Ongoing <br>Projects</h4>
									</div>
									<div class="wt-statisticcontent wt-countercolor2">
										<h3 data-from="0" data-to="1503" data-speed="8000" data-refresh-interval="100">{{App\Models\Proposal::freelancerCompletedCount($freelancer->id)}}</h3>
										<h4>Completed <br>Projects</h4>
									</div>
									<div class="wt-statisticcontent wt-countercolor4">
										<h3 data-from="0" data-to="02" data-speed="800" data-refresh-interval="02">{{App\Models\Proposal::freelancerCancelledCount($freelancer->id)}}</h3>
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
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 float-left ps-md-0">
					<div class="wt-usersingle">
						<div class="wt-clientfeedback">
							<div class="wt-usertitle wt-titlewithselect">
								<h2>Client Feedback</h2>
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
							@foreach($freelancer->freelancerRating as $rating)
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
						@if($freelancer->userProjects != '')
						<div class="wt-craftedprojects">
							<div class="wt-usertitle">
								<h2>Portfolio</h2>
							</div>
							<div class="wt-projects">
								@foreach($freelancer->userProjects as $project)
								<?php 
									$imgs = explode(",", $project->project_img);
								?>
								<div class="wt-project">
									<figure>
										<img src="{{asset('assets/images/projects/'.$imgs[0])}}" alt="img description" style="height: 140px;" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$project->id}}">
									</figure>
									<div class="wt-projectcontent">
										<h3><a href="{{$project->project_url == '' ? 'javascript:void(0)' : $project->project_url}}" class="text-reset">{{$project->project_title}}</a></h3>
										<!-- <a href="{{$project->project_url}}">{{$project->project_url}}</a> -->
									</div>
								</div>
								<!-- modal -->
								  <div class="modal fade" id="exampleModal-{{$project->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
								    <div class="modal-dialog">
								      <div class="modal-content">
								      	<button type="button" class="close position-absolute end-0 bg-transparent fs-5" data-bs-dismiss="modal" style="z-index: 1050;">&times;</button>
								        <div class="modal-body p-0">
								           <!-- carousel -->
								          <div
								               id='carouselExampleIndicators-{{$project->id}}'
								               class='carousel slide'
								               data-bs-ride='carousel'
								               >
								            <!-- <ol class='carousel-indicators'>
								              <li
								                  data-bs-target='#carouselExampleIndicators'
								                  data-bs-slide-to='0'
								                  class='active'
								                  ></li>
								              <li
								                  data-bs-target='#carouselExampleIndicators'
								                  data-bs-slide-to='1'
								                  ></li>
								              <li
								                  data-bs-target='#carouselExampleIndicators'
								                  data-bs-slide-to='2'
								                  ></li>
								            </ol> -->
								            <div class='carousel-inner'>
								            	@foreach(explode(',',$project->project_img) as $key => $attach)
								              <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
								                <img class='img-size' src="{{asset('assets/images/projects/'.$attach)}}" alt='First slide' />
								              </div>
								              @endforeach
								            </div>
								            <a
								               class='carousel-control-prev'
								               href='#carouselExampleIndicators-{{$project->id}}'
								               role='button'
								               data-bs-slide='prev'
								               >
								              <span class='carousel-control-prev-icon'
								                    aria-hidden='true'
								                    ></span>
								              <span class='sr-only'>Previous</span>
								            </a>
								            <a
								               class='carousel-control-next'
								               href='#carouselExampleIndicators-{{$project->id}}'
								               role='button'
								               data-bs-slide='next'
								               >
								              <span
								                    class='carousel-control-next-icon'
								                    aria-hidden='true'
								                    ></span>
								              <span class='sr-only'>Next</span>
								            </a>
								          </div>
								          <div class="p-3">
								          	<h5>{{$project->project_title}}</h5>
								          	<p>{{$project->project_desc}}</p>
								          	@if($project->youtube_link != '')
								          	<h5 class="mb-0">Youtube Link</h5>
								          	<a href="{{$project->youtube_link}}" target="_blank">{{$project->youtube_link}}</a>
								          	@endif
								          	<br>
								          	@if($project->pdf_files != '')
								          	<h5 class="mt-3 mb-0">Files</h5>
								          	<a href="{{asset('assets/images/projects/'.$project->pdf_files)}}" target="_blank" download>{{$project->pdf_files}}</a>
								          	@endif
								          </div>
								        </div>
								        <!-- <div class="modal-footer">
								          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
								        </div> -->
								      </div>
								    </div>
								  </div>
								<!-- <div id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal" role="dialog">
								  <div class="modal-dialog modal-md">
								  <div class="modal-content">
								    <div class="modal-header">
								     Crop & Insert Cover <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
								    </div>
								    <div class="modal-body">
								      <div id="wt-categoriesslider" class="wt-categoriesslider owl-carousel">
							      		<div class="wt-categoryslidercontent item">
							      			<figure><img src="{{asset('assets/images/categories/slider/img-01.png')}}" alt="image description"></figure>
							      			<div class="wt-cattitle">
							      				<h3><a href="javascrip:void(0);">Graphic &amp; Design</a></h3>
							      				<span>Items: 523,112</span>
							      			</div>
							      		</div>
							      		<div class="wt-categoryslidercontent item">
							      			<figure><img src="{{asset('assets/images/categories/slider/img-02.png')}}" alt="image description"></figure>
							      			<div class="wt-cattitle">
							      				<h3><a href="javascrip:void(0);">Digital Marketing</a></h3>
							      				<span>Items: 523,112</span>
							      			</div>
							      		</div>
							      		<div class="wt-categoryslidercontent item">
							      			<figure><img src="{{asset('assets/images/categories/slider/img-03.png')}}" alt="image description"></figure>
							      			<div class="wt-cattitle">
							      				<h3><a href="javascrip:void(0);">Writing &amp; Translation</a></h3>
							      				<span>Items: 325,442</span>
							      			</div>
							      		</div>
							      	</div>

								    </div>
								    <div class="modal-footer">
								      <input type="hidden" name="img_type_cover" value="">
								      <button class="btn crop_image_cover">Crop Image</button>
								      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
								    </div>
								    </div>
								  </div>
								</div> -->
								@endforeach
								
								<!-- <div class="wt-btnarea">
									<a href="javascript:void(0);" class="wt-btn">Load More</a>
								</div> -->
							</div>
						</div>
						@endif
						@if($freelancer->userInfo != '')
						<div class="wt-experience">
							<div class="wt-usertitle">
								<h2>Employment History</h2>
							</div>
							<div class="wt-experiencelisting-hold">
								@foreach($freelancer->userInfo as $key=>$experience)
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
						@if($freelancer->education != '')
						<div class="wt-experience wt-education">
							<div class="wt-usertitle">
								<h2>Education</h2>
							</div>
							<div class="wt-experiencelisting-hold">
								@foreach($freelancer->education as $key=>$education)
								<div class="wt-experiencelisting wt-bgcolor">
									<div class="wt-title">
										<h3>{{$education->degree}}</h3>
									</div>
									<div class="wt-experiencecontent">
										<ul class="wt-userlisting-breadcrumb mb-0">
											<li><span><i class="far fa-building"></i> {{$education->institute}}</span></li>
											<li><span><i class="far fa-calendar"></i> {{\Carbon\Carbon::parse($education->start_date)->format('F Y')}} - {{\Carbon\Carbon::parse($education->end_date)->format('F Y')}}</span></li>
										</ul>
										<!-- <div class="wt-description">
											<p>“ {{$education->description}} ”</p>
										</div> -->
									</div>
								</div>
								@endforeach
								<div class="divheight"></div>
							</div>
						</div>
						@endif
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 float-left pe-md-0">
					<aside id="wt-sidebar" class="wt-sidebar">
						@if($freelancer->userSkills != '')
						<div id="wt-ourskill" class="wt-widget">
							<div class="wt-widgettitle">
								<h2>My Skills</h2>
							</div>
							<div class="wt-widgetcontent wt-skillscontent">
								@foreach($freelancer->userSkills as $key=>$skill)
								<div class="wt-skillholder" data-percent="{{$skill->skill_rate}}%">
									<span>{{ App\Models\User::skillTitle($skill->skill_id)->skill_name }} </span>
									<!-- <div class="wt-skillbarholder"><div class="wt-skillbar"></div></div> -->
								</div>
								@endforeach
								<!-- <div class="wt-btnarea">
									<a href="javascript:void(0)">View More</a>
								</div> -->
							</div>
						</div>
						@endif
						@if($freelancer->certificates != '')
						<div class="wt-widget wt-widgetarticlesholder wt-articlesuser">
							<div class="wt-widgettitle">
								<h2>Awards &amp; Certifications</h2>
							</div>
							<div class="wt-widgetcontent">
								@foreach($freelancer->certificates as $key=>$certificate)
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
						<!-- <div class="wt-widget">
							<div class="wt-widgettitle">
								<h2>Similar Freelancers</h2>
							</div>
							<div class="wt-widgetcontent">
								<div class="wt-widgettag wt-widgettagvtwo">
									<a href="javascript:void(0);">PHP Developer</a>
									<a href="javascript:void(0);">PHP</a>
									<a href="javascript:void(0);">My SQL</a>
									<a href="javascript:void(0);">Business</a>
									<a href="javascript:void(0);">Website Development</a>
									<a href="javascript:void(0);">Collaboration</a>
									<a href="javascript:void(0);">Decent</a>
								</div>
							</div>
						</div> -->
						<!-- <div class="wt-widget wt-sharejob">
							<div class="wt-widgettitle">
								<h2>Share This User</h2>
							</div>
							<div class="wt-widgetcontent">
								<ul class="wt-socialiconssimple">
									<li class="wt-facebook"><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i>Share on Facebook</a></li>
									<li class="wt-twitter"><a href="javascript:void(0);"><i class="fab fa-twitter"></i>Share on Twitter</a></li>
									<li class="wt-linkedin"><a href="javascript:void(0);"><i class="fab fa-linkedin-in"></i>Share on Linkedin</a></li>
									<li class="wt-googleplus"><a href="javascript:void(0);"><i class="fab fa-google-plus-g"></i>Share on Google Plus</a></li>
								</ul>
							</div>
						</div> -->
						<div class="wt-widget wt-reportjob">
							<div class="wt-widgettitle">
								<h2>Report This User</h2>
							</div>
							<div class="wt-widgetcontent">
								<form class="wt-formtheme wt-formreport" id="reportForm">
									@csrf
									<fieldset>
										<input type="hidden" name="user_id" value="{{$freelancer->id}}">
										<input type="hidden" name="report_by" value="{{Auth::user()->id}}">
										<div class="form-group">
											<span class="wt-select">
												<select name="reason">
													<option disabled="" selected="">Select Reason</option>
													<option value="Fake User">Fake User</option>
													<option value="Fraud">Fraud</option>
													<!-- <option value="reason3">Reason3</option> -->
													<!-- <option value="reason4">Reason4</option> -->
												</select>
											</span>
										</div>
										<div class="form-group">
											<textarea class="form-control" name="description" placeholder="Description"></textarea>
										</div>
										<div class="form-group wt-btnarea">
											<button type="submit" name="submit" id="reportSubmit" class="wt-btn">Submit</button>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</aside>
				</div>
			</div>
		</div>
		<!-- User Listing End-->
	</div>
</main>
<!--Main End-->
@endsection
@section('script')
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script>
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$('.carousel').carousel();
	var _wt_categoriesslider = jQuery("#wt-categoriesslider");
	_wt_categoriesslider.owlCarousel({
		item: 1,
		loop:true,
		nav:false,
		margin: 0,
		autoplay:false,
		center: true,
		responsiveClass:true,
		responsive:{
			0:{items:1,},
			481:{items:1,},
			768:{items:1,},
			1440:{items:1,},
			1760:{items:1,}
		}
	});

	

	// $('#reportSubmit').click(function(event){
	// 	event.preventDefault();
	// 	alert('dada');
	// });
</script>
@endsection