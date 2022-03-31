@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/croppie.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/owl.carousel.min.css') }}">
<style>
	.home-header{
		z-index: 29;
		background: #fff;
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
	.dragBox {
	  width: 100%;
	  height: 56px;
	  margin: 0 auto;
	  position: relative;
	  text-align: center;
	  font-weight: bold;
	  line-height: 57px;
	  color: #999;
	  /*border: 2px dashed #ccc;*/
	  display: inline-block;
	  transition: transform 0.3s;
	}
	.dragBox input[type="file"] {
    position: absolute;
    height: 100%;
    width: 100%;
    opacity: 0;
    top: 0;
    left: 0;
  }
	.draging {
	  transform: scale(1.1);
	}
	#preview {
	  text-align: center;
	}
	#preview img {
	  max-width: 100%
	}
	
</style>
@endsection
@section('content')
<?php 

?>
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
				<section class="wt-haslayout wt-jobpostedholder">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
							<div class="wt-haslayout wt-dbsectionspace">
								<div class="wt-dashboardbox">
									<div class="wt-dashboardboxtitle wt-yeartag">
										<h2>Job Posted</h2>
										<!-- <div class="wt-tag wt-widgettag">
											<a href="javascript:void(0);">2019</a>
											<a href="javascript:void(0);">2018</a>
											<a href="javascript:void(0);">2017</a>
										</div> -->
									</div>
									<div class="wt-dashboardboxcontent">
										<div id="wt-postedsilder" class="wt-postedsilder owl-carousel">
											@foreach($jobs as $job)
											<div class="item">
												<div class="wt-posteditem">
													<span><i class="fa fa-check-circle"></i><a href="javascript:void(0);"> {{Auth::user()->first_name}} {{Auth::user()->last_name}}</a></span>
													<h3 class="fs-6">{{$job->job_title}}</h3>
												</div>
											</div>
											@endforeach
										</div>
										<div class="wt-jobchartholder">
											
											<canvas id="wt-jobchart" class="wt-jobchart"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="wt-haslayout wt-dbsectionspace">
								<div class="wt-dashboardbox">
									<div class="wt-dashboardboxtitle">
										<h2>Hired Freelancers</h2>
									</div>
									<div class="wt-dashboardboxcontent wt-hiredfreelance">
										@if(count($hiredFreelancers) > 0)
											@foreach($hiredFreelancers as $freelancer)
											<div class="wt-userlistinghold wt-featured">
												<!-- <span class="wt-featuredtag"><img src="images/featured.png" alt="img description" data-tipso="Plus Member" class="template-content"></span> -->
												<figure class="wt-userlistingimg">
													<img src="{{asset('assets/images/user/profile/'.App\Models\Proposal::freelancer(App\Models\Proposal::selectedProposal($freelancer->job_id)->user_id)->profile_image)}}" alt="image description" class="img description">
												</figure>
												<div class="wt-proposaldetails">
													<div class="wt-contenthead">
														<div class="wt-title">
															<h3><a href="javascript:void(0);">
																{{App\Models\Proposal::freelancer(App\Models\Proposal::selectedProposal($freelancer->job_id)->user_id)->first_name}} 
																{{App\Models\Proposal::freelancer(App\Models\Proposal::selectedProposal($freelancer->job_id)->user_id)->last_name}}</a><span>{{$freelancer->job_title}}</span></h3>
															<a href="javascript:void(0)" class="wt-hiredarrow"><i class="fal fa-chevron-right"></i></a>
														</div>
													</div>													
												</div>	
											</div>
											@endforeach		
										@else
										<div class="wt-userlistinghold wt-featured">
											<p>Currently you didn't hire any freelancer</p>
										</div>
										@endif																	
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave wt-dbsectionspace">
								<div class="wt-proposalsr wt-box-shadow">
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
								<div class="wt-proposalsr wt-box-shadow">
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
								<div class="wt-proposalsr wt-box-shadow">
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
								<!-- <div class="wt-proposalsr wt-box-shadow">
									<div class="wt-proposalsrcontent wt-repostjob">
										<figure>
											<img src="{{asset('assets/images/thumbnail/img-18.png')}}" alt="image">
										</figure>
										<div class="wt-title">
											<h3>0</h3>
											<span>Total Repost Jobs</span>
										</div>
									</div> 
								</div> -->								
							</aside>
						</div>
					</div>
				</section>
				<!--Register Form End-->
				<!--More Details Start-->
				<section class="wt-haslayout wt-dbsectionspace wt-padding-add-top wt-moredetailsholder">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
							<div class="wt-insightsitem wt-dashboardbox {{ App\Models\ChatMessages::getUnseenMsg() > 0 ? 'wt-insightnoticon' : '' }}">
								<figure class="wt-userlistingimg">
									<img src="{{asset('assets/images/thumbnail/img-19.png')}}" alt="image description" class="mCS_img_loaded">
								</figure>
								<div class="wt-insightdetails">
									<div class="wt-title">
										<h3>New Messages</h3>
										<a href="{{ route('messages') }}">Click To View</a>
									</div>													
								</div>	
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
							<div class="wt-insightsitem wt-dashboardbox">
								<figure class="wt-userlistingimg">
									<img src="{{asset('assets/images/thumbnail/img-20.png')}}" alt="image description" class="mCS_img_loaded">
								</figure>
								<div class="wt-insightdetails">
									<div class="wt-title">
										<h3>Latest Proposals</h3>
										<a href="{{route('proposals')}}">Click To View</a>
									</div>													
								</div>	
							</div>
						</div>												
						<!-- <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="wt-insightsitem wt-dashboardbox">
								<ul class="wt-countersoon" data-date="May 14 2019 20:20:22">
									<li><i class="fa fa-spinner fa-spin"></i></li>
						    		<li>
							    		<div class="wt-countdowncontent">
							    			<p>d</p> <span class="days" data-days></span>
						    			</div>
					    			</li>
						    		<li>
						    			<div class="wt-countdowncontent">
						    				<p>h</p> <span class="hours" data-hours></span>
					    				</div>
				    				</li>
						    		<li>
						    			<div class="wt-countdowncontent">
						    				<p>m</p> <span class="minutes" data-minutes></span>
					    				</div>
				    				</li>
						    		<li>
						    			<div class="wt-countdowncontent">
						    				<p>s</p> <span class="seconds" data-seconds></span>
					    				</div>
				    				</li>
						    	</ul> 
								<figure class="wt-userlistingimg">
									<img src="{{asset('assets/images/thumbnail/img-21.png')}}" alt="image description" class="mCS_img_loaded">
								</figure>
								<div class="wt-insightdetails">
									<div class="wt-title">
										<h3>Check Package Expiry</h3>
										<a href="javascript:void(0)">Click To View</a>
									</div>													
								</div>	
							</div>
						</div> -->						
						<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
							<div class="wt-insightsitem wt-dashboardbox">
								<figure class="wt-userlistingimg">
									<img src="{{asset('assets/images/thumbnail/img-22.png')}}" alt="image description" class="mCS_img_loaded">
								</figure>
								<div class="wt-insightdetails">
									<div class="wt-title">
										<h3>View Saved Items</h3>
										<a href="{{ route('freelancers.saved-items') }}">Click To View</a>
									</div>													
								</div>
							</div>
						</div>
					</div>
				</section>
			<!--More Details End-->
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/js/croppie.js') }}"></script>
<script src="{{ URL::asset('assets/js/chart.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script>
	var ctx = document.getElementById("wt-jobchart");
	var wt_jobchart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ["Jan", "Feb", "Mar", "Apr", "May", 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'],
	        datasets: [{
	            label: 'Total Jobs',
	            
	            data: [ 0,0, 0, 0, 0, 0,0, 0, 0, 0,0,0],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255,99,132,1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true,
	                    fontSize:12,
	                    fontColor:'#767676'
	                }
	            }]
	        },
	        legend: {
	            labels: {
	                fontSize:14,
	                fontColor: '#767676',
	                FontFamily:'Open Sans',
	                
	            }
	        }
	    }
	});
</script>
@endsection