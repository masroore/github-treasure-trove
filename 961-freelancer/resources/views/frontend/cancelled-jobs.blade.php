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
			@if(Auth::user()->account_type == 'Client')
			<section class="wt-haslayout wt-dbsectionspace wt-proposals">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>All Jobs</h2>
							</div>
							<div class="wt-dashboardboxcontent wt-canceljobholder">
								<div class="wt-completejobholder">
									<div class="wt-tabscontenttitle">
										<h2>Cancelled Jobs</h2>
									</div>
									<div class="wt-managejobcontent  wt-verticalscrollbar">
										@if(count($clientCancelledJobs) > 0)
										@foreach($clientCancelledJobs as $job)
										<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
											<div class="wt-contenthead">
												<div class="wt-title">
													<a href="javascript:void(0)"><i class="fa fa-check-circle"></i> {{$job->clientInfo->first_name}} {{$job->clientInfo->last_name}}</a>
													<h2>{{$job->job_title}}</h2>
												</div>
												<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
													<li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{$job->service_level}}</span></li>
													<li><span class="wt-dashboradclock"><i class="fal fa-map-marker-alt"></i> {{$job->job_location}}</span></li>
													<li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> Type: {{$job->job_type}}</a></li>
													<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> Duration: {{$job->job_duration}}</span></li>				
												</ul>
											</div>
											<div class="wt-rightarea">
												<div class="wt-btnarea">
													
														<input type="hidden" name="id" value="{{$job->id}}">
														<a class="wt-btn" href="javascript:void(0);" onclick="repostJob({{$job->id}})">Repost</a>
													
														<a class="wt-cancelbtn" href="javascript:void(0);" onclick="deleteBatch({{$job->id}})">Delete</a>
												</div>
											</div>
										</div>
										@endforeach
										@else
										<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
											<div class="wt-userlistingcontent wt-userlistingcontentvtwo">
												<div class="wt-contenthead">
													<h4>You don't have any cancelled job yet.</h4>
												</div>
											</div>
										</div>
										@endif
									</div>
								</div>
							</div>
							{{ $clientCancelledJobs->links('frontend.pagination.manage-jobs') }}									
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
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
					</div>
				</div>
			</section>
			@endif
			@if(Auth::user()->account_type == 'Freelancer')
			<section class="wt-haslayout wt-dbsectionspace wt-proposals">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>All Jobs</h2>
							</div>
							<div class="wt-dashboardboxcontent wt-jobdetailsholder">
								<div class="wt-completejobholder">
									<div class="wt-tabscontenttitle">
										<h2>Cancelled Jobs</h2>
									</div>
									<div class="wt-managejobcontent">
										@if(count($freelancerCancelledJobs) > 0)
										@foreach($freelancerCancelledJobs as $completejob)
										<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
											<div class="wt-userlistingcontent wt-userlistingcontentvtwo">
												<div class="wt-contenthead">
													<div class="wt-title">
														<a href="javascript:void(0)"><i class="fa fa-check-circle"></i> {{App\Models\Job::client($completejob->job->user_id)->first_name}} {{App\Models\Job::client($completejob->job->user_id)->last_name}}
														</a>
														<h2>{{$completejob->job->job_title}}</h2>
													</div>
													<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
														<li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{$completejob->job->service_level}}</span></li>
														<li><span class="wt-dashboradclock"><i class="fal fa-map-marker-alt"></i> {{$completejob->job->job_location}}</span></li>
														<li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> Type: {{$completejob->job->job_type}}</a></li>
														<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> Duration: {{$completejob->job->job_duration}}</span></li>															
													</ul>
												</div>
												<div class="wt-rightarea">
													<div class="wt-btnarea">
														<!-- <span> Project Complete</span> -->
														<a href="{{url('job-detail/'.$completejob->job->job_id)}}" class="wt-btn">VIEW DETAILS</a>
													</div>
													
												</div>
											</div>	
										</div>
										@endforeach
										@else
										<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
											<div class="wt-userlistingcontent wt-userlistingcontentvtwo">
												<div class="wt-contenthead">
													<h4>You don't have any Cancelled or Rejected job yet.</h4>
												</div>
											</div>
										</div>
										@endif
									</div>
								</div>
							</div>
							{{ $freelancerCancelledJobs->links('frontend.pagination.manage-jobs') }}									
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
						<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-17.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Proposal::freelancerOngoingCount(Auth::user()->id)}}</h3>
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
										<h3>{{App\Models\Proposal::freelancerCompletedCount(Auth::user()->id)}}</h3>
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
										<h3>{{App\Models\Proposal::freelancerCancelledCount(Auth::user()->id)}}</h3>
										<span>Total Cancelled Jobs</span>
									</div>
								</div> 
							</div>								
						</aside>
					</div>
				</div>
			</section>
			@endif
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
<div class="modal" id="deleteModel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-demo">
      <div class="modal-header">
        <h6 class="modal-title">Alert</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="deleteData" > 
        @csrf
         @method('DELETE')
      <input type="hidden" name="projectId" id="projectId">
      <div class="modal-body">
        <h6></h6>
        <p>Are you sure you want to delete the record ?</p>
      </div>
      <div class="modal-footer">
        <button class="btn ripple btn-danger" id="confirmDelete" type="submit"> Delete </button>
        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
      </div>
       </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	function repostJob(id){
		// alert(id);
	  $.ajax({
	      url: "{{url('job')}}/"+id,
	      type: 'PATCH',
	      data: {'id':id},
	      // contentType: false,
	      processData: false,

	      success: (response)=>{
	          if (response.status == 'true') {
	              $.notify(response.message , 'success'  );
	                window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/cancelled-jobs";
	              
	              
	          }else{
	              $.notify(response.message , 'error');

	          }
	      },
	      error: (errorResponse)=>{
	          $.notify( errorResponse, 'error'  );


	      }
	  })
	}

	$('#deleteData').on('submit' , function(event){
	  event.preventDefault();
	  var data = $("#deleteData").serialize();
	  $projectId = $("#projectId").val();
	  console.log($projectId)

	     $.ajax({
	      url: "{{url('job')}}/"+$projectId,
	      type: 'DELETE',
	      data: data,
	      processData: false,

	      success: (response)=>{
	          
	          if (response.status == 'true') {

	              $.notify(response.message , 'success'  );
	              window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/cancelled-jobs";

	          }else{
	              $.notify(response.message , 'error');

	          }
	      },
	      error: (errorResponse)=>{
	          $.notify( errorResponse, 'error'  );


	      }
	  })

	});

	function deleteBatch(id) {
	  $("#deleteModel").modal('show');
	  $("#projectId").val(id);
	}
</script>
@endsection